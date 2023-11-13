<div class="upper-bar d-f ai-c jc-sb w-100">

    <header class="d-f jc-s ai-c">
        <div id="menu_switch" class="">
            <span class="material-icon">menu</span>
            <span class="material-icon display--none">close</span>
        </div>

        <div class="upper-bar-logo">
            -FitFlow
        </div>


    </header>

    <nav class="d-f ai-c">

        @php
            $notificationCount = count($newNotifications);
            $notificationClass = ($notificationCount > 0) ? 'notifications--new' : '';

        @endphp

        <div id="notification-container">
            <div class="w-100 d-f fd-c ai-s p-0-20">
                <div id="notification-close">+</div>
                <div class="notification_title section-title-txt">Notifications:</div>
                <div class="w-100 mt-10 d-f ai-c jc-s wrap notification_options">
                    <div id="notification-read-all" class="selectable-element-small">Odznacz wszystkie</div>
                    <div id="notification-see-all" class="selectable-element-small">
                        <a href="{{ url('userPanel/notification/view/') }}">See all notifications</a>
                    </div>
                </div>

            </div>

            <div id="notification-elements" class="mt-20">

                @if ($notificationCount > 0)

                    @foreach ($newNotifications as $notif)
                        <x-panel.notificationEl :notif="$notif" />
                    @endforeach

                @else

                    <div class="notification_title w-100 d-f jc-c">No new notifications here</div>

                @endif

            </div>
        </div>


        <div id="notification-box" class="upper-bar-notification">
            <div class="notification-img d-f jc-c ai-c {{ $notificationClass }}">
                <span class="notification-amout d-f jc-c ai-c">{{ $notificationCount }}</span>
                <img src="{{ asset('images/panel/bell.png')}}" width="30" height="30" alt="bell" loading="lazy">
            </div>
        </div>


        <div class="upper-bar-profile d-f jc-c ai-c">
            <div class="upper-bar-profile-icon {{ $currentUserData['iconType'] }} d-f jc-c ai-c">
                {{ $currentUserData['iconContent'] }}
            </div>
            <div class="upper-bar-profile-popup jc-c ai-c fd-c">
                <div class="profile-popup-start"> Hello, {{ $currentUserData['name'] }}!</div>
                <div class="profile-popup-content d-f jc-c ai-c fd-c">
                    <div class="selectable-element"><a href="{{ url('userPanel/profile/view') }}"><span class="material-icon">person</span>Profil</a></div>
                    <div class="selectable-element"><a href="{{ url('/userPanel/footwear/') }}"><span class="material-icon">steps</span>Obuwie</a></div>
                    <div class="selectable-element"><a href="{{ url('userPanel/notification/view/') }}"><span class="material-icon">notifications</span>Powiadomienia</a></div>
                    <div class="selectable-element"><a href="{{ url('userPanel/friends') }}"><span class="material-icon">groups</span>Znajomi</a></div>
                    <div class="selectable-element"><a href="{{ url('/logout') }}"><span class="material-icon">logout</span>Wyloguj się</a></div>
                </div>
            </div>
        </div>

    </nav>


</div>
