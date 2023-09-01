
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
                <a href="{{ url('/userPanel/challenges/') }}">Wyzwania</a>
            </div>

        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-label">Drużyna</div>

            <div class="sidebar-elem selectable-element">
                <a href="">Lista drużyn</a>
            </div>

            @if(true )
                <div class="sidebar-elem selectable-element">
                    <a href="">Moja drużyna</a>
                </div>

                <div class="sidebar-elem selectable-element">
                    <a href="">Wydarzenia drużynowe</a>
                </div>
            @else
                <div class="sidebar-elem selectable-element">
                    <a href="">Stwórz drużynę</a>
                </div>

                <div class="sidebar-elem selectable-element">
                    <a href="">Dołącz do drużyny</a>
                </div>

            @endif


        </div>

    </div>

</nav>
