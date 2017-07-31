@inject('config' ,'App\Modules\Electrons\Config\Config')

<nav id="front-nav" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('storage/images/web/logo_simple_white_sm.png') }}">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">

                <!-- Main Links -->
                <li class="{{ request()->is('about') ? 'active' : '' }}"><a href="{{ route('about') }}">Tentang</a></li>
                <li class="{{ request()->is('activities') ? 'active' : '' }}"><a href="{{ route('activities') }}">Acara</a></li>
                <li class="{{ request()->is('news*') ? 'active' : '' }}"><a href="{{ route('news') }}">Berita</a></li>
                <li class="{{ request()->is('faqs') ? 'active' : '' }}"><a href="{{ route('faqs') }}">FAQ</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    @unless ($config->get('stage')['name'] === 'Pra-Pendaftaran' )
                        <li class="{{ request()->is('login') ? 'active' : '' }}"><a href="{{ route('login.form') }}">Login</a></li>
                    @endunless
                    @unless ($config->get('stage')['name'] === 'Pra-Pendaftaran' || $config->get('stage')['name'] === 'Paska Acara')
                        <li class="{{ request()->is('register') ? 'active' : '' }}"><a href="{{ route('register.form') }}">Daftar</a></li>
                    @endunless
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('dashboard') }}">Dasbor</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="marginer" style="padding-bottom:51px;">
</div>