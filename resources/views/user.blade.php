<!DOCTYPE html>
<meta charset="UTF-8" />
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title> {{$gnl->title}} | @yield('title')</title>
    <!--Favicon-->
    <link rel="shortcut icon" href="{{asset('assets/image/favicon.png')}}" type="image/x-icon">
    <!--Bootstrap Stylesheet-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/bootstrap.css')}}">
    <!--Font Awesome Stylesheet-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/all.min.css')}}">
    <!--Animate Stylesheet-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--YTPlayer  Stylesheet-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/YTPlayer.min.css')}}">

    <!--Main Stylesheet-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/video.css')}}">
    <!--Responsive Stylesheet-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/toastr.min.css')}}">
    <link href="{{url('/')}}/assets/user/css/color.php?color={{$gnl->color1}}" rel="stylesheet">
    @yield('style')
</head>

<body class="body-class">
<!--Start Preloader-->
<div class="site-preloader">
<div class="spinner">
<div class="double-bounce1"></div>
<div class="double-bounce2"></div>
</div>
</div>
<!--End Preloader-->

<!-- Main Menu Area Start -->

<header class="header-area">
    <nav class="navbar sticky-top navbar-expand-lg main-menu">
        <div class="container">

            <a class="navbar-brand" href="{{route('homePage')}}">
                <img src="{{asset('assets/image/logo.png')}}"  style="max-width: 220px; max-height: 50px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="menu-toggle"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item"><a class="nav-link" href="{{route('user.dashboard')}}">Dashboard</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('Transfer')</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{route('user.transfer.to.ownbank')}}">@lang('Own bank')</a>
                            <a class="dropdown-item" href="{{route('user.transfer.to.otherBank')}}">@lang('Others bank')</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{route('user.account.statement')}}">@lang('Account Statement')</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                            <a class="dropdown-item" href="{{route('user.profile')}}">@lang('Account Settings')</a>
                            <a class="dropdown-item" href="{{route('user.changePass')}}">@lang('Change Password')</a>
                            <a class="dropdown-item" href="{{route('user.logout')}}"  onclick="event.preventDefault();
                                        document.getElementById('logout').submit();">@lang('Log Out')</a>
                            <form id="logout" action="{{ route('user.logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <select id="langSel">
                        <option style="color: black" value="en"> English</option>
                        @foreach($lang as $data)
                            <option value="{{strtolower($data->code)}}" @if(Session::get('lang') == strtolower($data->code)) selected="selected" @endif style="color: black"><img src="{{ asset('assets/image/lang/'.$data->icon)}}"> {{$data->name}}</option>
                        @endforeach
                    </select>
                </ul>
                <div class="viewPlan">
                    <a href="#">
                        {{Auth::user()->balance}} {{$gnl->cur}}
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
@yield('content')

<!-- Footer Area Start -->
<footer id="footer">
    <div class="container">

        <div class="copyright">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center">

                        <div class="banding">
                            <p >
                        {{$gnl->branding}}
                            </p>
                    </div>


                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div class="box w-100 text-right">
                        <div class="social_links">
                            <ul>
                                @foreach($socials as $social)
                                    <li>
                                        <a href="{{$social->link}}">
                                            <i title="{{$social->name}}" class="{{$social->icon}}"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Area End -->


<!--Start ClickToTop-->
<div class="totop">
    <a href="#top"><i class="fa fa-arrow-up"></i></a>
</div>
<!--End ClickToTop-->


<script src="{{asset('assets/user/js/jquery.min.js')}}"></script>
<!--Bootstrap JS-->
<script src="{{asset('assets/user/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/user/js/popper.js')}}"></script>



<!-- main js -->
<script type="text/javascript" src="{{asset('assets/user/js/toastr.min.js')}}"></script>
<script>
    
    jQuery(window).on('load', function () 
    
    {

        /*---------------------------------------------------
            Site Preloader
        ----------------------------------------------------*/
        var $sitePreloaderSelector = $('.site-preloader');
        $sitePreloaderSelector.fadeOut(500);


    });
</script>
<!--YTPlayer-->

<script>
    $(document).on('change', '#langSel', function () {
        var code = $(this).val();
        window.location.href = "{{url('/')}}/change-lang/"+code ;
    });
</script>
<!-- main js -->

@yield('script')
@include('notification.notification')
</body>