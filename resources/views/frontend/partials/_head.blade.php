<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

{{-- GÜNCELLEME: Varsayılan değerler dil dosyasından çekiliyor --}}
<meta name="keywords" content="@yield('meta_keywords', __('messages.meta_keywords_default'))">
<meta name="description" content="@yield('meta_description', __('messages.meta_description_default'))">

<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">

{{-- GÜNCELLEME: Başlık dil dosyasından çekiliyor --}}
<title>@yield('title', __('messages.site_title'))</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

{{-- CSS Dosyaları --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/magnific-popup.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/loader.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/flaticon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-slider.min.css') }}">
<link rel="stylesheet" class="skin" type="text/css" href="{{ asset('assets/css/skin/skin-1.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/switcher.css') }}">

<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

@stack('custom-styles')
<script src="//code.jivosite.com/widget/3Q6g2W27I8" async></script>