<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="{{asset('assets/image/favicon.png')}}" type="image/x-icon">
    <meta name="description" content="">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="">
    <meta property="twitter:site" content="">
    <meta property="twitter:creator" content="">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="">
    <meta property="og:site_name" content="">
    <meta property="og:title" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:description" content="">
    <title>{{$gnl->title}} | @yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/main.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/toastr.min.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/fileInput/bootstrap-fileinput.css')}}">
    @yield('style')
</head>
<body class="app sidebar-mini rtl">
<!-- Navbar-->
<header class="app-header"><a class="app-header__logo" href="{{route('admin.dashboard')}}">{{$gnl->title}} </a>
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <ul class="app-nav">
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="{{route('admin.profile')}}"><i class="fa fa-user fa-lg"></i> Profile</a></li>
                <li><a class="dropdown-item" href="{{route('admin.change.password')}}"><i class="fa fa-key"></i> Đổi mật khẩu</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out fa-lg"></i> Đăng xuất</a></li>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </ul>
        </li>
    </ul>
</header>

<!-- Sidebar menu-->
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="" >
        <div>
            <p style="margin-left: 20px;" class="app-sidebar__user-name">{{ Auth::guard('admin')->user()->name }}</p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item @yield('dashboard')" href="{{route('admin.dashboard')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li><a class="app-menu__item @yield('branch')" href="{{route('admin.branch')}}"><i class="app-menu__icon fa fa-building"></i><span class="app-menu__label">Chi nhánh</span></a></li>
        <li><a class="app-menu__item @if(request()->route()->getName() == 'admin.other.banks') active @endif" href="{{route('admin.other.banks')}}"><i class="app-menu__icon fa fa-university"></i><span class="app-menu__label">Ngân hàng khác</span></a></li>

        <li class="treeview  @if(request()->route()->getName() == 'admin.blog') is-expanded
          @elseif(request()->route()->getName() == 'admin.blog.add') is-expanded
            @elseif(request()->route()->getName() == 'admin.blog.edit') is-expanded

      @endif">
            <a class="app-menu__item " href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-rss"></i><span class="app-menu__label">Tin mới nhất</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item @if(request()->route()->getName() == 'admin.blog.add') active @endif" href="{{route('admin.blog.add')}}"><i class="icon fa fa-plus"></i>Thêm tin</a></li>
                <li><a class="treeview-item @if(request()->route()->getName() == 'admin.blog') active @endif" href="{{route('admin.blog')}}"><i class="icon fa fa-circle-o"></i>Xem toàn bộ</a></li>
            </ul>
        </li>

        <li class="treeview  @if(request()->route()->getName() == 'admin.allUser') is-expanded
            @elseif(request()->route()->getName() == 'admin.banned.user') is-expanded
            @endif  " ><a class="app-menu__item " href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Quản lí người dùng </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item " href="{{route('admin.allUser')}}"><i class="icon fa fa-desktop"></i>@lang('All user')</a></li>
                <li><a class="treeview-item " href="{{route('admin.banned.user')}}"><i class="icon fa fa-ban"></i>@lang('User banned')</a></li>
            </ul>
        </li>


        <li><a class="app-menu__item @yield('subscribe')" href="{{route('admin.subscribe')}}"><i class="app-menu__icon fa fa-newspaper-o"></i><span class="app-menu__label">Newsletter</span></a></li>
        <li><a class="app-menu__item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                       document.getElementById('logout').submit();">
                <i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Logout</span></a>
            <form id="logout" action="{{ route('admin.logout') }}" method="POST">
                @csrf
            </form>
        </li>
    </ul>
</aside>

@yield('content')

<!-- Essential javascripts for application to work-->
<script type="text/javascript" src="{{asset('assets/admin/js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/main.js')}}"></script>
<!-- The javascript plugin to display page loading on top-->
<script type="text/javascript" src="{{asset('assets/admin/js/plugins/pace.min.js')}}"></script>
<!-- Page specific javascripts-->
<script type="text/javascript" src="//gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="{{asset('assets/admin/fileInput/bootstrap-fileinput.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/jscolor.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/chart.js')}}"></script>
@yield('script')

<script>
    $('#edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var title = button.data('mytitle');
        var description = button.data('mydescription');
        var cat_id = button.data('catid');
        var modal = $(this);
        modal.find('.modal-body #title').val(title);
        modal.find('.modal-body #des').val(description);
        modal.find('.modal-body #cat_id').val(cat_id);
    });

    $('#delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var cat_id = button.data('catid');
        var modal = $(this);
        modal.find('.modal-body #cat_id').val(cat_id);
    });



</script>

@include('notification.notification')
</body>
</html>
