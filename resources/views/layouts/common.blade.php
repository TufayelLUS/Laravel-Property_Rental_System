<!-- Common layout file for all webpages -->
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('page_title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- External Stylesheet -->
        <script src="{{url('/')}}/external/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="{{url('/')}}/external/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{url('/')}}/external/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="{{url('/')}}/external/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-1/css/all.css">

        <!-- Internal Stylesheet -->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/styles.css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
        <style type="text/css">
            html, body
            {
                font-family: "Source Sans Pro";
                font-size: 18px;
                color: black;
            }
        </style>
        <!-- Extra headers for different pages -->
        @yield('extra_headers')

    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-info font-weight-normal">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">{{ $app_name }}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars text-warning"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto w-100 justify-content-end">
                    @auth
                        <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/dashboard') }}"><i class="fa fa-home"></i> Dashboard <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{url('/')}}/user_profile/{{Auth::user()->id}}"><i class="fa fa-user"></i> My Profile</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ url('edit_profile') }}"><i class="fas fa-user-edit"></i> Edit Profile</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{ route('logout') }}"><i class="fa fa-door-open"></i> Logout</a>
                        </li>
                    @else
                        <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/') }}"><i class="fa fa-home"></i> Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#about"><i class="fa fa-exclamation-circle"></i> About</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#contact"><i class="fa fa-address-card"></i> Contact</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ url('register') }}"><i class="fa fa-user-plus"></i> Join Us</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ url('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                    @endauth
                    </ul>
                </div>
            </div>
        </nav>
        @if (Session::has('success'))
        <div class="alert alert-success font-weight-normal text-center mb-0">{{ Session::get('success') }}
        </div>
        @elseif (Session::has('failure'))
        <div class="alert alert-danger font-weight-normal text-center mb-0">{{ Session::get('failure') }}
        </div>
    @endif
        @yield('page_body')
        @yield('extra_footers')
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
         {{ csrf_field() }}
         </form>
         <div id="copyright" class="bg-dark text-white p-3 h4 my-0">
    Copyright &copy; {{ now()->year }}<span class="float-right"><i onclick="location.href='{{ $fb_url }}'" class="fab fa-facebook-square" onmouseenter="this.style.color='skyblue';this.style.cursor='pointer'" onmouseleave="this.style.color='white'"></i> <i onclick="location.href='{{ $twitter_url }}'" class="fab fa-twitter-square" onmouseenter="this.style.color='skyblue';this.style.cursor='pointer'" onmouseleave="this.style.color='white'"></i> <i onclick="location.href='{{ $linkedin_url }}'" class="fab fa-linkedin" onmouseenter="this.style.color='skyblue';this.style.cursor='pointer'" onmouseleave="this.style.color='white'"></i></span>
</div>
    </body>
</html>