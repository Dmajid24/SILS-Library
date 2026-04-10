<?php

namespace App\Http\Controllers;


use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    

        public function edit()
    {
        // karena 1 deployment = 1 school
        $school = School::first();

        return view('admin.school.edit', compact('school'));
    }
    public function update(Request $request)
    {
        $school = School::first();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // upload logo
        if($request->hasFile('logo')){
            $validated['logo'] =
                $request->file('logo')->store('school','public');
        }

        $school->update($validated);

        return back()->with('success','School updated successfully ✅');
    }



    public function destroy(School $school)
    {
        // delete logo
        if ($school->logo) {
            Storage::disk('public')->delete($school->logo);
        }

        $school->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success','School deleted successfully');
    }
}