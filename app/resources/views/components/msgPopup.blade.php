@if(session('middlewareLoginMsg'))

    <div class="global-msg d-f jc-c ai-c"> {{ session('middlewareLoginMsg') }} </div>

@elseif(session('message'))

    <div class="global-msg d-f jc-c ai-c"> {{ session('message') }} </div>

@endif
