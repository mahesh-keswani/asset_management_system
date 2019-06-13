<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <style>
         input[id="serachbox"] {
        background:coral;
        border: 0 none;
        color: #d7d7d7;
        width:50px;
        padding: 6px 15px 6px 35px;
        -webkit-border-radius: 20px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        margin:3px 12px;
    }

    input[id="serachbox"]:focus {
        background:#ccc;
        color: #6a6f75;
        width: 150px;    
        margin:3px 12px;
        outline: none;
    }

    input[id="serachbox"] {
        -webkit-transition: all 0.7s ease 0s;
        -moz-transition: all 0.7s ease 0s;
        -o-transition: all 0.7s ease 0s;
        transition: all 0.7s ease 0s;
}
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>   

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    

</head>
<body id="body">
    
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark" style="background:color:maroon;color:white;">
            <div class="container">
                <a class="navbar-brand" href="http://localhost/vesit/public/asset">
                    Product Management Software
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto" style="margin-top:10px;">
                        <li><a href="http://localhost/vesit/public/asset" style="padding-right:30px;color:blanchedalmond;margin-top:30px;">Dashboard</a></li>
                        <li><a href="http://localhost/vesit/public/items" style="padding-right:30px;color:blanchedalmond;">Items</a></li>
                        <li><a href="http://localhost/vesit/public/members" style="padding-right:30px;color:blanchedalmond;">Members</a></li>
                        <li><a href="http://localhost/vesit/public/customers" style="padding-right:30px;color:blanchedalmond;">Customers</a></li>
                        

                    <li>
                        <form action = "{{  url('/search') }}" method="post">
                            {{ csrf_field() }}
                            <input type="text" id="serachbox" placeholder="search" name="q" autocomplete="off"> 
                            <input type="submit" value="Search" class="btn btn-success">
                        </form>

                    </li> 
                   
                    
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        
                            <div class="dropdown">
                                <input data-toggle="dropdown" class="dropdown-toggle" type="image" style="width:30px;height:30px;background-color:black;"src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSUF_iwwsas73Kkvfh_vXv9cwM-CnO6y37Yxw0621eBb_mR9rFVbA">
                                    <span class="caret"></span>
                                    <ul class="dropdown-menu">
                                    <li><a href="{{  url('/showPurchase') }}">Purchase Orders</a></li>
                                    <li><a href="{{  url('/reservationStatus') }}">Reservations</a></li>
                                    <li><a href="http://localhost/vesit/public/cart">Carts</a></li>
                                    
                                </ul>
                            
                    
                            </div>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="http://localhost/vesit/public/"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <br/>
            @include('pages.messages')
        <main class="py-4">
            @yield('content')
        </main>
        </div>
    </div>
    

    
</body>
</html>
