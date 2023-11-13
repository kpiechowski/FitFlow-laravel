@extends('layouts.userPanelLayout')

@section('content_nav')
Dodaj aktywność:
@endsection


@section('content')

    <div class="element-row d-f jc-sb  w-100 ai-st" data-aos="fade-up" data-aos-duration="1000">
        <x-activityForm :date="$date" :types="$types" :copy="$copy" :footwear="$footwear" :action="$action" />

        @if ($acGrouped)
            <x-activityModules.activitiesToCopy :grouped="$acGrouped" />   
        @endif
        

    </div>

@endsection



@section('assets')

<link rel="stylesheet" href="{{asset('css/activityForm.css')}}">
<script src="{{ asset('js/activityForm.js') }}"></script>

@endsection
