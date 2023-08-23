



<div class="login-container d-f fd-c p-40 w-50">

    @if(session('loginError'))

    <div class="error-msg d-f jc-c ai-c w-100"> {{ session('loginError') }} </div>

@endif

<h2 class="login-form-title">Zarejestruj się</h2>

<form action="{{ url('registerUser') }}" method="POST" id="login-form">
    @csrf

    <input type="text" name="login" id="login" placeholder="Login" class="input_button" required>
    <input type="text" name="name" id="name" placeholder="Name" class="input_button" required>
    <input type="text" name="email" id="email" placeholder="Email" class="input_button" required>
    <input type="password" name="haslo" id="haslo" placeholder="Password" class="input_button" required>
    <input type="password" name="haslo2" id="haslo2" placeholder="Repeat password" class="input_button" required>

    {{-- <div class="d-f jc-sb ai-c w-100">
        <div class="d-f ai-c jc-s"><input type="checkbox" name="remember" id=remember>&nbsp;Zapamiętaj mnie</div>
        <a href="/">Resetuj hasło</a>
    </div> --}}

    <div class="w-100 register_box d-f ai-c jc-c">
        Masz już konto?&nbsp;<a href="/login">Zaloguj się</a>
    </div>



    <button type="submit" class="button_form">Zarejestruj</button>



</form>

</div>
