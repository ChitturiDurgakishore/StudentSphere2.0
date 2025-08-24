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

    public function MaterialsData(Request $req)
    {
        $branch = session('branch');
        $year = session('year');

        if (!$branch || !$year) {
            return redirect()->back()->with('error', 'Year or branch not set in session.');
        }

        // Start query for files
        $query = FileUpload::query();

        // Join registration to get uploader name
        $query->leftJoin('registration', 'file_uploads.uploaded_by', '=', 'registration.id')
            ->addSelect('file_uploads.*', 'registration.name as uploader_name');

        // Join subjects to get subject name
        $query->leftJoin('subjects', 'file_uploads.subject_id', '=', 'subjects.id')
            ->addSelect('subjects.subject_name');

        // Join file_types to get file type name
        $query->leftJoin('file_types', 'file_uploads.file_type_id', '=', 'file_types.id')
            ->addSelect('file_types.file_type as file_type_name');

        // Filter by branch and year
        $query->where('file_uploads.branch', $branch)
            ->where('file_uploads.year', $year);

        // Optional filters from request (subject, type, unit)
        if ($req->subject_id) {
            $query->where('file_uploads.subject_id', $req->subject_id);
        }
        if ($req->file_type_id) {
            $query->where('file_uploads.file_type_id', $req->file_type_id);
        }
        if ($req->unit) {
            $query->where('file_uploads.unit', $req->unit);
        }

        $files = $query->get();

        // Get all subjects and file types for the filter form
        $subjects = Subject::where('year', $year)->where('branch', $branch)->get();
        $fileTypes = FileType::all();

        return view('cr.materials', [
            'files' => $files,
            'subjects' => $subjects,
            'fileTypes' => $fileTypes
        ]);
    }
    public function PreviousMaterials(Request $req)
    {
        $query = FileUpload::join('registration', 'file_uploads.uploaded_by', '=', 'registration.id')
            ->select('file_uploads.*', 'registration.name as uploader_name');

        if ($req->subject_id) {
            $query->where('file_uploads.subject_id', $req->subject_id);
        }

        if ($req->branch) {
            $query->where('file_uploads.branch', $req->branch);
        }

        if ($req->file_type_id) {
            $query->where('file_uploads.file_type_id', $req->file_type_id);
        }

        $allFiles = $query->get();

        $one = $allFiles->where('year', 1);
        $two = $allFiles->where('year', 2);
        $three = $allFiles->where('year', 3);
        $four = $allFiles->where('year', 4);

        $subjects = Subject::all();
        $filetypes = FileType::all();
        $branches = ['CSD','CSE', 'ECE', 'EEE', 'MECH', 'CIVIL']; // example

        return view('cr.previousmaterials', compact('one', 'two', 'three', 'four', 'subjects', 'filetypes', 'branches'));
    }
}
