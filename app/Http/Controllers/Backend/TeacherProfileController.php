<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\TeacherProfile;

class TeacherProfileController extends Controller
{
    public function index()
    {
        $profiles = TeacherProfile::paginate(env('MAX_RECORD_PER_PAGE',25));
        return view('backend.site.teacher.list', compact('profiles'));
    }

    public function create(Request $request)
    {
        $profile = null;
        return view('backend.site.teacher.add', compact('profile'));
    }

    public function store(Request $request)
    {
        //validate form
        $messages = [
            'image.max' => 'The :attribute size must be under 2MB.',
            'image.dimensions' => 'The :attribute dimensions must be minimum 210 X 220.',
        ];
        $this->validate($request, [
            'name' => 'required|min:5|max:255',
            'image' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=210,min_height=220',
            'designation' => 'required|min:5|max:255',
            'qualification' => 'required|min:1|max:255',
            'description' => 'max:255',
            'facebook' => 'max:255',
            'google' => 'max:255',
            'twitter' => 'max:255',
        ], $messages);

        $fileName = null;
        if($request->hasFile('image')) {
            $storagepath = $request->file('image')->store('public/teacher_profile');
            $fileName = basename($storagepath);
        }


        $data = $request->all();
        $data['image'] = $fileName;

        TeacherProfile::create($data);

        return redirect()->back()->with('success', 'New teacher profile created.');
    }

    public function edit($id)
    {
        $profile = TeacherProfile::findOrFail($id);
        return view('backend.site.teacher.add', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        //validate form
        $messages = [
            'image.max' => 'The :attribute size must be under 2MB.',
            'image.dimensions' => 'The :attribute dimensions must be minimum 210 X 220.',
        ];
        $this->validate($request, [
            'name' => 'required|min:5|max:255',
            'image' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=210,min_height=220',
            'designation' => 'required|min:5|max:255',
            'qualification' => 'required|min:1|max:255',
            'description' => 'max:255',
            'facebook' => 'max:255',
            'google' => 'max:255',
            'twitter' => 'max:255',
        ], $messages);


        $profile = TeacherProfile::findOrFail($id);
        $data = $request->all();
        $fileName = $profile->image;
        if($request->hasFile('image')) {

            if($profile->image){
                $file_path = "public/teacher_profile/".$profile->image;
                Storage::delete($file_path);
            }

            $storagepath = $request->file('image')->store('public/teacher_profile');
            $fileName = basename($storagepath);


        }

        $data['image'] = $fileName;

        $profile->fill($data);
        $profile->save();

        return redirect()->route('teacher_profile.index')->with('success', 'Teacher profile updated.');
    }

    public function destroy($id)
    {
        $profile = TeacherProfile::findOrFail($id);
        $profile->delete();
        return redirect()->route('teacher_profile.index')->with('success', 'Teacher profile deleted.');
    }
}
