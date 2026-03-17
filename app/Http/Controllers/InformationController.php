<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\information;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
   
    public function index(){
        $user=Auth::user();
        $info = information::where('school_id',$user->school_id)->get();

        return view('admin.information.index',compact('info'));
    }
    public function create(){
        if(Auth()->user()->role !== 'lecturer'&& Auth()->user()->role !== 'admin'){
            abort(403);
        }
        return view('user.lecture.create');
    }

    public function store(Request $request)
    {
        if(Auth()->user()->role !== 'lecturer' && Auth()->user()->role !== 'admin'){
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // upload image (optional)
        $imagePath = null;

        if($request->hasFile('image')){
            $imagePath = $request->file('image')
                ->store('information','public');
        }

        Information::   create([
            'creator_id' => Auth::id(),
            'school_id' => Auth::user()->school_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_content' => $imagePath,
        ]);

        if(Auth()->user()->role === 'lecturer'){
             return redirect()->route('dashboard')
            ->with('success','Information created successfully 🎉');
        }else{
             return redirect()->route('admin.information.index')
            ->with('success','Information created successfully 🎉');
        }
       
    }

    public function edit($id)
    {
        $information = Information::findOrFail($id);

         if((auth()->user()->role !== 'lecturer' && $information->creator_id !== auth()->id()  ) || auth()->user()->role !== 'admin'    ){
            abort(403);
        }


        return view('user.lecture.edit', compact('information'));
    }

    public function update(Request $request, $id)
    {
        $information = Information::findOrFail($id);

         if((auth()->user()->role !== 'lecturer' && $information->creator_id !== auth()->id()  ) || auth()->user()->role !== 'admin'    ){
            abort(403);
        }


        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // replace image jika upload baru
        if($request->hasFile('image')) {

            if($information->image_content){
                Storage::disk('public')
                    ->delete($information->image_content);
            }

            $validated['image_content'] =
                $request->file('image')
                    ->store('information','public');
        }

        $information->update($validated);

        return redirect()->route('information.show',$id)
            ->with('success','Information updated ✅');
    }
    public function destroy($id)
    {
        $information = Information::findOrFail($id);

        if((auth()->user()->role !== 'lecturer' && $information->creator_id !== auth()->id()  ) || auth()->user()->role !== 'admin'    ){
            abort(403);
        }

        if($information->image_content){
            Storage::disk('public')
                ->delete($information->image_content);
        }

        $information->delete();

         if(Auth()->user()->role === 'lecturer'){
             return redirect()->route('dashboard')
            ->with('success','Information Deleted successfully 🎉');
        }else{
             return redirect()->route('admin.information.index')
            ->with('success','Information Deleted successfully 🎉');
        }
    }
}