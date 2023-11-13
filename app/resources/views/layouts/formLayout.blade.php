<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FitFlow</title>

    <x-fontsLoad />

    <x-globalAssetsInclude />


    <link rel="stylesheet" href="{{ asset('css/form-layout.css') }}">



</head>
<body>

    <x-msgPopup />

    <main class="d-f jc-c ai-c" id="main">

        <div class="section-1000 p-20 d-f jc-c">

            <div class="login-img-cont w-50">
                {!! file_get_contents(public_path('images/login/login-icon.svg')) !!}
                {{-- <img src="{{ asset('images/login/login-icon.svg') }}" alt=""> --}}
            </div>


                @yield('formBox')


        </div>

    </main>

</body>
</html>


