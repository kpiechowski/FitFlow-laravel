<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('notificationAll',[
            'notifs'=> Auth::user()->notifications()->orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public static function create_activity_entry($activity){

        Notification::create([
            'user_id'=> Auth::user()->id,
            'title' => 'Pomyślnie dodano aktywność: '.$activity->title,
            'type' => 'activity',
            'message'=> "Pomyślnie dodano aktywność o nazwie '$activity->title', łączny czas: $activity->total_time min. "
        ]);
    }

    public static function create_challenge_entry($chall){

        Notification::create([
            'user_id'=> Auth::user()->id,
            'title' => 'Pomyślnie dodano wyzwanie: '.$chall->title,
            'type' => 'challenge',
            'message'=> "Dodano wyzwanie o nazwie '$chall->title', data startu wyzwania: '$chall->start_date', data zakończenia: '$chall->end_date', oczekiwany cel: '$chall->goal_value' "
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * unmark a notification.
     */
     public function unmark(Notification $notification)
    {
        //
        // dd($notification);
        $notification->isRead = 1;
        $notification->save();

        return '1';
    }


    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        // dd($notification);
        if($notification->user_id == Auth::user()->id){
            $notification->isRead = 1;
            $notification->save();
            return view('notification', [
                'notif' => $notification
            ]);
        }else{
            return redirect('/userPanel/notification/view/all')->with('message', 'No notification found');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
