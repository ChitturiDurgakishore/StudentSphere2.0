<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Google\Service\Drive\DriveFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleDriveService
{
    protected GoogleClient $client;
    protected ?GoogleDrive $driveService = null;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->addScope(GoogleDrive::DRIVE_FILE);
        $this->client->setAccessType('offline');
    }

    protected function ensureAuthenticated(): void
    {
        $user = Auth::user();

        if (!$user || !$user->google_access_token) {
            throw new \RuntimeException('Google account not connected.');
        }

        // Refresh token if expired
        $expired = !$user->google_token_expires_at || now()->greaterThanOrEqualTo($user->google_token_expires_at->subSeconds(30));

        if ($expired && $user->google_refresh_token) {
            $new = $this->client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
            if (isset($new['error'])) {
                Log::error('Failed to refresh Google token', $new);
                throw new \RuntimeException('Failed to refresh Google token.');
            }

            $user->google_access_token = $new['access_token'] ?? $user->google_access_token;
            $user->google_token_expires_at = now()->addSeconds($new['expires_in'] ?? 3600);
            if (!empty($new['refresh_token'])) {
                $user->google_refresh_token = $new['refresh_token'];
            }
            $user->save();
        }

        $this->client->setAccessToken([
            'access_token' => $user->google_access_token,
            'expires_in' => max(1, now()->diffInSeconds($user->google_token_expires_at, false)),
            'created' => now()->subHour()->timestamp,
        ]);

        $this->driveService = new GoogleDrive($this->client);
    }

    public function uploadFile(UploadedFile $file, ?string $folderId = null): array
    {
        $this->ensureAuthenticated();

        $driveFile = new DriveFile();
        $driveFile->setName($file->getClientOriginalName());
        if ($folderId) $driveFile->setParents([$folderId]);

        $createdFile = $this->driveService->files->create($driveFile, [
            'data' => file_get_contents($file->getRealPath()),
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id,name,webViewLink',
        ]);

        // Make public
        $this->driveService->permissions->create($createdFile->id, new \Google\Service\Drive\Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]));

        return [
            'id' => $createdFile->id,
            'link' => 'https://drive.google.com/file/d/'.$createdFile->id.'/view',
        ];
    }

    public function deleteFile(string $fileId): void
    {
        $this->ensureAuthenticated();
        $this->driveService->files->delete($fileId);
    }

    /**
     * ✅ Replace old file by creating a new one and deleting the old one
     */
    public function replaceFileWithNew(UploadedFile $file, string $oldFileId): array
    {
        $this->ensureAuthenticated();

        // 1️⃣ Upload new file
        $newFile = $this->uploadFile($file);

        // 2️⃣ Delete old file from Drive
        $this->deleteFile($oldFileId);

        // 3️⃣ Return new file info (id + link)
        return $newFile;
    }
}
