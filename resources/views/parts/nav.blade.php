@guest
    <div class="logo">
        <a href="/login">
            <img src="{{ asset('storage/cont/logo-w.svg') }}" alt="{{ config('app.name', 'Laravel') }}">
        </a>
    </div>
@else
    <nav class="nav faded">
        <div class="nav-part nav-burger">
            <span class="link" v-on:click="showMenu = !showMenu"><i class="fa fa-bars"></i></span>
        </div>
        <div class="nav-part nav-left">
            <a href="{{ route('home') }}">
                <svg viewBox="0 0 82 55" height="40px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M72.319099,12.262806 C72.319099,12.262806 69.974149,7.588172 68.765679,6.103634 C67.557229,4.6191 65.354869,1.332826 64.956009,2.116282 C64.557159,2.899738 62.454349,7.655929 60.341489,9.616324 C58.228629,11.576716 55.992059,14.301496 52.855019,14.311094 C49.717989,14.320694 47.924519,13.046763 47.924519,13.046763 C47.924519,13.046763 43.349979,9.414754 42.308101,8.750059 C41.266223,8.085363 39.410308,10.811736 37.97062,12.790647 C36.691124,14.69167 32.648712,20.945679 32.11986,21.775939 C31.591007,22.606199 28.084038,28.347789 26.445751,29.897379 C24.807468,31.446969 18.62731,36.391319 15.862577,37.546609 C13.097842,38.701909 9.179297,40.189949 8.207148,40.565739 C7.311821,41.000229 2.753912,43.065679 2.272362,45.158629 C1.790807,47.251579 1.556338,50.171389 5.283013,51.883819 C9.009686,53.596239 21.929483,52.366669 23.464526,52.153389 C24.999572,51.940089 26.63725,51.746409 28.900111,50.988309 C31.162972,50.230219 68.077799,36.704869 68.077799,36.704869 C68.077799,36.704869 73.780489,34.731829 75.322209,33.736899 C76.863929,32.741949 79.176089,31.105029 79.236189,28.968529 C79.296289,26.832039 78.930509,25.919249 78.616569,25.232439 C78.302619,24.545629 76.678639,21.531049 76.483629,21.601249 C76.288629,21.671449 71.147289,22.802529 67.792539,22.770529 C66.241279,22.923879 63.033499,21.921119 60.822659,22.900079 C59.051049,23.980039 58.552009,26.570109 58.448149,26.847869 C58.344279,27.125629 57.735119,29.225439 57.059849,29.482679 C56.384589,29.739909 56.141719,29.940459 54.615939,29.895919 C53.090159,29.851319 51.288439,29.279829 48.717589,30.180639 C45.603359,31.714149 44.396139,33.912349 42.709823,35.959659 C40.095093,38.675619 36.407557,41.493689 32.94847,42.933099 C27.610915,44.991819 19.489646,46.887389 13.514651,47.904959" id="path23" stroke="#4A90E2" stroke-width="3.5"></path>
                    </g>
                </svg>
            </a>
        </div>
        <div class="nav-part nav-center">
            <a class="link" href="{{ route('home') }}">Etusivu</a>
            <a class="link" href="{{ route('history', ['month' => Carbon\Carbon::now()->format('m'), 'year' => Carbon\Carbon::now()->format('Y')]) }}">@lang('ui.history')</a>
            <a class="link" href="#">Lajitilastot (tulossa)</a>
        </div>
        <div class="nav-part nav-right">
            <a href="{{ route('newActivity') }}" class="button shadow circle-button">
                <i class="fa fa-plus"></i>
            </a>
            <div class="profile-nav">
                <span class="profile shadow" v-on:click="showMenu = !showMenu">
                    @if(Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}">
                    @else
                        <span class="initials">{{ Auth::user()->initials }}</span>
                    @endif
                    <div class="level">{{ Auth::user()->level->number }}</div>
                </span>
                <nav-menu v-if="showMenu">
                    <li>
                        <a href="{{ route('profile', Auth::id()) }}">
                            <i class="fa fa-fw fa-user"></i>
                            @lang('ui.profile')
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('userSettings') }}">
                            <i class="fa fa-fw fa-cog"></i>
                            @lang('ui.settings')
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fa fa-fw fa-sign-out"></i>
                            @lang('ui.logout')
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </nav-menu>
            </div>
        </div>
    </nav>
    <nav-drawer v-if="showMenu" v-on:close="showMenu = !showMenu">
        <div class="profile-box">
            <div class="profile-nav">
                <span class="profile shadow">
                    @if(Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}">
                    @else
                        <span class="initials">{{ Auth::user()->initials }}</span>
                    @endif
                </span>
            </div>
            <span style="margin-top: 15px;">
                {{ Auth::user()->name }} - Level {{ Auth::user()->level->number }}
            </span>
        </div>
        <ul>
            <li>
                <a href="{{ route('newActivity') }}">
                    <i class="fa fa-fw fa-plus"></i>
                    Uusi aktiviteetti
                </a>
            </li>
            <hr>
            <li>
                <a class="link" href="{{ route('home') }}">
                    <i class="fa fa-fw fa-home"></i>
                    Etusivu
                </a>
            </li>
            <li>
                <a class="link" href="{{ route('history', ['month' => Carbon\Carbon::now()->format('m'), 'year' => Carbon\Carbon::now()->format('Y')]) }}">
                    <i class="fa fa-fw fa-calendar"></i>
                    @lang('ui.history')
                </a>
            </li>
            <li>
                <a class="link" href="#">
                    <i class="fa fa-fw fa-bookmark"></i>
                    Lajitilastot (tulossa)
                </a>
            </li>
            <hr>
            <li>
                <a href="{{ route('profile', Auth::id()) }}">
                    <i class="fa fa-fw fa-user"></i>
                    @lang('ui.profile')
                </a>
            </li>
            <li>
                <a href="{{ route('userSettings') }}">
                    <i class="fa fa-fw fa-cog"></i>
                    @lang('ui.settings')
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fa fa-fw fa-sign-out"></i>
                    @lang('ui.logout')
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </nav-drawer>
@endguest