<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order', 'asc')->paginate(25);
        if(count($sliders)>10){
            Session::flash('warning','Don\'t add more than 10 slider for better site performance!');
        }
        return view('backend.site.home.slider.list', compact('sliders'));
    }

    public function create(Request $request)
    {
        return view('backend.site.home.slider.add');
    }

    public function store(Request $request)
    {
        //validate form
        $messages = [
            'image.max' => 'The :attribute size must be under 2MB.',
            'image.dimensions' => 'The :attribute dimensions must be minimum 1900 X 1200.',
        ];
        $this->validate($request, [
            'title' => 'required|min:5|max:255',
            'subtitle' => 'required|min:5|max:255',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048|dimensions:min_width=1900,min_height=1200',

        ], $messages);

        $storagepath = $request->file('image')->store('public/sliders');
        $fileName = basename($storagepath);

        $data = $request->all();
        $data['image'] = $fileName;

        Slider::create($data);

        return redirect()->back()->with('success', 'New slider item created.');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.site.home.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        //validate form
        $messages = [
            'image.max' => 'The :attribute size must be under 2MB.',
            'image.dimensions' => 'The :attribute dimensions must be minimum 1900 X 1200.',
        ];
        $this->validate($request, [
            'title' => 'required|min:5|max:255',
            'subtitle' => 'required|min:5|max:255',
            'image' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=1900,min_height=1200',

        ], $messages);

        $slider = Slider::findOrFail($id);
        $data = $request->all();

        if($request->hasFile('image')){
            $file_path = "public/sliders/".$slider->image;
            Storage::delete($file_path);

            $storagepath = $request->file('image')->store('public/sliders');
            $fileName = basename($storagepath);
            $data['image'] = $fileName;

        }

        $slider->fill($data);
        $slider->save();

        return redirect()->route('slider.index')->with('success', 'Slider item updated.');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        return redirect()->route('slider.index')->with('success', 'Slider item deleted.');
    }
}
