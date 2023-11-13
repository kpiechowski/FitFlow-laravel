@props(['friend' => null, 'type' => null  ] )


<div {{  $attributes->merge(['class' => 'member-row bg-light d-f jc-sb ai-c p-20']) }} data-id="{{ $friend ? $friend->id : null  }}">

    <div class="d-f ai-c jc-s">
        <div class="mb-icon upper-bar-profile-icon d-f jc-c ai-c {{ $friend ? $friend->data['iconType'] : '' }}">
            {{-- <img src="{{ asset('storage/teams/'. $team->logo) }}" style="border-radius:15px; max-height:300px;" class="el-round bg-light" alt="" loading="lazy"> --}}
            {{ $friend ? $friend->data['iconContent'] : '' }}
        </div>
        &nbsp;
        <div class="mb-name">
            {{$friend ? $friend->name : '' }}
        </div>
    </div>

    @if($type == "friend")
    {{-- @dump($friend) --}}
    <div class="f-options d-f jc-e ai-c ">
        {{-- <div class="f-option delete material-button" data-action="delete" title="Usuń z drużyny"><span class="material-icon">group_remove</span></div> --}}
        <a href="{{ url('userPanel/friends/'.$friend->id.'/delete') }}" class="material-button" title="Usuń z listy"><span class="material-icon">group_remove</span></a>
        <a href="{{ url('userPanel/profile/view/'.$friend->id) }}" class="material-button" title="Zobacz profil"><span class="material-icon">person</span></a>
    </div>

    @elseif($type=="request")

    <div class="f-options d-f jc-e ai-c ">
        <div class="f-option accept material-button" data-action="delete" title="Usuń z drużyny"><span class="material-icon">group_remove</span></div>
        <a href="" class="material-button" title="Zobacz profil"><span class="material-icon">person</span></a>
    </div>
    @endif

    @if($type=="user")

    <div class="f-options d-f jc-e ai-c ">
        <a href="" class="add material-button" title="Dodaj do znajomych"><span class="material-icon">person_add</span></a>
        <a href="" class="material-button profile" title="Zobacz profil"><span class="material-icon">person</span></a>
    </div>
    @endif
</div>
