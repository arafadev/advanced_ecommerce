<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta name="robots" content="all,follow"> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('frontend/img/favicon.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    {{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/lightbox2/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/nouislider/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/bootstrap-select/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/owl.carousel2/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/owl.carousel2/assets/owl.theme.default.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.default.css') }}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <livewire:styles />
    @yield('style')
</head>

<body>
    <div id="app" class="page-holder {{ request()->routeIs('frontend.detail') ? 'bg-light' : null }}">

        @include('partial.frontend.header')

        <div class="container">
            @yield('content')
        </div>

        @include('partial.frontend.footer')
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/lightbox2/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/owl.carousel2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/front.js') }}"></script>
    <script src="{{ asset('frontend/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js') }}"></script>
    <livewire:scripts />
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <x-livewire-alert::scripts /> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.addEventListener('swal:alert', event => {
            Swal.fire({
                icon: event.detail.type,
                title: event.detail.message,
                position: event.detail.position,
                timer: event.detail.timer,
                toast: event.detail.toast,
                showConfirmButton: false,
            });
        });
    </script>

    @yield('script')
</body>

</html>
