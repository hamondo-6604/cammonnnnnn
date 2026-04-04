<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>LOVO Admin &mdash; @yield('title', 'Dashboard')</title>

{{-- Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

{{-- Font Awesome Free --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- Compiled CSS --}}
<link rel="stylesheet" href="{{ asset('css/compiled-styles.css') }}">

@vite(['resources/css/app.scss'])
@stack('head')
</head>
<body class="dash-body">

{{-- Sidebar & Overlay --}}
@include('layouts.sidebar')
<div id="main" class="main-wrapper">
    @include('layouts.header')

    <main class="main-content" id="page-content">
        @yield('content')
    </main>
</div>

{{-- Footer (scripts) --}}
@include('layouts.footer')

</body>
</html>