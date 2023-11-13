<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\ActivitiesType;

class PanelActivityHelper
{
    function __construct($id){
        $this->user = ($id != null ) ? User::find($id) : Auth::user();
    }

    public static function load($id = null){
        return new PanelActivityHelper($id);
    }

    public function getLatestActivity(){
        $activity = $this->user->userActivities()->latest()->first();
        if($activity){
            $ac_type_model = ActivitiesType::getNameById($activity->activity_type_id);
            return ['activity'=> $activity, 'category'=>$ac_type_model];
        }else{
            return false;
        }

    }

    public function getNewestUserActivities($max = 5){
        $data = $this->user
        ->userActivities()
        ->select('*')
        ->orderByDesc('created_at')
        ->limit($max)
        ->get();

        if($data->count() == 0){
            // dd($data);
            return false;
        }else{
            return $data;
        }

    }

    public function getNewestUserActivitiesGrouped(){
        $data = Auth::user()
        ->userActivities()
        ->select('*')
        ->orderByDesc('created_at')
        ->groupBy('activity_type_id')
        ->get();

        // dd($data);

        if($data->count() == 0){
            return false;
        }else{
            return $data;
        }

    }


    public function getAllActivitiesTypes(){
        return ActivitiesType::get();
    }


    public function getActivityTypeById($id){
        return ActivitiesType::find($id);
    }

    // public function getUserData(){


    //     if($this->user->photo){
    //         $url = url('images/userImage/' . $this->user->id() . 'profileIcon.webp');
    //         $userIconType = 'userIcon--photo';
    //         $content = "<img src='$url' loading='lazy' alt='UserIcon' >";
    //     }else{
    //         $userIconType = 'userIcon--letters';
    //         $content = substr($this->user->name,0,1);

    //     }

    //     return [
    //         'name'=> $this->user->name,
    //         'desc'=> $this->user->description,
    //         'team_id'=> $this->user->team_id,
    //         'iconType' => $userIconType,
    //         'iconContent' => $content
    //     ];
    // }

    // public function getUserNewNotifications(){
    //     return $this->user->notifications()->where('isRead',false)->get();
    // }

}
