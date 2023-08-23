<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\UserActivity;
use App\Models\ActivitiesType;
use App\Models\Notification;
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
    public function index_calendar()
    {

        $month = date('m');

        $data = Auth::user()->userActivities()->whereMonth('created_at',$month)->get();
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
        return view('calendarAcitvities', ['jsonCurrentMonth' => $events]);
    }

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
        ->groupBy('activity_type_id')
        ->orderByDesc('created_at')
        ->get();

        if($ac_grouped_to_copy->count() == 0){
            $ac_grouped_to_copy = false;
        }

        $copy_ac = Auth::user()
        ->userActivities()
        ->where('id', $id)
        ->first();


        return view('activityAdd', 
            [
            'date'=>$date,
            'types'=>$types,
            'acGrouped' =>$ac_grouped_to_copy,
            'copy' => $copy_ac
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


            $ACT = UserActivity::create([

                'user_id' => Auth::user()->id,
                'activity_type_id' => $request->input('act_type'),
                'add_date' => $request->input('act_start'),
                'update_date' => $request->input('act_start'),
                'title' => $request->input('act_name'),
                'value' => str_replace(',','.',$request->input('act_value')),
                'total_time' => $request->input('act_time'),
                'description' => $request->input('desc'),
            ]);

            NotificationController::create_activity_entry($ACT);

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserActivity $userActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserActivity $userActivity)
    {
        //
    }





    // additional methods
    public function getJsonByMonth($monthNumber){

        $data = UserActivity::whereMonth('created_at',$monthNumber)->get();;
        $events = [];

        foreach($data as $elem){
            $events[]=[
                'title' => "$elem->title",
                'start' => "$elem->add_date",
                'end' => "$elem->add_date"
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
        ->whereYear('created_at', '=', $year)
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
        ->whereYear('created_at', '=', $year)
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

}

