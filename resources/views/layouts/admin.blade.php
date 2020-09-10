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

@if(Auth::user()->id == 1)
    <div class="text-center font-weight-bold">

    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header bg-dark">
                <h3>Welcome {{ Auth::user()->name }}</h3>
            </div>

            <ul class="list-unstyled components">
                <p class="text-info h4">Admin Tools</p>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'admin_home' ? 'active' : '' }}">
                    <a href="{{ url('admin_home') }}">Dashboard</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'all_users' ? 'active' : '' }}">
                    <a href="{{ url('all_users') }}">All Users ({{App\User::all()->count()}})</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'all_posts' ? 'active' : '' }}">
                    <a href="{{url('all_posts')}}">All Posts ({{App\Listing::all()->count()}})</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'all_booking' ? 'active' : '' }}">
                    <a href="{{url('all_booking')}}">All Booking Activities ({{App\Listing::where('booked_by', '>', 0)->count()}})</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'customer_feedback' ? 'active' : '' }}">
                    <a href="{{url('customer_feedback')}}">Customer Feedback ({{App\Feedback::all()->count()}})</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'send_announcement' ? 'active' : '' }}">
                    <a href="{{ url('send_announcement') }}">Send Annoucement Email</a>
                </li>
                <li class="{{ explode('/', url()->current())[count(explode('/', url()->current()))-1] == 'edit_site_info' ? 'active' : '' }}">
                    <a href="{{ url('edit_site_info') }}">Website Settings</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">
            <nav class="navbar navbar-expand-lg bg-info font-weight-normal m-0">
                <div class="container">
                    <button type="button" id="sidebarCollapse" class="navbar-btn mr-5">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">{{ $app_name }}</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars text-warning"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto w-100 justify-content-end">
                        <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/admin_home') }}"><i class="fa fa-home"></i> Dashboard <span class="sr-only">(current)</span></a>
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
        </script>

    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
     {{ csrf_field() }}
     </form>
@else 
    <script>window.location = "{{ url('dashboard') }}";</script>
    <noscript class="text-danger font-weight-bold">Enable Javascript! or <a class="text-warning" href="{{ url('/') }}">Click to return</a></noscript>
@endif

</body>
</html>