<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\School;
use App\Models\StudentProfile;
use App\Models\LecturerProfile;
use App\Models\StaffProfile;
use App\Models\borrowings;
use Illuminate\Support\Facades\Auth;


class adminController extends Controller
{
    
   public function showBorrow($id)
{
    $borrowing = Borrowings::with([
        'book',
        'user'
    ])->findOrFail($id);

    // hanya admin
    if(auth()->user()->role !== 'admin'){
        abort(403);
    }

    return view('admin.borrowings.detail', compact('borrowing'));
} 

    public function indexUser(Request $request)
    {

        $users = User::query()
            ->when($request->search,function($q) use($request){
                $q->where('first_name','like','%'.$request->search.'%')
                  ->orWhere('last_name','like','%'.$request->search.'%')
                  ->orWhere('email','like','%'.$request->search.'%');
            })
            ->where('school_id',Auth::user()->school_id )
            ->paginate(10);

        return view('admin.users.index',compact('users'));
    }

    public function createUser(){

        return view ('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $schoolId = auth()->user()->school_id;

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            // ===== USER =====
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['nullable','string','max:100'],
            'email'      => ['required','email','max:255','unique:users,email'],
            'phone'      => ['nullable','string','max:20'],
            'password'   => ['required','min:6'],
            'role'       => ['required','in:student,lecturer,staff,admin'],

            // ===== STUDENT =====
            'nim' => [
                Rule::requiredIf($request->role === 'student'),
                'nullable',
                'string',
                'max:20',
                Rule::unique('student_profiles')
                    ->where(fn ($q) =>
                        $q->where('school_id', $schoolId)
                    )
            ],

            'major'   => Rule::requiredIf($request->role === 'student'),
            'faculty' => Rule::requiredIf($request->role === 'student'),

            // ===== LECTURER =====
            'nip' => [
                Rule::requiredIf($request->role === 'lecturer'),
                'nullable',
                'string',
                Rule::unique('lecturer_profiles')
                    ->where(fn ($q) =>
                        $q->where('school_id', $schoolId)
                    )
            ],

            'degree'     => Rule::requiredIf($request->role === 'lecturer'),
            'department' => Rule::requiredIf($request->role === 'lecturer'),

            // ===== STAFF =====
            'employee_id' => [
                Rule::requiredIf($request->role === 'staff'),
                'nullable',
                'string',
                Rule::unique('staff_profiles')
                    ->where(fn ($q) =>
                        $q->where('school_id', $schoolId)
                    )
            ],

            'job_position' => Rule::requiredIf($request->role === 'staff'),
        ]);



        /*
        |--------------------------------------------------------------------------
        | DATABASE TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($request, $schoolId) {

            /*
            |--------------------------------------------------
            | CREATE USER
            |--------------------------------------------------
            */
            $user = User::create([
                'school_id' => $schoolId,
                'first_name'=> $request->first_name,
                'last_name' => $request->last_name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'role'      => $request->role,
                'password'  => Hash::make($request->password),
            ]);


            /*
            |--------------------------------------------------
            | CREATE PROFILE BASED ON ROLE
            |--------------------------------------------------
            */

            switch ($request->role) {

                case 'student':

                    StudentProfile::create([
                        'user_id'  => $user->id,
                        'school_id'=> $schoolId,
                        'nim'      => $request->nim,
                        'major'    => $request->major,
                        'faculty'  => $request->faculty,
                    ]);

                    break;


                case 'lecturer':

                    LecturerProfile::create([
                        'user_id'   => $user->id,
                        'school_id' => $schoolId,
                        'nip'       => $request->nip,
                        'degree'    => $request->degree,
                        'department'=> $request->department,
                    ]);

                    break;


                case 'staff':

                    StaffProfile::create([
                        'user_id'     => $user->id,
                        'school_id'   => $schoolId,
                        'employee_id' => $request->employee_id,
                        'job_position'=> $request->job_position,
                        'department'  => $request->department,
                    ]);

                    break;
            }
        });


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    public function editUser(User $user ){

        return view('admin.users.edit',compact('user'));
    }


    public function updateUser(Request $request, User $user)
    {

       $data = $request->validate([
        'first_name'=>'required',
        'last_name'=>'required',
        'email'=>'required|email',
        'role'=>'required'
    ]);

    $user->update($data);

    return redirect()
        ->route('admin.users.index')
        ->with('success','User updated');
    }

    public function destroyUser(User $user)
    {
        $user->delete();

        $page = request()->get('page', 1);

        $totalUsers = \App\Models\User::count();
        $perPage = 10; // samakan dengan paginate() di indexUser

        $lastPage = max(1, (int) ceil($totalUsers / $perPage));

        if ($page > $lastPage) {
            $page = $lastPage;
        }

        return redirect()->route('admin.users.index', [
            'page'   => $page,
            'search' => request('search')
        ])->with('success', 'User deleted');
    }

    public function createInfo(){
        if(Auth()->user()->role !== 'lecturer'&& Auth()->user()->role !== 'admin'){
                    abort(403);
        }
        return view('user.lecture.create');
    }

    
    public function downloadTemplate($role)
{
    $filename = $role . '_template.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="'.$filename.'"',
    ];

    $callback = function() use ($role){

        $file = fopen('php://output', 'w');

        if($role == 'student'){
            fputcsv($file, ['nim','name','major','faculty']);
            fputcsv($file, ['240001','Budi Santoso','RPL','Teknik Informatika']);
        }

        if($role == 'lecturer'){
            fputcsv($file, ['nip','name','degree','department']);
            fputcsv($file, ['1987001','Ahmad Fauzi','S.Kom','Computer Science']);
        }

        if($role == 'staff'){
            fputcsv($file, ['employee_id','name','job_position','department']);
            fputcsv($file, ['ST001','Andi Saputra','Librarian','Library']);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
public function importPreview(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt',
        'role' => 'required|in:student,lecturer,staff'
    ]);

    $role = $request->role;
    $expectedHeaders = [
        'student'  => ['nim','name','major','faculty'],
        'lecturer' => ['nip','name','degree','department'],
        'staff'    => ['employee_id','name','job_position','department'],
    ];

    $file = fopen($request->file('file'), 'r');
    $headers = fgetcsv($file);

    if (!$headers) {
        return back()->withErrors(['file' => 'CSV file is empty.']);
    }

    $headers = array_map(fn($h) => strtolower(trim($h)), $headers);

    if ($headers !== $expectedHeaders[$role]) {
        return back()->withErrors(['file' => 'CSV template does not match selected role.']);
    }

    $rows = [];
    $line = 2;

    while (($row = fgetcsv($file, 1000, ",")) !== false) {
        if(count($row) < 4) {
            $rows[] = [
                'line' => $line, 'data' => $row, 'status' => 'Invalid Row', 'message' => 'Column count mismatch'
            ];
            $line++;
            continue;
        }

        $idNumber = trim($row[0]);
        $name     = trim($row[1]);
        $field1   = trim($row[2]);
        $field2   = trim($row[3]);

        $email = $idNumber . '@AL-IRSYAD.co.id';
        $exists = User::where('email', $email)->exists();

        $rows[] = [
            'line' => $line,
            'id_number' => $idNumber,
            'name' => $name,
            'field1' => $field1,
            'field2' => $field2,
            'role' => $role,
            'data' => $row,
            'status' => $exists ? 'Duplicate' : 'Ready',
            'message' => $exists ? 'Already exists' : 'Ready to import'
        ];
        $line++;
    }
    fclose($file);

    // SIMPAN KE SESSION
    session([
        'import_rows' => $rows,
        'import_role' => $role
    ]);

    // REDIRECT KE GET ROUTE
    return redirect()->route('admin.users.import.preview.show');
}

