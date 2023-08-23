




@extends('layouts.userPanelLayout')

@section('content_nav')
Wszystkie powiadomienia:
@endsection

@section('content')




        <div class="notification-full-wrapper --scrollable w-100 d-f fd-c mt-20">

            @foreach ($notifs as $notif)
                <div class="mt-20">
                    <x-panel.notificationFullEl :notif="$notif" />
                </div>
            @endforeach

        </div>

@endsection



@section('assets')


@endsection

