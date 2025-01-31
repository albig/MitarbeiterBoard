<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <link rel="shortcut icon" href="{{asset('img/'.config('app.favicon'))}}" type="image/x-icon">

    <title>{{env('APP_NAME')}}</title>
    @can('disable menu')
            <meta http-equiv="refresh" content="300; url={{config('app.url')."/kiosk"}}">
    @endcan

    <!-- CSS Files -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/paper-dashboard.css?v=2.0.0')}}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />

    <link href="{{asset('/css/all.css')}}" rel="stylesheet"> <!--load all styles -->
    <link href="{{asset('css/priority.css')}}" rel="stylesheet" />

    @stack('css')

</head>

<body id="app-layout">
<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo" style="word-wrap: normal;">
        <a href="{{config('app.url')}}" class="simple-text">
            <div class="logo-image-small">
                <img src="{{asset('img/'.config('app.logo'))}}">
            </div>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            @auth
                @cannot('disable menu')
                    <li class="@if(request()->segment(1)=="home" or  request()->segment(1)=="" ) active @endif">
                        <a href="{{url('/home')}}">
                            <i class="fa fa-home"></i>
                            <p>Home</p>
                        </a>
                    </li>
                    @can('view procedures')
                        <li>
                            <a href="{{url('/procedure')}}">
                                <i class="fas fa-project-diagram"></i>
                                <p>Prozesse</p>
                            </a>
                        </li>
                    @endcan
                @if(request()->segment(1)!="procedure")

                    @foreach(auth()->user()->groups() AS $group)
                    <li>

                        <a data-toggle="collapse" href="#{{$group->name}}">
                            <p>
                                {{$group->name}} <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse @if(request()->segment(1)=="$group->name" ) show  @endif" id="{{$group->name}}">
                            <ul class="nav pl-2">
                                <li class="@if(request()->segment(2)=="themes" and request()->segment(1)=="$group->name" ) active @endif">
                                    <a href="{{url($group->name.'/themes')}}">
                                        <i class="far fa-comments"></i>
                                        <p>Themen</p>
                                    </a>
                                </li>
                                <li class="@if(request()->segment(2)=="archive" and request()->segment(1)=="$group->name"  ) active @endif">
                                    <a href="{{url($group->name.'/archive')}}">
                                        <i class="fas fa-archive"></i>
                                        <p>Archiv</p>
                                    </a>
                                </li>
                                <li class="@if(request()->segment(2)=="export" and request()->segment(1)=="$group->name"  ) active @endif">
                                    <a href="{{url($group->name.'/export')}}">
                                        <i class="fas fa-file-alt"></i>
                                        <p>Protokoll</p>
                                    </a>
                                </li>
                                <li class="@if(request()->segment(2)=="search"  and request()->segment(1)=="$group->name") active @endif">
                                    <a href="{{url($group->name.'/search')}}">
                                        <i class="fas fa-search"></i>
                                        <p>Suche</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                @endforeach
                @else



                @endif

                <!-- Verwaltung -->
            <hr>

                <li class="@if(request()->segment(1)=="groups" ) active @endif">
                    <a href="{{url('/groups')}}">
                        <i class="fas fa-users"></i>
                        <p>Gruppen</p>
                    </a>
                </li>

                    @can('edit vertretungen')
                        <li class="@if(request()->segment(1)=="vertretungen") active @endif">
                            <a href="{{url('/vertretungen')}}">
                                <i class="fas fa-exchange-alt"></i>
                                <p>Vertreungen</p>
                            </a>
                        </li>
                        <li class="@if(request()->segment(1)=="dailyNews") active @endif">
                            <a href="{{url('/dailyNews')}}">
                                <i class="fas fa-newspaper"></i>
                                <p>News</p>
                            </a>
                        </li>
                    @endcan
                    @can('edit klassen')
                        <li class="@if(request()->segment(1)=="klassen") active @endif">
                            <a href="{{url('/klassen')}}">
                                <i class="fas fa-users"></i>
                                <p>Klassen</p>
                            </a>
                        </li>
                    @endcan
                    @can('edit permissions')
                        <li class="@if(request()->segment(1)=="roles" and request()->segment(2)!="user"  ) active @endif">
                            <a href="{{url('/roles')}}">
                                <i class="fas fa-lock"></i>
                                <p>Rechte</p>
                            </a>
                        </li>
                    @endcan
                    @can('edit users')
                        <li class="@if(request()->segment(1)=="users") active @endif">
                            <a href="{{url('/users')}}">
                                <i class="fas fa-user"></i>
                                <p>Benutzer</p>
                            </a>
                        </li>
                    @endcan
                @endcan
            @endauth

        </ul>

    </div>

</div>
<div class="main-panel">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
                <a class="navbar-brand" href="{{url('/')}}">{{env('APP_NAME')}}</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar navbar-kebab"></span>
                <span class="navbar-toggler-bar navbar-kebab"></span>
                <span class="navbar-toggler-bar navbar-kebab"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">


                <ul class="nav-item navbar-nav nav-bar-right w-auto">

                            @if (Auth::guest())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/login') }}">Login</a>
                                </li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="far fa-user"></i>
                                        <p>{{auth()->user()->name}}</p>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>

                                    </ul>
                                </li>
                            @endif

                    <!-- Authentication Links -->


                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->




    <div class="content">
        @if(session()->has('ownID'))
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <p>Eingeloggt als: {{auth()->user()->name}}</p>
                            <p>
                                <a href="{{url('logoutAsUser')}}" class="btn btn-info">zum eigenen Account wechseln</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('Meldung'))
            <div class="container">
                <div class="row">
                    <div class="col-12" >
                        <div class="alert alert-{{session('type')}} alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{session('Meldung')}}

                        </div>
                    </div>
                </div>
            </div>
        @endif
        @yield('content')



    </div>

    @stack('modals')
</div>
<!-- JavaScripts -->

    <script src="{{asset('js/core/jquery.min.js')}}"></script>
    <script src="{{asset('js/core/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/core/popper.min.js')}}"></script>
    <script src="{{asset('js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>


    <!-- Chart JS
    <script src="{{asset('js/plugins/chartjs.min.js')}}"></script>
    -->

    <!--  Notifications Plugin    -->
    <script src="{{asset('js/plugins/bootstrap-notify.js')}}"></script>

    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('js/paper-dashboard.min.js?v=2.0.0')}}"></script>

    @auth
        <script src="{{ asset('js/enable-push.js') }}" defer></script>
    @endauth
    @livewireScripts
    @yield('js')
    @stack('js')

</body>
</html>
