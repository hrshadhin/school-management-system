<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function index()
    {
        return view('backend.site.home.slider.list');
    }

    public function create(Request $request)
    {
        return view('backend.site.home.slider.add');
    }

    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'name' => 'required|min:2|max:255'
        ]);
        $data = $request->all();
        Area::create($data);
        $notification= array('title' => 'Data Store', 'body' => 'Area created Successfully');
        return redirect()->route('area.index')->with('success',$notification);
    }
    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        $area->delete();
        $notification= array('title' => 'Data Remove', 'body' => 'Area deleted Successfully');
        return redirect()->route('area.index')->with('success',$notification);
    }
}
