<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\UserActivity;
use App\Models\ActivitiesType;
use App\Models\Notification;
use App\Models\Footwear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

use App\Http\Controllers\NotificationController;

use App\Models\User;

class UserActivityController extends Controller
{

    /**
     * Display a calendar of the resource.
     */


    /**
     * Display a listing of the resource.
     */
    public static function index_list()
    {

        $currUserActv = Auth::user()->userActivities();

        // $latest = $currUserActv->latest()->first();

        $all = $currUserActv->get()->all();
        $all2 = Auth::user()->userActivities()->get()->all();

        // dd([$all, $all2]);
        return $all2;


    }


    // public function all_models_ordered($orderBy='add_date'){


    //     $all = UserActivity::where('user_id', $this->userId)->orderBy($orderBy)->get();
    //     dd($all);
    //     return $all;
    // }

    public static function get_latest_activity(){
        return Auth::user()->userActivities()->latest()->first();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req, $id=false)
    {
        //
        $date = $date = $req->input('date');

        $types = ActivitiesType::all();
        $ac_grouped_to_copy = Auth::user()
        ->userActivities()
        ->select('*')
        ->orderBy('add_date', 'desc')
        ->get()
        ->unique('activity_type_id');
        // ->orderByRaw('created_at DESC')
        // ->groupBy('activity_type_id')
        // dd($ac_grouped_to_copy);

        if($ac_grouped_to_copy->count() == 0){
            $ac_grouped_to_copy = false;
        }

        $copy_ac = Auth::user()
        ->userActivities()
        ->where('id', $id)
        ->first();

        $footwear = Auth::user()->footwear()->get();
        // dd($footwear);


        return view('activityAdd',
            [
            'date'=>$date,
            'types'=>$types,
            'acGrouped' =>$ac_grouped_to_copy,
            'copy' => $copy_ac,
            'footwear' => $footwear,
            'action' => '/userPanel/addActivity/'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make(
            $request->all(),
            [
                'act_type'=> 'required|Integer',
                'act_start'=> 'required',
                'act_name'=> 'required',
                'act_time'=> 'required',

            ]
        );

        if($validator->passes()){
            $typ = ActivitiesType::where('slug','inne');
            $optional_activity = $request->input('act_optional', null);
            $footwear_id = $request->input('act_footwear');
            $value = str_replace(',','.',$request->input('act_value'));
            $time = $request->input('act_time');
            $ac_type = $request->input('act_type');

            $ACT = UserActivity::create([

                'user_id' => Auth::user()->id,
                'activity_type_id' => $ac_type,
                'add_date' => $request->input('act_start'),
                'update_date' => $request->input('act_start'),
                'title' => $request->input('act_name'),
                'value' => $value,
                'total_time' => $time,
                'description' => $request->input('desc'),
                'footwear_id' => $footwear_id,
            ]);

            // obuwie
            $footwear = Footwear::find($footwear_id);
            if($footwear){
                 $footwear->updateTotalValue($value);
                 $footwear->updateTotalTime($time);
            }

            // powiadomienia
            NotificationController::create_activity_entry($ACT);

            // wyzwania
            $wyzwania = Auth::user()->activeChallenges($ac_type)->get();
            foreach ($wyzwania as $w) {
                $w->updateCurrentValue($ACT);
            }



            return redirect('/userPanel/panel')->with('message', 'Poprawnie utworzono wpis');
        }

        return redirect('/userPanel/panel')->with('message', 'Nie udało się dodac aktywności');

    }

    /**
     * Display the specified resource.
     */
    public function show(UserActivity $userActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserActivity $userActivity)
    {
        // dd($userActivity);
        //
        $date = $userActivity->add_date;

        $types = ActivitiesType::all();
        $ac_grouped_to_copy = Auth::user()
        ->userActivities()
        ->select('*')
        ->orderBy('add_date', 'desc')
        ->get()
        ->unique('activity_type_id');
        // ->orderByRaw('created_at DESC')
        // ->groupBy('activity_type_id')
        // dd($ac_grouped_to_copy);

        if($ac_grouped_to_copy->count() == 0){
            $ac_grouped_to_copy = false;
        }

        $copy_ac = Auth::user()
        ->userActivities()
        ->where('id', $userActivity->id)
        ->first();

        $footwear = Auth::user()->footwear()->get();
        // dd($footwear);


        return view('activityAdd',
            [
            'date'=>$date,
            'types'=>$types,
            'acGrouped' =>$ac_grouped_to_copy,
            'copy' => $copy_ac,
            'footwear' => $footwear,
            'action' => '/userPanel/panel/'.$userActivity->id.'/update'
            ]
        );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, UserActivity $userActivity)
    {
        //

        // d('test');
        $userActivity->title = $req->get('ac_name');
        $userActivity->activity_type_id = $req->get('act_type');
        $userActivity->add_date = $req->get('act_start');
        $userActivity->total_time = $req->get('act_time');
        $userActivity->value = $req->get('act_value');
        $userActivity->footwear_id = $req->get('act_footwear');
        $userActivity->description = $req->get('desc');

        $userActivity->save();
        // dd($userActivity);
        return redirect('userPanel/panel')->with('message', 'Pomyślnie zaktualizowano wpis');


        // ZMIENIĆ LICZNIK W OBECNYCH I WCZESNIEJSZYCH BUTACH JEŻELI INNE

        // ZMIENIĆ RÓWNIEŻ DANE WYZWANIA JEŚLI ZMIENIA

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserActivity $userActivity)
    {
        //
        if($userActivity && Auth::user()->id == $userActivity->user_id){
            $userActivity->delete();
            return redirect('userPanel/panel')->with('message', 'Pomyślnie usunięto');
        }else{
            return redirect('userPanel/panel');
        }

    }



    public function index_calendar()
    {

        $month = date('m');

        $data = Auth::user()->userActivities()->get();
        $events = [];

        foreach($data as $elem){
            $events[]=[
                'title' => $elem->title,
                'start' =>$elem->add_date,
                'end' => $elem->add_date,
                'id' => $elem->id
            ];
        }

        //

        return view('calendarAcitvities', ['jsonCurrentMonth' => $events, 'jsonF' => $this->getJsonByMonth(date('Y'), date('m'))] );
    }

    // additional methods
    public function getJsonByMonth($year,$monthNumber){

        $data = UserActivity::whereMonth('add_date',$monthNumber)
        ->whereYear('add_date', $year)
        ->get();

        $events = [];

        foreach($data as $elem){
            $events[]=[
                'title' => "$elem->title",
                'start' => "$elem->add_date",
                'end' => "$elem->add_date",
                'id' => $elem->id
            ];
        }

        return $json = json_encode($events);

    }

    public function getYearActivityCountPerType($year = false){

        $year = ($year) ? $year : date('Y');
        $labels = ActivitiesType::all();
        $label_names = [];

        foreach($labels as $label){
            $label_names[] = $label->name;
        }

        $data = Auth::user()
        ->userActivities()
        ->whereYear('add_date', '=', $year)
        ->select('activity_type_id', DB::raw('COUNT(id) as amountCount'))
        ->groupBy('activity_type_id')
        ->orderBy('activity_type_id')
        ->get();

        $label_data = [];

        for($i=1; $i<=count($label_names); $i++){
            $data_by_id = $data->firstWhere('activity_type_id', $i);
            $label_data[] = ($data_by_id) ? $data_by_id->amountCount: 0;
        }

        return json_encode(['labels' => $label_names, 'data'=> $label_data ]);
    }

    public function getYearActivityCountPerMonth($year = false){
        $year = ($year) ? $year : date('Y');
        $currentMonth = date('m');

        $data = Auth::user()
        ->userActivities()
        ->whereYear('add_date', '=', $year)
        ->select(DB::raw('MONTH(add_date) as month, COUNT(id) as amountCount'))
        ->groupBy(DB::raw('MONTH(add_date)'))
        ->get();

        $month_info = [];
        $currentMonthValue = 0;

        for($i=1; $i<=12; $i++){
            $data_by_id = $data->firstWhere('month', $i);
            $month_info[] = ($data_by_id) ? $data_by_id->amountCount: 'NaN';
            if($i == $currentMonth && $data_by_id) $currentMonthValue = $data_by_id->amountCount;
        }

        return json_encode(['data' => $month_info, 'current'=>$currentMonthValue]);

    }

    public function getActivityCountPerMonth(){

        $data = Auth::user()
        ->userActivities()
        ->select(DB::raw('MONTH(add_date) as month, YEAR(add_date) as year , COUNT(id) as amountCount'))
        // ->groupBy(DB::raw('MONTH(add_date)'))
        ->groupBy('year', 'month')
        ->get();

        $month_info = [];

        foreach ($data as $row) {
            $month = ($row->month < 10) ? "0".$row->month : $row->month;
            $label = $row->year.'-'.$month;
            $month_info[$label] = $row->amountCount;

        }

        // dd($month_info);

        return json_encode($month_info);

    }

    public function getActivityCountPerMonthType(ActivitiesType $ActivitiesType){
        $data = Auth::user()
        ->userActivities()
        ->select(DB::raw('MONTH(add_date) as month, YEAR(add_date) as year , COUNT(id) as amountCount'))
        // ->groupBy(DB::raw('MONTH(add_date)'))
        ->where('activity_type_id', $ActivitiesType->id)
        ->groupBy('year', 'month')
        ->get();

        $month_info = [];

        foreach ($data as $row) {
            $month = ($row->month < 10) ? "0".$row->month : $row->month;
            $label = $row->year.'-'.$month;
            $month_info[$label] = $row->amountCount;

        }


        return json_encode($month_info);
    }

}


