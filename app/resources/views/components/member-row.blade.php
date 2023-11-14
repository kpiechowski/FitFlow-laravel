@php



@endphp


<div class="member-row bg-light" data-id="{{ $member->id }}">

    <div class="d-f ai-c">
        <div class="mb-icon upper-bar-profile-icon d-f jc-c ai-c {{ $data['iconType'] }}">
            {{-- <img src="{{ asset('storage/teams/'. $team->logo) }}" style="border-radius:15px; max-height:300px;" class="el-round bg-light" alt="" loading="lazy"> --}}
            {!! $data['iconContent'] !!}
        </div>

        <div class="mb-name">
            {{ $member->name }}
        </div>
        @if($isLeader)
        <div ><span class="material-icon">social_leaderboard</span></div>
        @endif
    </div>

    <div class="mb-options d-f jc-e ai-c ">
        @if($options && $member->id !== $currentUser->id)
            <div class="mb-option leader material-button" data-action="setLeader" title="Mianuj kapitanem"><span class="material-icon">military_tech</span></div>
            <div class="mb-option delete material-button" data-action="delete" title="Usuń z drużyny"><span class="material-icon">group_remove</span></div>
        @endif

        <a href="{{ url('userPanel/profile/view/'.$member->id ) }}" class="material-button" title="Zobacz profil"><span class="material-icon">person</span></a>
    </div>

</div>
