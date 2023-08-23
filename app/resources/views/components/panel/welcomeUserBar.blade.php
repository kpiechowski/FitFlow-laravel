


<div class="bg-light p-10 element-50 d-f jc-c ai-c el-round color-white">

    <div class="element-50 p-10 d-f jc-s ai-c">
        <div class="upper-bar-profile-icon {{ $currentUserData['iconType'] }} d-f jc-c ai-c mr-10">
            {{ $currentUserData['iconContent'] }}
        </div>
        <div >
            Witaj!<br>
            {{$currentUserData['name']}}
        </div>
    </div>

    <div class="element-50 p-10 d-f jc-e ai-c">

        <div><a class="selectable-element" href="">Wyloguj</a></div>
    </div>

</div>
