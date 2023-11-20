<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use App\Models\Friendship;
use App\Models\User;

class FriendshipController extends Controller
{
    //


    public function index(){

        $user = Auth::user();


        $friends = $user->friends;

        foreach ($friends as $f) {
            $f->setAttribute('data',$f->getUserData());
        }

        return view('profile.friends',[
            'friends' => $friends,
            'requests' => $user->friendRequests,
        ]);
    }


    public function findByString($string){

        $users = User::where('name', 'LIKE', '%'.$string.'%' )
        ->where('id', '!=', Auth::user()->id)
        ->get();

        $usersData = [];

        if(count($users) > 0){
            $usersData['status'] = 'found';
            foreach ($users as $u) {

                $usersData['rows'][] = array_merge( $u->getUserData(), ['id'=>$u->id]);
            }

        } else {
            $usersData['status'] = 'empty';
        }

        // dd($usersData);
        return json_encode($usersData);
    }


    public function sendRequest(User $user){

        $exists =Friendship::where('user_id_1', Auth::user()->id)
        ->where('user_id_2', $user->id)->first();

        if($exists){
            return redirect()->back()->with('message', 'Wysłano już zaproszenie do tego uzytkownika');
        }

        $f = new Friendship;

        $f->user_id_1 = Auth::user()->id;
        $f->user_id_2 = $user->id;

        $f->save();

        return redirect()->back()->with('message', 'Wysłano zaproszenie');
    }

    public function acceptRequest(Friendship $friendship){

        $friendship->status = true;
        $friendship->save();

    }


    public function deleteFriend(User $friend){

        if($friend === null) {
            return redirect()->back()->with('message', 'Nie znaleziono.');
        }


        Auth::user()->removeFriend($friend);
        return redirect()->back()->with('message', 'Usunięto uzytkownika z listy znajomych.');
    }


}
