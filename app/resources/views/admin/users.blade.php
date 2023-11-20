{{-- @dump($reports) --}}


@extends('layouts.userPanelLayout')


@section('content_nav')
{{ $title }}
@endsection





@section('content')



<div class="w-100 ">

    @foreach ($data as $row )

        <div class="w-100 el-round p-20 admin-user-row d-f jc-sb ai-c">
            <div class="d-f ai-c ad-user-profile">

                <div class="mb-icon upper-bar-profile-icon d-f jc-c ai-c mr-5 {{ $row->data['iconType'] }}">
                    {!! $row->data['iconContent'] !!}
                </div>
                <div class="mb-name">
                    {{ $row->name }}
                </div>
            </div>

            <div>
                Ostatnia dodana aktywność:
                @if($row->ac)
                    <div>{{ $row->ac->created_at }}</div>
                @else
                    <div>brak aktywności</div>
                @endif
            </div>

            <div class="mb-options d-f jc-e ai-c gap-5">
                <a href="{{ url('userPanel/profile/view/'.$row->id ) }}" class="material-button" title="Zobacz profil"><span class="material-icon">person</span></a>
                <a href="{{ url('/admin/user/'.$row->id.'/view' ) }}" class="material-button" title="Lista aktywności"><span class="material-icon">list_alt</span></a>
            </div>
        </div>

    @endforeach

</div>


<div class="mt-20 w-100">
    {{ $data->links() }}
</div>



@endsection



@section('assets')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection
