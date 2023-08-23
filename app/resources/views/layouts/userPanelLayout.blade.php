<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FitFlow</title>

    <x-fontsLoad />

    <x-globalAssetsInclude />


    @yield('assets')

    @php
        $userHelper = UserHelper::load();

        $currentUserData = $userHelper->getUserData();
        $newNotifications = $userHelper->getUserNewNotifications();


    @endphp

</head>
<body>
    <div class="page-content-wrapper">

        <x-msgPopup />

        <div class="page-main-content-wrapper d-f wrap ">
            <x-panel.menuBar :currentUserData="$currentUserData" :newNotifications="$newNotifications" />

            <x-panel.menuSidebar  />

            <main class="d-f jc-c ai-s" id="main">

                <div class="section-1360 p-20 d-f jc-s  fd-c">

                    <div class="panel-content-nav-title w-100">
                        @yield('content_nav')
                    </div>


                    <div class="panel-content d-f jc-sb ai-c w-100 mt-20">
                        @yield('content')
                    </div>

                </div>

            </main>
        </div>

    </div>
</body>
</html>
