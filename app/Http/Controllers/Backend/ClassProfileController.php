<?php

namespace App\Http\Controllers\Backend;

use App\ClassProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ClassProfileController extends Controller
{
    public function index()
    {
        $profiles = ClassProfile::all();
        return view('backend.site.class.list', compact('profiles'));
    }

    public function create(Request $request)
    {
        $profile = null;
        return view('backend.site.class.add', compact('profile'));
    }

    public function store(Request $request)
    {
        //validate form
        $messages = [
            'image_sm.max' => 'The :attribute size must be under 2MB.',
            'image_sm.dimensions' => 'The :attribute dimensions must be minimum 370 X 280.',
            'image_lg.max' => 'The :attribute size must be under 2MB.',
            'image_lg.dimensions' => 'The :attribute dimensions must be minimum 870 X 460.',
        ];
        $this->validate($request, [
            'name' => 'required|min:5|max:255',
            'image_sm' => 'required|mimes:jpeg,jpg,png|max:2048|dimensions:min_width=370,min_height=280',
            'image_lg' => 'required|mimes:jpeg,jpg,png|max:2048|dimensions:min_width=870,min_height=460',
            'teacher' => 'required|min:5|max:255',
            'room_no' => 'required|min:5|max:255',
            'capacity' => 'required|integer',
            'shift' => 'required|min:5|max:255',
            'short_description' => 'required|min:5|max:255'
        ], $messages);

        $storagepath = $request->file('image_sm')->store('public/class_profile');
        $fileNameSm = basename($storagepath);
        $storagepath = $request->file('image_lg')->store('public/class_profile');
        $fileNameLg = basename($storagepath);

        $data = $request->all();
        $data['slug'] = strtolower(str_replace(' ','-', $data['name']));
        $data['image_sm'] = $fileNameSm;
        $data['image_lg'] = $fileNameLg;

        ClassProfile::create($data);

        return redirect()->route('class_profile.create')->with('success', 'New class profile created.');
    }

    public function edit($id)
    {
        $profile = ClassProfile::findOrFail($id);
        return view('backend.site.class.add', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        //validate form
        $messages = [
            'image_sm.max' => 'The :attribute size must be under 2MB.',
            'image_sm.dimensions' => 'The :attribute dimensions must be minimum 370 X 280.',
            'image_lg.max' => 'The :attribute size must be under 2MB.',
            'image_lg.dimensions' => 'The :attribute dimensions must be minimum 870 X 460.',
        ];
        $this->validate($request, [
            'name' => 'required|min:5|max:255',
            'image_sm' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=370,min_height=280',
            'image_lg' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=870,min_height=460',
            'teacher' => 'required|min:5|max:255',
            'room_no' => 'required|min:5|max:255',
            'capacity' => 'required|integer',
            'shift' => 'required|min:5|max:255',
            'short_description' => 'required|min:5|max:255'
        ], $messages);

        $profile = ClassProfile::findOrFail($id);
        $data = $request->all();

        if($request->hasFile('image_sm')){
            $file_path = "public/class_profile/".$profile->image_sm;
            Storage::delete($file_path);

            $storagepath = $request->file('image_sm')->store('public/class_profile');
            $fileName = basename($storagepath);
            $data['image_sm'] = $fileName;

        }
        if($request->hasFile('image_lg')){
            $file_path = "public/class_profile/".$profile->image_lg;
            Storage::delete($file_path);

            $storagepath = $request->file('image_lg')->store('public/class_profile');
            $fileName = basename($storagepath);
            $data['image_lg'] = $fileName;

        }

        $profile->fill($data);
        $profile->save();

        return redirect()->route('class_profile.index')->with('success', 'Class profile updated.');
    }

    public function destroy($id)
    {
        $profile = ClassProfile::findOrFail($id);
        $profile->delete();
        return redirect()->route('class_profile.index')->with('success', 'Class profile deleted.');
    }
}
