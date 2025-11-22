  @php
  use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    $locale = LaravelLocalization::getCurrentLocale() == 'ar' ? 'assets-admin-rtl' : 'assets-admin';
  @endphp


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>{{ __('keywords.dashboard') }} - @yield('title')</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{asset($locale)}}/css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{asset($locale)}}/css/feather.css">
    <link rel="stylesheet" href="{{asset($locale)}}/css/select2.css">
    <link rel="stylesheet" href="{{asset($locale)}}/css/dropzone.css">
    <link rel="stylesheet" href="{{asset($locale)}}/css/uppy.min.css">
    <link rel="stylesheet" href="{{asset($locale)}}/css/jquery.steps.css">
    <link rel="stylesheet" href="{{asset($locale)}}/css/jquery.timepicker.css">
    <link rel="stylesheet" href="{{asset($locale)}}/css/quill.snow.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{asset($locale)}}/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{asset($locale)}}/css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="{{asset($locale)}}/css/app-dark.css" id="darkTheme" disabled>
  </head>