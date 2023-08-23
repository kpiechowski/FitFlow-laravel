

@extends('layouts.userPanelLayout')

@section('content')


    <x-panel.calendarPopupBox />
    <div id="activityCalendar" class="w-100">

    </div>


@endsection



@section('assets')

    <script>

        var calendarCurrentEvents = {!! json_encode($jsonCurrentMonth, JSON_UNESCAPED_SLASHES) !!};

    </script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js'></script>
    <script src="{{ asset('js/calendarMain.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/calendarMain.css') }}">

@endsection

