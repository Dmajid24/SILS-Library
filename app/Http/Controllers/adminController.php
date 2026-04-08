<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\User;
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

        return back()->with('success','User deleted');
    }

    public function createInfo(){
        if(Auth()->user()->role !== 'lecturer'&& Auth()->user()->role !== 'admin'){
                    abort(403);
        }
        return view('user.lecture.create');
    }

    
}