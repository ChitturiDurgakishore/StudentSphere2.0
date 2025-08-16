<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\Registration;
use App\Models\Subject;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function UsersData(Request $req)
    {

        $OneStudents = Registration::where('role', 'student')->where('year', 1)->get();
        $OneCrs = Registration::where('role', 'cr')->where('year', 1)->get();
        $TwoStudents = Registration::where('role', 'student')->where('year', 2)->get();
        $TwoCrs = Registration::where('role', 'cr')->where('year', 2)->get();
        $ThreeStudents = Registration::where('role', 'student')->where('year', 3)->get();
        $ThreeCrs = Registration::where('role', 'cr')->where('year', 3)->get();
        $FourStudents = Registration::where('role', 'student')->where('year', 4)->get();
        $FourCrs = Registration::where('role', 'cr')->where('year', 4)->get();
        return view('admin.UserView', compact(
            'OneStudents',
            'OneCrs',
            'TwoStudents',
            'TwoCrs',
            'ThreeStudents',
            'ThreeCrs',
            'FourStudents',
            'FourCrs'
        ));
    }

    public function demoteCR($id)
    {
        $cr = Registration::findOrFail($id);

        if ($cr->role !== 'cr') {
            return redirect()->back()->with('error', 'User is not a CR.');
        }

        $cr->role = 'student';
        $cr->save();

        return redirect()->back()->with('success', 'CR has been demoted to student.');
    }
    public function viewUsers(Request $request)
    {
        $query = $request->input('query'); // search input

        $students = Registration::where('role', 'student')
            ->when($query, function ($q) use ($query) {
                $q->where('rollno', 'like', "%$query%");
            })->get();

        $crs = Registration::where('role', 'cr')
            ->when($query, function ($q) use ($query) {
                $q->where('rollno', 'like', "%$query%");
            })->get();

        return view('admin.UserView', compact('students', 'crs'));
    }
    public function promoteStudent($id)
    {
        $student = Registration::findOrFail($id);

        if ($student->role !== 'student') {
            return redirect()->back()->with('error', 'User is not a student.');
        }

        $student->role = 'cr';
        $student->save();

        return redirect()->back()->with('success', 'Student has been promoted to CR.');
    }

    // ==============================================================================================================
    // SUbjects Functions

    public function SubjectsData(Request $req)
    {
        $one = Subject::where('year', 1)->get();
        $two = Subject::where('year', 2)->get();
        $three = Subject::where('year', 3)->get();
        $four = Subject::where('year', 4)->get();
        return view('admin.subjects', ['one' => $one, 'two' => $two, 'three' => $three, 'four' => $four]);
    }

    public function UploadedFilesData(Request $req)
    {
        $one = FileUpload::join('registration', 'file_uploads.uploaded_by', '=', 'registration.id')
            ->where('file_uploads.year', 1)
            ->select('file_uploads.*', 'registration.name as uploader_name')
            ->get();

        $two = FileUpload::join('registration', 'file_uploads.uploaded_by', '=', 'registration.id')
            ->where('file_uploads.year', 2)
            ->select('file_uploads.*', 'registration.name as uploader_name')
            ->get();

        $three = FileUpload::join('registration', 'file_uploads.uploaded_by', '=', 'registration.id')
            ->where('file_uploads.year', 3)
            ->select('file_uploads.*', 'registration.name as uploader_name')
            ->get();

        $four = FileUpload::join('registration', 'file_uploads.uploaded_by', '=', 'registration.id')
            ->where('file_uploads.year', 4)
            ->select('file_uploads.*', 'registration.name as uploader_name')
            ->get();

        return view('admin.files', compact('one', 'two', 'three', 'four'));
    }

    public function deleteFileDb($id)
    {
        $file = FileUpload::find($id);

        if ($file) {
            $file->delete();
            return back()->with('success', 'File deleted from Database successfully ✅');
        }

        return back()->with('error', 'File not found ❌');
    }
}
