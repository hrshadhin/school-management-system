<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::paginate(env('MAX_RECORD_PER_PAGE',25));
        return view('backend.site.event.list', compact('events'));
    }

    public function create(Request $request)
    {
        $event = null;
        return view('backend.site.event.add', compact('event'));
    }

    public function store(Request $request)
    {
        //validate form
        $messages = [
            'slider_1.max' => 'The :attribute size must be under 2MB.',
            'slider_1.dimensions' => 'The :attribute dimensions must be minimum 1170 X 580.',
            'slider_2.max' => 'The :attribute size must be under 2MB.',
            'slider_2.dimensions' => 'The :attribute dimensions must be minimum 1170 X 580.',
            'slider_3.max' => 'The :attribute size must be under 2MB.',
            'slider_3.dimensions' => 'The :attribute dimensions must be minimum 1170 X 580.',
            'cover_photo.max' => 'The :attribute size must be under 2MB.',
            'cover_photo.dimensions' => 'The :attribute dimensions must be minimum 370 X 270.',
        ];
        $this->validate($request, [
            'title' => 'required|min:5|max:255',
            'event_time' => 'required|min:5|max:255',
            'cover_photo' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=370,min_height=270',
            'slider_1' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=1170,min_height=580',
            'slider_2' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=1170,min_height=580',
            'slider_3' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=1170,min_height=580',
            'description' => 'required',
            'tags' => 'max:255',
            'cover_videos' => 'max:255'
        ], $messages);


        $data = $request->all();
        $datetime = Carbon::createFromFormat('d/m/Y h:i a',$data['event_time']);
        $data['event_time'] = $datetime;
        $data['slug'] = strtolower(str_replace(' ','-', $data['title']));

        $fileName = null;
        if($request->hasFile('cover_photo')) {
            $storagepath = $request->file('cover_photo')->store('public/events');
            $fileName = basename($storagepath);
            $data['cover_photo'] = $fileName;

        }
        $fileName = null;
        if($request->hasFile('slider_1')) {
            $storagepath = $request->file('slider_1')->store('public/events');
            $fileName = basename($storagepath);
            $data['slider_1'] = $fileName;

        }
        if($request->hasFile('slider_2')) {
            $storagepath = $request->file('slider_2')->store('public/events');
            $fileName = basename($storagepath);
            $data['slider_2'] = $fileName;

        }
        if($request->hasFile('slider_3')) {
            $storagepath = $request->file('slider_3')->store('public/events');
            $fileName = basename($storagepath);
            $data['slider_3'] = $fileName;

        }

        Event::create($data);
        Cache::forget('upcomming_event');

        return redirect()->back()->with('success', 'New event added.');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('backend.site.event.add', compact('event'));
    }

    public function update(Request $request, $id)
    {
        //validate form
        $messages = [
            'slider_1.max' => 'The :attribute size must be under 2MB.',
            'slider_1.dimensions' => 'The :attribute dimensions must be minimum 1170 X 580.',
            'slider_2.max' => 'The :attribute size must be under 2MB.',
            'slider_2.dimensions' => 'The :attribute dimensions must be minimum 1170 X 580.',
            'slider_3.max' => 'The :attribute size must be under 2MB.',
            'slider_3.dimensions' => 'The :attribute dimensions must be minimum 1170 X 580.',
            'cover_photo.max' => 'The :attribute size must be under 2MB.',
            'cover_photo.dimensions' => 'The :attribute dimensions must be minimum 370 X 270.',
        ];
        $this->validate($request, [
            'title' => 'required|min:5|max:255',
            'event_time' => 'required|min:5|max:255',
            'cover_photo' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=370,min_height=270',
            'slider_1' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=1170,min_height=580',
            'slider_2' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=1170,min_height=580',
            'slider_3' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=1170,min_height=580',
            'description' => 'required',
            'tags' => 'max:255',
            'cover_videos' => 'max:255'
        ], $messages);


        $data = $request->all();
        $datetime = Carbon::createFromFormat('d/m/Y h:i a',$data['event_time']);
        $data['event_time'] = $datetime;
        $data['slug'] = strtolower(str_replace(' ','-', $data['title']));
        $event = Event::findOrFail($id);

        $fileName = null;
        if($request->hasFile('cover_photo')) {

            if($event->cover_photo){
                $file_path = "public/events/".$event->cover_photo;
                Storage::delete($file_path);
            }
            $storagepath = $request->file('cover_photo')->store('public/events');
            $fileName = basename($storagepath);
            $data['cover_photo'] = $fileName;

        }
        $fileName = null;
        if($request->hasFile('slider_1')) {
            if($event->slider_1){
                $file_path = "public/events/".$event->slider_1;
                Storage::delete($file_path);
            }
            $storagepath = $request->file('slider_1')->store('public/events');
            $fileName = basename($storagepath);
            $data['slider_1'] = $fileName;

        }
        if($request->hasFile('slider_2')) {
            if($event->slider_2){
                $file_path = "public/events/".$event->slider_2;
                Storage::delete($file_path);
            }
            $storagepath = $request->file('slider_2')->store('public/events');
            $fileName = basename($storagepath);
            $data['slider_2'] = $fileName;

        }
        if($request->hasFile('slider_3')) {
            if($event->slider_3){
                $file_path = "public/events/".$event->slider_3;
                Storage::delete($file_path);
            }
            $storagepath = $request->file('slider_3')->store('public/events');
            $fileName = basename($storagepath);
            $data['slider_3'] = $fileName;

        }

        $event->fill($data);
        $event->save();
        Cache::forget('upcomming_event');

        return redirect()->route('event.index')->with('success', 'Event information updated.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('event.index')->with('success', 'Event deleted.');
    }
}
