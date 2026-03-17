<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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