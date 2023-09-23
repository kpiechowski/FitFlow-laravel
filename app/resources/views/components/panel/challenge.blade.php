
@php 

$chall_icon_dict = [
    'total-distance' => ['conversion_path', 'Łącznie przebyty dystans'],
    'total-distance-per-type' => ['conversion_path', 'Łącznie przebyty dystans w: '],
    'total-activities' => ['event_available', 'Łączna liczba treningów'],
    'total-activities-per-type' => ['event_available', 'Łączna liczba treningów w:'],
    'total-time' => ['hourglass_bottom','Łączny czas treningów'],
    'total-time-per-type' => ['hourglass_bottom','Łączny czas treningów w:'],
];


$completeProc = $obj->current_value/$obj->goal_value * 100;
$completeProc = ($completeProc <= 100) ? $completeProc: 100;


$start_date = new DateTime($obj->start_date);
$end_date = new DateTime($obj->end_date);

$days_left = $start_date->diff($end_date);
$days_left = $days_left->days;

@endphp


<div class="challenge-box bg-light el-round p-10 challenge-expired-{{$obj->expired}}" >

    <div class="challenge-box-check">
        @if ($completeProc==100)
            <span class="material-icon">task_alt</span>
        @elseif($obj->expired)
            <span class="material-icon icon-red">dangerous</span>
        @else
            {{$completeProc}}%
        @endif
    </div>

    <div class="challenge-box-top d-f jc-s ai-c w-100 p-10">
        <div class="challenge-box-icon">
            <span class="material-icon">{{ $chall_icon_dict[$obj->type][0]}}</span>
        </div>

        <div class="challenge-name-wrapp ml-20">
            <div class="challenge-name"> Wyzwanie: "{{ $obj->title }}"</div>
            <div class="challenge-type">
                 {{ $chall_icon_dict[$obj->type][1]}} 
                @if ($obj->allowed_activity != 0)
                    <u> {{$panelHelper->getActivityTypeById($obj->allowed_activity)->name}} </u>
                @endif
            </div>
        </div>

    </div>

    <div class="challenge-box-body d-f jc-sb  mt-20">
        <div class="challenge-box-info w-100 p-20">
            
            <p>Pozostało: <b> {{$days_left}}</b> dni</p>
            <p>Postęp wyzwania: <b> {{$completeProc}}% ({{$obj->current_value}})</b></p>
            <div class="progress-wrapp {{ ($obj->expired && $completeProc < 100) ? 'progress-red': '' }}">
                <progress value="{{$obj->current_value}}" max="{{$obj->goal_value}}"></progress>
                <b>0</b> <b>{{$obj->goal_value}}</b>
            </div>
        </div>
        <div class="challengebox-desc w-100 p-20 ">
            Opis:<br>
            {{ $obj->description }}
        </div>
    </div>

    <div class="challenge-box-bottom w-100 mt-20 d-f jc-sb ai-c p-10">
        <div class="challenge-box-dates">
            Start : <u>{{$obj->start_date}}</u> &nbsp;&nbsp;&nbsp;
            Koniec : <u>{{$obj->end_date}}</u> 
        </div>
        <div class="challenge-box-options d-f jc-e ai-c">
            @if (!$obj->complete && !$obj->expired)
                <a title="Zaproś zanjomego" class="el-disable" href=""><span class="material-icon">group_add</span></a>
                <a title="Edytuj" href="{{url('userPanel/challenges/edit/'.$obj->id)}}"><span class="material-icon">settings_b_roll</span></a>
                <a title="Poddaj się" href="{{url('userPanel/challenges/forfeit/'.$obj->id)}}"><span class="material-icon">flag</span></a>  
            @endif
            <a title="Usuń wyzwanie" href="{{url('userPanel/challenges/delete/'.$obj->id)}}"><span class="material-icon">delete</span></a>
        </div>
        
        
    </div>
</div>

