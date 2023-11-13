{{-- @dump(get_defined_vars()) --}}

@extends('layouts.userPanelLayout')



@section('content_nav')


        Drużyna

@endsection


@section('resource_button')

    @if(!$isMember && !$userHasTeam)
        <div class="w-100  d-f jc-e ai-c">
            @if($req_send)
                <a href="{{url('userPanel/team/' .$team->id. '/send_request') }}" class="challenge-add el-disable d-f jc-sb ai-c">
                    Prośba wysłana
                </a>
            @else
                <a href="{{url('userPanel/team/' .$team->id. '/send_request') }}" class="challenge-add d-f jc-sb ai-c">
                    Wyślij prośbę o dołączenie
                </a>
            @endif
        </div>
    @endif

    @if($isLeader)
        <div class="w-100  d-f jc-e ai-c">
            Usuń&nbsp; <a href="{{ url('userPanel/team/'. $team->id.'/destroy') }}" class="material-button"><span class="material-icon">exit_to_app</span></a>
        </div>
    @elseif($isMember)

    <div class="w-100  d-f jc-e ai-c">
       Opuść&nbsp; <a href="{{ url('userPanel/team/'. $team->id.'/leave') }}" class="material-button"><span class="material-icon">exit_to_app</span></a>
    </div>

    @endif



@endsection


@section('content')


@php

$userHelper = UserHelper::load($user->id);

$membersData = [];
foreach($team_members as $member){
    // @dump($member->id);
    $mebersData[$member->id]['member'] = $member;
    $mebersData[$member->id]['data'] = $userHelper->getUserData($member->id);
}


// @dump($mebersData);

// dd('test');
@endphp


<div class="mt-20 w-100">

    <div class=" d-f jc-sb  element-100 team_main" data-id="{{ $team->id }}">

        <div class="p-20 bg-light el-round w-50 profile-section-content">
            <p><span class="key">Nazwa drużyny:</span> {{ $team->nazwa }}</p>
            <p><span class="key">Liczba członków:</span> {{ $team_info['memberCount']}}</p>
            <p><span class="key">Data utworzenia:</span> {{ $team->created_at}}</p>
            <p><span class="key">Założyciel:</span> {{ $leader->name}}</p>
            <p><span class="key">Opis:</span></p>
            <p>{{ $team->opis }}</p>
        </div>

        <div class="w-50 d-f jc-c ai-c relative logo-frame-bg el-round " style="background-image: url('{{ asset('images/team-bg.jpg') }}');">

            <img src="{{ asset('storage/teams/'. $team->logo) }}" style="border-radius:15px; max-height:300px; max-width:300px" class="el-round bg-light logo-frame " alt="" loading="lazy">
            <div class="team-name bg-color-blue1"> {{ $team->nazwa }} </div>
        </div>



    </div>

    <div class="stat-break"></div>

    <div class="d-f jc-sb ai-c team-tabs">
        <div class="team-tab tab-active members-tab" data-tab="members">Członkowie</div>
        <div class="team-tab activities-tab" data-tab="activities">Aktywności</div>
        <div class="team-tab  el-disable" data-tab="none">Osiągnięcia</div>
    </div>

    <div class="mt-20 w-100 page-container">

        <div class="bg-light el-round p-20 page-page members page-active">
            <div class="generic-title"> Lista </div>

            @foreach($mebersData as $id => $m)
                <x-member-row :currentUser="$user" :member="$m['member']" :data="$m['data']" :options="$isLeader" :isLeader="($id == $leader->id ) ? true : false" />
            @endforeach
        </div>

        <div class="bg-light el-round p-20 page-page activities ">

        </div>

        <div class="bg-light el-round p-20 page-page ">

        </div>

    </div>


    <div class="stat-break"></div>

    @if($isLeader)

    <div class="w-100 team-requests">
        <div class="generic-title"> Prośby o dołączenie do drużyny (<span id="team-req-counter">{{ count($requests) }}</span>)</div>

        <div class="bg-light el-round p-20 team-requests-content">

            @if(count($requests) > 0)

            @foreach ($requests as $req )
            <div class="d-f jc-sb ai-c team-request-row bg-light" data-req="{{ $req->id }}">
                <div class="d-f ai-c">{{ $req->user->name }} <a href="" class="material-button ml-5"><span class="material-icon">person</span></a></div>
                <div> Data wysłania: {{ $req->created_at }}</div>

                <div class="team-request-options d-f jc-e ai-c" >
                    <div data-option="join" class="team-request-option material-button"><span class="material-icon">how_to_reg</span></div>
                    <div data-option="delete" class="team-request-option material-button"><span class="material-icon">delete</span></div>
                </div>

            </div>
            @endforeach
            @else

            <div class="p-20 w-full ">Brak próśb o dołączenie</div>

            @endif

        </div>
    </div>
    @endif

</div>





@endsection

@section('assets')

<link rel="stylesheet" href="{{asset('css/activityForm.css')}}">
{{-- <link rel="stylesheet" href="{{asset('css/profile.css')}}"> --}}

<link rel="stylesheet" href="{{asset('css/team.css')}}">
<link rel="stylesheet" href="{{asset('css/profile.css')}}">

<script src="{{ asset('js/team.js') }}"></script>
@endsection
