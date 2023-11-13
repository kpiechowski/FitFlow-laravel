

@extends('layouts.userPanelLayout')

@section('content')


<div id="activityCalendar" class="w-100">
    
</div>


@endsection



@section('assets')

<x-panel.calendarPopupBox />
    <script>

        var calendarCurrentEvents = {!! json_encode($jsonCurrentMonth, JSON_UNESCAPED_SLASHES) !!};

        console.log(calendarCurrentEvents);
        console.log({!! json_encode($jsonF, JSON_UNESCAPED_SLASHES) !!});
        

    </script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.8.0/locales/pl.js"></script>
    <script src="{{ asset('js/calendarMain.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/calendarMain.css') }}">

@endsection

