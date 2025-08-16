<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\FileUpload;
use App\Models\FileType;
use App\Services\GoogleDriveService;
use Illuminate\Support\Facades\Log;

class CrController extends Controller
{
    protected GoogleDriveService $driveService;

    public function __construct(GoogleDriveService $driveService)
    {
        $this->driveService = $driveService;
    }

    // Upload page
    public function UploadPage()
    {
        $year = session('year');
        $branch = session('branch');

        $subjects = Subject::where('year', $year)
            ->where('branch', $branch)
            ->get();

        $fileTypes = FileType::all();
        return view('cr.Upload', compact('subjects', 'fileTypes'));
    }

    // Upload file
    public function UploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'subject_id' => 'required|integer',
            'file_type' => 'required|string',
            'unit' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        try {
            $uploadResult = $this->driveService->uploadFile($request->file('file'));

            FileUpload::create([
                'subject_id' => $request->subject_id,
                'description' => $request->description,
                'branch' => session('branch'),
                'year' => session('year'),
                'file_type' => $request->file_type,
                'unit' => $request->unit,
                'uploaded_by' => auth()->id(),
                'google_file_id' => $uploadResult['id'],
                'file_link' => $uploadResult['link'],
            ]);

            return redirect()->back()->with('success', 'File uploaded successfully!');
        } catch (\RuntimeException $e) {
            return redirect()->route('google.login')->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('File upload failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    // List uploaded files
    public function UploadedFilesCheck()
    {
        $userId = auth()->id();
        $year = session('year');
        $branch = session('branch');

        $files = FileUpload::where('year', $year)
            ->where('branch', $branch)
            ->where('uploaded_by', $userId)
            ->get();

        return view('cr.Uploaded', ['subjects' => $files]);
    }

    // Delete file
    public function deleteFile($id)
    {
        try {
            $file = FileUpload::findOrFail($id);
            $this->driveService->deleteFile($file->google_file_id);
            $file->delete();

            return redirect()->back()->with('success', 'File deleted successfully!');
        } catch (\RuntimeException $e) {
            return redirect()->route('google.login')->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    // Replace file
    // Replace file
    public function replaceFile(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        try {
            $fileUpload = FileUpload::findOrFail($id);

            // ✅ Use new service method that creates a new file and deletes the old one
            $uploadResult = $this->driveService->replaceFileWithNew(
                $request->file('file'),          // new file
                $fileUpload->google_file_id      // old file ID
            );

            // Update DB with new file info
            $fileUpload->update([
                'google_file_id' => $uploadResult['id'],
                'file_link' => $uploadResult['link'],
            ]);

            return redirect()->back()->with('success', 'File replaced successfully!');
        } catch (\RuntimeException $e) {
            return redirect()->route('google.login')->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Replace failed: ' . $e->getMessage());
        }
    }
}
