
<nav id="sidebar">

    <div class="sidebar-container">

        <div class="sidebar-section">

            <div class="sidebar-elem selectable-element se--active">
                <a href="{{ url('userPanel/panel') }}">Panel</a>
            </div>

        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-label">Aktywności</div>

            <div class="sidebar-elem selectable-element">
                <a href="{{ url('/userPanel/calendar/') }}">Kalendarz</a>
            </div>

            <div class="sidebar-elem selectable-element">
                <a href="{{ url('/userPanel/addActivity/') }}">Dodaj aktywność</a>
            </div>

            <div class="sidebar-elem selectable-element">
                <a href="{{ url('/userPanel/summary/') }}">Statystyki</a>
            </div>

            <div class="sidebar-elem selectable-element">
                <a href="{{ url('/userPanel/challenges/') }}">Wyzwania</a>
            </div>

        </div>

        <div class="sidebar-section ">
            <div class="sidebar-section-label">Drużyna</div>

            <div class="sidebar-elem selectable-element">
                <a href="{{ url('/userPanel/teams') }}">Lista drużyn</a>
            </div>

            @if($currentUserData['team_id'] !== null)
                <div class="sidebar-elem selectable-element">
                    <a href="{{ url('userPanel/team/'.$currentUserData['team_id']) }}">Moja drużyna</a>
                </div>

                <div class="sidebar-elem selectable-element el-disable" >
                    <a href="">Wydarzenia drużynowe</a>
                </div>
            @else
                <div class="sidebar-elem selectable-element">
                    <a href="{{ url('userPanel/team/create') }}">Stwórz drużynę</a>
                </div>

            @endif


        </div>

        @if($currentUserData['user']->isAdmin)

        <div class="sidebar-section ">
            <div class="sidebar-section-label">Administracja</div>

            <div class="sidebar-elem selectable-element">
                <a href="{{ url('/admin/reports') }}">Zgłoszenia</a>
            </div>

            <div class="sidebar-elem selectable-element">
                <a href="{{ url('/admin/user/list') }}">Lista użytkowników</a>
            </div>

            <div class="sidebar-elem selectable-element">
                <a href="{{ url('/admin/user/list') }}">Zablokowani użytkownicy</a>
            </div>

        </div>
        @endif

    </div>

</nav>
