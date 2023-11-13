

{{-- $notif --}}

@php

    $notif_type = [
        'activity' => ['directions_run', 'Aktywność'],
        'challenge' => ['trophy', 'Wyzwanie'],
        'team_join' => ['groups', 'Drużyna'],
    ];

@endphp

<div class="notification p-10 d-f fd-c" data-notId="{{$notif->id}}">

    <div class="notification-title d-f jc-s ai-c">

        <div class="notification-type d-f jc-c ai-c fd-c">
            <div class="notification-type-icon">
                <span class="material-icon">{{ $notif_type[$notif->type][0]}}</span>
            </div>
            <div class="notification-type-txt color-white font-small"><u>{{ $notif_type[$notif->type][1] }}</u></div>
        </div>
        <div class="notification-title-txt d-f jc-s fd-c">
            {{ $notif->title }}
            <div class="font-small">{{$notif->created_at}}</div>
        </div>

    </div>

    <div class="notification-content font-small mt-10">
        @php
            $msg = $notif->message;
            $shortMsg = strlen($msg) > 150 ? substr($msg,0,100)."..." : $msg;
        @endphp
        {{ $shortMsg }}
    </div>

    <div class="notification-actions color-white w-100 mt-10 d-f ai-c jc-s wrap">
        <div id="" class="selectable-element-small font-small notification-unmark">Odznacz</div>
        <div id="" class="selectable-element-small font-small"><a href="/userPanel/notification/view/{{$notif->id}}">Wyświetl</a></div>
    </div>

</div>
