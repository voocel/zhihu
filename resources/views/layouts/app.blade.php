<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .panel-body.content img {
            width: 100%;
        }

        a.topic {
            font-size: 12px;
            background: #eff6fa;
            padding: 1px 10px 0;
            border-radius: 30px;
            text-decoration: none;
            margin: 0 5px 5px 0;
            display: inline-block;
            white-space: nowrap;
            cursor: pointer;
            float: right;
        }

        a.topic:hover {
            background: #259;
            color: #fff;
            text-decoration: none;
        }


        .button.is-naked {
            background: 0 0;
            border: none;
            border-radius: 0;
            padding: 0;
            height: auto;
        }
        .actions {
            display: flex;
            padding: 10px 20px;
        }
        .delete-form {
            margin-left: 20px;
        }
        .delete-button {
            color: #3097D1;
            text-decoration: none;
        }
        .question-follow {
            text-align: center;
        }

        .user-statics , .user-actions {
            margin-top: 20px;
        }
        .user-statics {
            display: flex;
        }
        .statics-item {
            padding: 2px 20px;
        }
        .messages-list {
            margin-top: 80px;
        }
        .media.unread {
            background:#fff9ca;
        }
        .notifications {
            position: relative;
            padding: 8px 15px 8px 25px;
            color: #666;
            border: none;
            border-top: 1px dotted #eee;
            background: transparent;
        }

        .notifications.unread {
            background: #fff9ea;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
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
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">登录</a></li>
                            <li><a href="{{ route('register') }}">注册</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            退出登录
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
        <div class="container">
            @include('flash::message')
        </div>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
    <script>
        $('#flash-overlay-modal').modal();
    </script>
</body>
</html>
