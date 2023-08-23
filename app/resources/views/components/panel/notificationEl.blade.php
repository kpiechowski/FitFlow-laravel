

{{-- $notif --}}

<div class="notification p-10 d-f fd-c">

    <div class="notification-title d-f jc-s ai-c">

        <div class="notification-type d-f jc-c ai-c fd-c">
            <div class="notification-type-icon">
                @php
                    $path = "images/panel/notification_$notif->type.png";
                @endphp
                <img src='{{ asset("$path") }}' alt="">
            </div>
            <div class="notification-type-txt color-white font-small">{{ strtoupper($notif->type) }}</div>
        </div>
        <div class="notification-title-txt d-f jc-s fd-c">
            {{ $notif->title }}
            <div class="font-small">{{$notif->created_at}}</div>
        </div>

    </div>

    <div class="notification-content font-small mt-10">
        @php
            $msg = $notif->message;
            $shortMsg = strlen($msg) > 100 ? substr($msg,0,100)."..." : $msg;
        @endphp
        {{ $shortMsg }}
    </div>

    <div class="notification-actions color-white w-100 mt-10 d-f ai-c jc-s wrap">
        <div id="" class="selectable-element-small font-small">Unmark</div>
        <div id="" class="selectable-element-small font-small"><a href="/userPanel/notification/view/{{$notif->id}}">View</a></div>
    </div>

</div>
