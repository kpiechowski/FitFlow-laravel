




@extends('layouts.userPanelLayout')

@section('content_nav')
Panel
@endsection

@section('content')

@php
    $userHelper = UserHelper::load();
    $currentUserData = $userHelper->getUserData();

    $panelActivityHelper = PanelActivityHelper::load();
    $la = $panelActivityHelper->getLatestActivity();

    $newActivities = $panelActivityHelper->getNewestUserActivities();


@endphp


    <div class="element-row d-f jc-sb  w-100 ai-st">
        <x-panel.welcomeUserBar :currentUserData="$currentUserData" />
        <x-panel.latestActivity :la="$la" />
    </div>


    <div class="element-row d-f jc-sb w-100 mt-80">
        <x-panel.statChars />
    </div>

    <div class="element-row d-f jc-sb w-100 mt-80">
        <x-panel.newActivities :data="$newActivities" />
    </div>



@endsection



@section('assets')

<script src="{{ asset('js/chart.umd.js') }}"></script>
<script src="{{ asset('js/wykresyMain.js') }}"></script>

@endsection

