<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $app_name }} - @yield('page_title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- External Stylesheet -->
        <script src="{{url('/')}}/external/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="{{url('/')}}/external/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{url('/')}}/external/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="{{url('/')}}/external/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-1/css/all.css">

        <!-- Internal Stylesheet -->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/admin_home.css">
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
        @yield('extra_headers')
    </head>
    <body>


    <div class="text-center font-weight-bold">

    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header bg-dark">
                <h3>Welcome {{ Auth::user()->name }}</h3>
            </div>

            <ul class="list-unstyled components">
                <p class="text-info h4">My Menu</p>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}">Dashboard</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'notifications' ? 'active' : '' }}">
                    <a href="{{ url('notifications') }}">Notifications @if(App\Notification::where('user_id','=',Auth::user()->id)->where('is_read','=','0')->get()->count() > 0)
                    <span id="count_notif" class="badge badge-info">{{App\Notification::where('user_id','=',Auth::user()->id)->where('is_read','=','0')->get()->count()}}</span>
                    @endif
                    </a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'add_post' ? 'active' : '' }}">
                    <a href="{{ url('add_post') }}">Add a Property</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'my_properties' ? 'active' : '' }}">
                    <a href="{{ url('my_properties') }}">My Properties ({{App\Listing::where('user_id','=',Auth::user()->id)->count()}})</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'all_properties' ? 'active' : '' }}">
                    <a href="{{ url('all_properties') }}">All Properties ({{App\Listing::where('is_booked', '=', 0)->count()}})</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'my_following_list' ? 'active' : '' }}">
                    <a href="{{ url('my_following_list') }}">My Following List ({{App\Follower::where('follower_id', '=', Auth::user()->id)->count()}})</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'my_booking' ? 'active' : '' }}">
                    <a href="{{url('my_booking')}}">My Booking ({{App\Listing::where('booked_by','=',Auth::user()->id)->where('booking_expires', '>', round(microtime(1)))->count()}})</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'booking_requests' ? 'active' : '' }}">
                    <a href="{{url('booking_requests')}}">Booking Requests ({{App\Listing::where('user_id', '=', Auth::user()->id)->where('is_booked','=','1')->where('booking_expires', '>', round(microtime(1)))->count()}})</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'post_comments' ? 'active' : '' }}">
                    <a href="{{ url('post_comments') }}">Comments</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">
            <nav class="navbar navbar-expand-lg bg-info font-weight-normal m-0">
            <div class="container">
                <div>
                <button type="button" id="sidebarCollapse" class="navbar-btn mr-3">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    @if(App\Notification::where('user_id','=',Auth::user()->id)->where('is_read','=','0')->get()->count() > 0)
                    <span class="bg-warning rounded" style="margin-left: -25px; position: fixed; top: 5px;font-size: 20px; padding: 3px">{{App\Notification::where('user_id','=',Auth::user()->id)->where('is_read','=','0')->get()->count()}}</span>
                    @endif
                </div>
                <a class="navbar-brand" style="margin-left: 10px" href="{{ url('/') }}">{{ $app_name }}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars text-warning"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto w-100 justify-content-end">
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
                    </ul>
                </div>
            </div>
        </nav>
            @if (Session::has('success'))
                <div class="alert alert-success p-3 m-0">{{ Session::get('success') }}
                </div>
            @elseif (Session::has('failure'))
                <div class="alert alert-danger font-weight-normal text-center m-0">{{ Session::get('failure') }}
                </div>
            @endif

            @yield('page_body')
            </div>
        </div>


        <script type="text/javascript">
            $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                    $(this).toggleClass('active');
                });
            });
            window.setInterval(function() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                    var api_resp = JSON.parse(this.responseText);
                    if (api_resp.status == "success")
                    {
                        if (api_resp.data.refresh == "true")
                        {
                            if ($('#count_notif').length > 0)
                            {
                                if ($('#count_notif').html() != api_resp.data.count) {
                                    window.location.reload(true);
                                }
                            }
                            else
                            {
                                window.location.reload(true);
                            }
                        }
                        else
                        {
                            if ($('#count_notif').length > 0)
                            {
                                if ($('#count_notif').html() != api_resp.data.count) {
                                    window.location.reload(true);
                                }
                            }
                        }
                    }
                  }
                };
                xmlhttp.open("GET", "{{url('/')}}/api/notifications", true);
                xmlhttp.send();
            }, 10000);
        </script>

    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
     {{ csrf_field() }}
     </form>

</body>
</html>