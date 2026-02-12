<!-- Title -->
<title>@yield('title')</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<meta name="title" content="Learn To Earn">
<meta name="description" content="School Management System (LMS)  His Name Is Learn To Earn To Control The School, Students, Teachers and Subjects ">
<!-- Favicon -->
<link rel="icon" href="{{URL::asset('assets/admin/img/brand/favicon.png')}}" type="image/x-icon"/>
<!-- Icons css -->
<link href="{{URL::asset('assets/admin/css/icons.css')}}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{URL::asset('assets/admin/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
<!--  Sidebar css -->
<link href="{{URL::asset('assets/admin/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidemenu css -->
@if (App::getLocale() == 'ar')
    <link rel="stylesheet" href="{{URL::asset('assets/admin/css-rtl/sidemenu.css')}}">
@else
    <link rel="stylesheet" href="{{URL::asset('assets/admin/css/sidemenu.css')}}">
@endif
@yield('css')
<!--- Style css -->
@if (App::getLocale() == 'ar')
    <link href="{{URL::asset('assets/admin/css-rtl/style.css')}}" rel="stylesheet">
@else
    <link href="{{URL::asset('assets/admin/css/style.css')}}" rel="stylesheet">
@endif
<!--- Dark-mode css -->
<link href="{{URL::asset('assets/admin/css-rtl/style-dark.css')}}" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{URL::asset('assets/admin/css-rtl/skin-modes.css')}}" rel="stylesheet">
