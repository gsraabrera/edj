<nav class="navbar navbar-expand-md navbar-light bg-maroon shadow-sm" id="mainnav">
    <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <image id="nav-logo" src="{{ url('images/edj_logo.png') }}"/>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
            </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        @foreach ($allPages as $page)
                                       
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('page',$page->slug) }}">{{$page->name}}</a>
                            </li>
                        @endforeach
                        <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Archive
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach ($archives as $archive)
                                        <a class="dropdown-item" href="{{ route('issue.archive',$archive->year) }}">{{$archive->year}}</a>
                                   @endforeach
                                </div>
                        </li>
                 
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @role('Author')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('my-submissions') }}">My submitted articles</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('submit-article') }}">Submit an article</a>
                                </li>
                            @endrole
                            @role('Admin')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Admin
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.users') }}">User Management</a>
                                </div>
                            </li>
                            @endrole
                            @role('Managing Editor')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Managing Editor
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('me.articles') }}">Articles</a>
                                    <a class="dropdown-item" href="{{ route('issue.all') }}">Issue Management</a>
                                </div>
                            </li>
                            @endrole
                            @role('Editor-in-Chief')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    EIC
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('eic.articles') }}">Articles</a>
                                </div>
                            </li>
                            @endrole
                            @role('Reviewer')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Reviewer
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('reviewer.articles') }}">Articles</a>
                                </div>
                            </li>
                            @endrole
                            @role('Subject Matter Editor')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Subject Matter Editor
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('sme.articles') }}">Articles</a>
                                </div>
                            </li>
                            @endrole
                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
    </div>
</nav>