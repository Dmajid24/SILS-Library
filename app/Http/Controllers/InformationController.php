<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\information;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
   
    public function index()
        {
            $user = Auth::user();

            $yourInfo = Information::where('creator_id', $user->id)
                ->where('school_id', $user->school_id)
                ->latest()
                ->paginate(5, ['*'], 'your_page')
                ->withQueryString();

            $info = Information::where('school_id', $user->school_id)
                ->where('creator_id', '!=', $user->id)
                ->latest()
                ->paginate(5, ['*'], 'info_page')
                ->withQueryString();

            return view('admin.information.index', compact('info', 'yourInfo'));
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
        $user = Auth::user();

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

        Information:: create([
            'creator_id' => $user->id,
            'school_id' => $user->school_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_content' => $imagePath,
        ]);

        
             return redirect()->route('admin.information.index')
            ->with('success','Information created successfully 🎉');

       
    }

    public function edit($id)
    {
        $information = Information::findOrFail($id);
        $user = Auth::user();


        if(($user->role !== 'lecturer' && $information->creator_id !== $user->id  ) && $user->role !== 'admin'    ){
            abort(403);
        }


        return view('user.lecture.edit', compact('information'));
    }

    public function update(Request $request, $id)
    {
        $information = Information::findOrFail($id);

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
    $user = Auth::user();

    if (
        ($user->role !== 'lecturer' && $information->creator_id !== $user->id)
        && $user->role !== 'admin'
    ) {
        abort(403);
    }

    if ($information->image_content) {
        Storage::disk('public')->delete($information->image_content);
    }

    $information->delete();

    $page = request()->get('page', 1);

    $total = \App\Models\Information::count();
    $perPage = 10; 

    $lastPage = max(1, (int) ceil($total / $perPage));

    if ($page > $lastPage) {
        $page = $lastPage;
    }

    return redirect()->route('admin.information.index', [
        'page' => $page
    ])->with('success', 'Information Deleted successfully 🎉');
}
}