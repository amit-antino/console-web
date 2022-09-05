<!DOCTYPE html>
<html>

<head>
    <title>Simreka Console Dashboard</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}">
    <!-- plugin css -->
    <link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/font-awesome/css/all.css') }}" rel="stylesheet" />
    <!-- end plugin css -->
    @stack('plugin-styles')
    <!-- common css -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" />
    <!-- end common css -->
    @stack('style')
</head>

<body data-base-url="{{url('/')}}">
    <div id="app">
        <div class="page-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- base js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->
    <!-- common js -->
    <script src="{{ asset('assets/js/template.js') }}"></script>
    @stack('custom-scripts')
</body>

</html>