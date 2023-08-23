

{{-- $notif --}}

<div class="notification p-20 d-f fd-c bg-light-blue">

    <div class="notification-title d-f jc-s ai-s fd-c">

        <div class="notification-type d-f jc-c ai-c fd-c">
            <div class="notification-type-icon">
                @php
                    $path = "images/panel/notification_$notif->type.png";
                @endphp
                <img src='{{ asset("$path") }}' alt="">
            </div>
            <div class="notification-type-txt color-white">{{ strtoupper($notif->type) }}</div>
        </div>
        <div class="notification-title-txt-full d-f jc-s fd-c mt-20">
            {{ $notif->title }}
            <div class="font-small">{{$notif->created_at}}</div>
        </div>

    </div>

    <div class="notification-content   mt-20">
        {{ $notif->message }}
    </div>

    <div class="notification-actions color-white w-100 mt-30 d-f ai-c jc-s wrap">
        {{-- <div id="" class="selectable-element-small "><a href="/userPanel/panel">Back</a></div>
        <div id="" class="selectable-element-small "><a href="/userPanel/notification/view/all">All notifications</a></div> --}}
    </div>

</div>