// FUNGSI BARU UNTUK MENAMPILKAN VIEW (GET METHOD)
public function showPreview()
{
    $rows = session('import_rows');
    $role = session('import_role');

    if (!$rows) {
        return redirect()->route('admin.users.index')->with('error', 'No preview data found. Please re-upload.');
    }

    return view('admin.users.preview.preview', compact('rows', 'role'));
}
public function importConfirm()
{
    $rows = session('import_rows', []);
    $role = session('import_role');

    $success = 0;

    foreach($rows as $row){

        if($row['status'] == 'Duplicate'){
            continue;
        }

        $raw = $row['data'];

        $id = $raw[0];
        $name = $raw[1];

        $split = explode(' ', $name);
        $first = $split[0];
        $last = count($split) > 1 ? implode(' ', array_slice($split,1)) : null;

        $user = User::create([
            'id' => Str::uuid(),
            'school_id' => auth()->user()->school_id,
            'first_name' => $first,
            'last_name' => $last,
            'email' => $id.'@AL-IRSYAD.co.id',
            'password' => Hash::make($id),
            'role' => $role,
        ]);

        $success++;
    }

    session()->forget(['import_rows','import_role']);

    return redirect()
        ->route('admin.users.index')
        ->with('success','Imported '.$success.' users successfully');
}
    public function importUser(Request $request){
        $request->validate([
        'file' => 'required|mimes:csv,txt',
        'role' => 'required'
    ]);

    $role = $request->role;

    $file = fopen($request->file('file'), 'r');
    fgetcsv($file);

    $success = 0;
    $failed = 0;
    $errors = [];

    while (($row = fgetcsv($file, 1000, ",")) !== false) {

        $idNumber = trim($row[0]);
        $name = trim($row[1]);

        $email = $idNumber . '@AL-IRSYAD.co.id';

        if(User::where('email',$email)->exists()){
            $failed++;
            $errors[] = "$idNumber skipped (already exists)";
            continue;
        }

        $split = explode(' ', $name);
        $first = $split[0];
        $last = count($split) > 1 ? implode(' ', array_slice($split,1)) : null;

        $user = User::create([
            'id' => Str::uuid(),
            'school_id' => auth()->user()->school_id,
            'first_name' => $first,
            'last_name' => $last,
            'email' => $email,
            'password' => Hash::make($idNumber),
            'role' => $role,
        ]);

        if($role == 'student'){

            StudentProfile::create([
                'user_id' => $user->id,
                'nim' => $row[0],
                'major' => $row[2],
                'faculty' => $row[3],
            ]);

        }

        if($role == 'lecturer'){

            LectureProfile::create([
                'user_id' => $user->id,
                'nip' => $row[0],
                'degree' => $row[2],
                'department' => $row[3],
            ]);

        }

        if($role == 'staff'){

            StaffProfile::create([
                'user_id' => $user->id,
                'employee_id' => $row[0],
                'job_position' => $row[2],
                'staff_department' => $row[3],
            ]);

        }

        $success++;
    }

    fclose($file);

    return back()->with([
        'success_count' => $success,
        'failed_count' => $failed,
        'import_errors' => $errors
    ]);
    }

    
}