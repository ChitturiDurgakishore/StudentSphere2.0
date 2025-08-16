<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use App\Models\FileUpload;
use App\Models\Subject;
use App\Models\FileType;

class StudentController extends Controller
{
    public function Registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:registration,email',
            'rollno' => 'required|string|unique:registration,rollno',
            'password' => 'required|string|min:6',
            'year' => 'required|string',
            'branch' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }


        $user = Registration::create([
            'name' => $request->name,
            'email' => $request->email,
            'rollno' => $request->rollno,
            'password' => Hash::make($request->password),
            'role' => 'student', // default role
            'year' => $request->year,
            'branch' => $request->branch,
        ]);

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Registration successful',
        //     'user' => $user
        // ]);
        return redirect('/login');
    }

    public function Login(Request $request)
    {
        $request->validate([
            'rollno' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // Attempt login using rollno and password
        if (Auth::attempt(['rollno' => $request->rollno, 'password' => $request->password])) {
            $user = Auth::user(); // authenticated user

            // Store all user details in session
            session([
                'user_id'   => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'rollno'    => $user->rollno,
                'role'      => $user->role,
                'year'      => $user->year ?? null,
                'branch'    => $user->branch ?? null,
            ]);

            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'cr':
                    return redirect()->route('cr.dashboard');
                default:
                    return redirect()->route('student.dashboard');
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid roll number or password'
        ], 401);
    }


    public function Logout(Request $request)
    {
        Auth::logout();             // Logs out the user
        $request->session()->invalidate();  // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/login')->with('success', 'You have been logged out.');
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

        return view('student.materials', [
            'files' => $files,
            'subjects' => $subjects,
            'fileTypes' => $fileTypes
        ]);
    }
}
