

<div class="login-container d-f fd-c p-40 w-50">

    @if(session('loginError'))

        <div class="error-msg d-f jc-c ai-c w-100"> {{ session('loginError') }} </div>

    @endif



<h2 class="login-form-title">Zaloguj się</h2>

<form action="{{ url('authenticate') }}" method="POST" id="login-form">
    @csrf

    <input type="text" name="email" id="email" placeholder="email" class="input_button" required>
    <input type="password" name="haslo" id="haslo" placeholder="hasło" class="input_button" required>

    <div class="d-f jc-sb ai-c w-100">
        <div class="d-f ai-c jc-s"><input type="checkbox" name="remember" id=remember>&nbsp;Zapamiętaj mnie</div>
        <a href="/">Resetuj hasło</a>
    </div>

    <div class="w-100 mt-20 register_box d-f ai-c jc-c">
        Nie masz jeszcze konta?&nbsp;<a href="/register">Zarejestruj się</a>
    </div>

    @if (session('loginError'))
        <div class="login-error-msg">
            {{ session('loginError') }}
        </div>
    @endif

    <button type="submit" class="button_form">Zaloguj</button>



</form>

</div>
