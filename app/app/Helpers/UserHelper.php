<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notifications;
use App\Models\ActivitiesType;
use App\Models\UserActivity;
use Illuminate\Support\Facades\DB;

class UserHelper
{
    function __construct($id){

        $this->user = ($id) ? User::find($id) : Auth::user();
        // dd($this->user);
    }

    public static function load($id = false){
        return new UserHelper($id);
    }

    public static function convertMinutesToHoursAndMinutes($minutes)
    {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        return [
            'hours' => $hours,
            'minutes' => $remainingMinutes,
        ];
    }

    public static function convertMinutesToDHM($minutes) {
        $days = floor($minutes / 1440);
        $minutes %= 1440;
        $hours = floor($minutes / 60);
        $minutes %= 60;

        return $days."d ".$hours."h ".$minutes."m";


    }

    public function getUserData($id=null){
// dump($id);
        $user = ($id !== null) ? User::find($id) : $this->user;


        if($user->photo){
            $url = asset('storage/userProfiles/' . $user->photo);
            $userIconType = 'userIcon--photo';
            $content = "<img src='$url' loading='lazy' alt='UserIcon' >";
        }else{
            $userIconType = 'userIcon--letters';
            $content = substr($user->name,0,1);

        }

        $ac_count = count( $user->userActivities()->get());

        $total_time = $user->userActivities()->sum('total_time');
        $total_time = $this->convertMinutesToDHM($total_time);

        return [
            'name'=> $user->name,
            'desc'=> $user->description,
            'team_id'=> $user->team_id,
            'iconType' => $userIconType,
            'iconContent' => $content,
            'ac_count' => $ac_count,
            'total_time' => $total_time,
        ];
    }

    public function getUserNewNotifications(){
        return $this->user->notifications()->where('isRead',false)->orderByRaw('CAST(id AS UNSIGNED) DESC')->get();
    }



    public function convertPercentIntoFlag($proc){
        $flags = [
            '33' => 'below',
            '67' => 'average',
            '101' => 'above',
        ];

        foreach ($flags as $number => $flag) {
            if($proc < intval($number)) return $flag;
        }
        return '';
    }

    public function getUserMonthStats($type_id = false){

        $month = date('m');
        $userID = $this->user->id;
        $userCount = count(User::get());

        $tab = ActivitiesType::get();
        $tab_tmp = $tab->map(fn($type) => $type->id);



        $allowed_types =($type_id) ? [$type_id] : $tab_tmp;


        // ------------------------------------ liczba treingów w miesiacu ----------------------------
        $month_user_count['value'] = $this->user->userActivities()->whereMonth('created_at', '=', $month)->get();
        $month_user_count['value'] = count($month_user_count['value']);

        if($month_user_count['value'] == 0) return false;

        // liczba użytkowników z liczbą treningów mniejszą niż uzytkownik
        $month_all_users_count =count(UserActivity::whereMonth('created_at', '=', $month)
        ->select(DB::raw('COUNT(id) as amountCount'), 'user_id')
        ->where('user_id', "!=", $userID)
        ->whereIn('activity_type_id', $allowed_types)
        ->groupBy('user_id')
        ->having('amountCount', '<', $month_user_count['value'])
        ->get());

        $month_user_count['all_percent'] =  $month_all_users_count/($userCount-1) * 100;
        $month_user_count['all_label'] = $this->convertPercentIntoFlag( $month_all_users_count/($userCount-1) * 100);



        // ------------------------------------ najczęstszy rodzaj aktywności -------------------------------
        $month_user_top_activity_model = $this->user->
        userActivities()
        ->whereMonth('created_at', '=', $month)
        ->select(DB::raw('COUNT(id) as amountCount'), 'activity_type_id')
        ->groupBy('activity_type_id')
        ->orderBy('amountCount','desc')
        ->first();

        // dd($month_user_top_activity_model);

        if($month_user_top_activity_model !== null){
            $month_user_top_activity['model'] = ActivitiesType::find($month_user_top_activity_model)->first();
            $month_user_top_activity_id = $month_user_top_activity['model']->id;
            $month_user_top_activity['count'] = $month_user_top_activity_model->amountCount;

        }else{
            $month_user_top_activity = false;
        }



        // ------------------------------------ średni czas treningów -------------------------------
        $month_user_avg_time = $this->user->
        userActivities()
        ->whereMonth('created_at', '=', $month)
        ->avg('total_time');

        // liczba użytkowników z srednim czasem treningów mniejszą niż uzytkownik
        $month_all_avg_time = count(UserActivity::
        whereMonth('created_at', '=', $month)
        ->selectRaw('AVG(total_time) as time_avg, user_id')
        ->where('id', '!=', $userID)
        ->groupBy('user_id')
        ->having('time_avg', '<', $month_user_avg_time)
        ->get());

        $minutes_and_hours = $this->convertMinutesToHoursAndMinutes($month_user_avg_time);

        $month_avg_time['time'] = $month_user_avg_time;
        $month_avg_time['hours'] = $minutes_and_hours['hours'];
        $month_avg_time['minutes'] = $minutes_and_hours['minutes'];
        $month_avg_time['all_percent'] = $month_all_avg_time/($userCount-1) * 100;
        $month_avg_time['all_label'] = $this->convertPercentIntoFlag($month_all_avg_time/($userCount-1) * 100);


        // ------------------------------------ liczba treingów w miesiacu | top aktywność ----------------------------
        $month_top_activity_count['value'] = count($this->user->userActivities()
        ->whereMonth('created_at', '=', $month)
        ->where('activity_type_id', "=", $month_user_top_activity_id)
        ->get());
        // dd($month_top_activity_count['value']);
        // $month_user_count['value'] = count($month_user_count['value']);

        // liczba użytkowników z liczbą treningów mniejszą niż uzytkownik
        $month_all_users_count =count(UserActivity::whereMonth('created_at', '=', $month)
        ->select(DB::raw('COUNT(id) as amountCount'), 'user_id')
        ->where('user_id', "!=", $userID)
        ->whereIn('activity_type_id', $allowed_types)
        ->groupBy('user_id')
        ->having('amountCount', '<', $month_user_count['value'])
        ->get());

        $month_user_count['all_percent'] =  $month_all_users_count/($userCount-1) * 100;
        $month_user_count['all_label'] = $this->convertPercentIntoFlag( $month_all_users_count/($userCount-1) * 100);




        // return -----------------------------------------------------------------------------
        return [
            'month_user_count' => $month_user_count,
            'month_user_top_activity' => $month_user_top_activity,
            'month_avg_time' => $month_avg_time,

        ];
        // dd($month_avg_time);

    }

}
