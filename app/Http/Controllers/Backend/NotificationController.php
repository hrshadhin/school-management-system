<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUnReadNotification(Request $request)
    {

        $user = auth()->user();

        //check if want to make read
        if($request->query->get('action', '') == "mark_as_read"){
            $user->unreadNotifications->markAsRead();

            if($request->ajax()) {
                return response()->json([]);
            }
            return redirect()->back();
        }
        //check if want to delete
        if($request->query->get('action', '') == "delete"){
            $user->unreadNotifications()->delete();

            if($request->ajax()) {
                return response()->json([]);
            }
            return redirect()->back();
        }


         $limit = $request->query->get('limit', 0);
         if($limit){
             $notifications = $user->unreadNotifications->take($limit);

         }
         else {
             $notifications = $user->unreadNotifications;

         }




         $messages = [];
         foreach ($notifications as $notification){
             $messages[] = [
                  "type" => $notification->data['msg_type'],
                  "message" => $notification->data['msg_text'],
                  "created_at" => $notification->created_at->format('M j,y h:i:s a')
                 ];
         }

        // check for ajax request here
        if($request->ajax()) {
            return response()->json($messages);
        }

        $type = "unread";
        return view('backend.user.notification', compact('messages','type'));

    }

    public function getReadNotification(Request $request)
    {

        $user = auth()->user();

        //check if want to delete
        if($request->query->get('action', '') == "delete"){
            $user->readNotifications()->delete();

            if($request->ajax()) {
                return response()->json([]);
            }
            return redirect()->back();
        }



        $limit = $request->query->get('limit', 0);
        if($limit){
            $notifications = $user->readNotifications->take($limit);

        }
        else {
            $notifications = $user->readNotifications;

        }

        $messages = [];
        foreach ($notifications as $notification){
            $messages[] = [
                "type" => $notification->data['msg_type'],
                "message" => $notification->data['msg_text'],
                "created_at" => $notification->created_at->format('M j,y h:i:s a')
            ];
        }

        // check for ajax request here
        if($request->ajax()) {
            return response()->json($messages);
        }

        $type = "read";
        return view('backend.user.notification', compact('messages','type'));

    }

    public function getAllNotification(Request $request)
    {

        $user = auth()->user();

        //check if want to delete
        if($request->query->get('action', '') == "delete"){
            $user->notifications()->delete();

            if($request->ajax()) {
                return response()->json([]);
            }
            return redirect()->back();
        }


        $notifications = $user->notifications;


        $messages = [];
        foreach ($notifications as $notification){
            $messages[] = [
                "type" => $notification->data['msg_type'],
                "message" => $notification->data['msg_text'],
                "created_at" => $notification->created_at->format('M j,y h:i:s a')
            ];
        }

        // check for ajax request here
        if($request->ajax()) {
            return response()->json($messages);
        }

        $type = "all";
        return view('backend.user.notification', compact('messages','type'));

    }


}
