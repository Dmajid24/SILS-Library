<?php

namespace App\Http\Controllers;


use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function create()
    {
        return view('superAdmin.school.create');
    }

     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'address' => 'required',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'description' => 'nullable'
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('schools','public');
        }

        School::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'logo' => $logoPath,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('superAdmin.dashboard')
            ->with('success','School created successfully!');
    }
    public function edit(School $school)
    {
        return view('superAdmin.school.edit', compact('school'));
    }

    public function show(School $school)
    {
        return view('superAdmin.school.detail', compact('school'));
    }
    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'description' => 'nullable',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except('logo');

        // upload logo baru
        if ($request->hasFile('logo')) {

            // hapus logo lama
            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }

            $data['logo'] = $request->file('logo')
                ->store('schools', 'public');
        }

        $school->update($data);

        return redirect()
            ->route('superAdmin.dashboard')
            ->with('success','School updated successfully');
    }


    public function destroy(School $school)
    {
        // delete logo
        if ($school->logo) {
            Storage::disk('public')->delete($school->logo);
        }

        $school->delete();

        return redirect()
            ->route('superAdmin.dashboard')
            ->with('success','School deleted successfully');
    }
}