<!DOCTYPE html>
<html>
<head>
    <title>Simreka Console Dashboard</title>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}">

    <!-- plugin css -->
    <link href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/font-awesome/css/all.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <!-- <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" /> -->
    <!-- end plugin css -->
    @stack('plugin-styles')

    <!-- common css -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" />
    <!-- end common css -->

    @stack('style')
</head>
@php
$get_cookie_value = sessionGet();
@endphp

<body data-base-url="{{url('/')}}" id="sidebar_folded_id">
    <!-- <div id="cover"></div> -->
    <script src="{{ asset('assets/js/spinner.js') }}"></script>
    <div class="main-wrapper" id="app">
        @include('layout.admin.sidebar')
        <div class="page-wrapper">
            @include('layout.admin.header')
            <div class="page-content">
                @yield('content')
            </div>
            @include('layout.admin.footer')
        </div>
    </div>
    <div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="modal_logoutLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_logoutLabel">Ready to Leave?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <a href="{{url('logout')}}" class="btn btn-secondary btn-sm">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modalll fade system-diagnostic"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialoggg">
            <div class="modal-content" style="position: right">
                <div class="modal-header">
                    <h6><i class='fas fa-desktop'></i>
                        System Diagnostic</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">


                    <?php
                     \DB::connection()->getPDO();
                    $mysql= \DB::connection()->getDatabaseName();
                   ?>


                    <?php
                    $connect=Redis::connection();
                    if($connect->ping()){
                        $redis="Successfully Connected the Redis server ";
                        }
                    else{
                        $redis="Redis not connected";
                      }

                    ?>


                    <?php
                     $url = "http://127.0.0.1:5000/";
                     $headers = @get_headers($url);
                    if($headers && strpos( $headers[0], '200')) {
                        $msg="SuccessFully Connected the Calculation server";

                     }
                     else {
                         $msg ="Not Connected To The Calculation Server";
                        }
                    ?>

                <div>

                <table class="table">

                    <tbody>
                      <tr>

                        <td><i class="fa fa-database" aria-hidden="true"></i></td>
                        <td>Successfully Connected to the DataBase :{{$mysql}}</td>
                        <td><i class='fa fa-check-circle' style='color:#12872a'></i>

                        </td>
                      </tr>
                      <tr>

                        <td><span><i class="fa fa-hdd" area-hidden="true"></i></span>
                        </td>
                        <td>{{$msg}}</td>

                        <td>
                            @if (($headers && strpos( $headers[0], '200')))

                            <i class='fa fa-check-circle' style='color:#12872a'></i>
                            @else
                            <i class='fa fa-times-circle' style='color: red'></i>

                            @endif
                        </td>
                      </tr>
                      <tr>

                        <td><i class="fa fa-server" area-hidden="true"></i>
                        </td>
                        <td>{{$redis}}</td>
                        <td>
                             @if ($connect->ping())

                            <i class='fa fa-check-circle' style='color:#12872a'></i>

                            @else

                            <i class='fa fa-times-circle' style='color: red'></i>

                            @endif</td>
                      </tr>
                     
                    </tbody>
                </table>
             </div>
        </div>
     <div class="modal fade quick_start_guide" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    There is no document available, please request for document through report an issue.

                </div> -
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- base js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- end base js -->

    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->

    <!-- common js -->
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <!-- end common js -->
    <script src="{{asset('assets/js/common.js')}}"></script>
    <!-- end common js -->
    <script type="text/javascript">
        // $(document).ready(function() {
        //     setTimeout(function() {
        //         $('#cover').fadeOut(5);
        //     }, 10)
        // });
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                isLocal: false
            });
        });
    </script>
    @if(!empty($get_cookie_value) && $get_cookie_value=='active')
    <script type="text/javascript">
        $(function() {
            $('#sidebar_folded_id').addClass('sidebar-folded');
        });
    </script>
    @endif
    @stack('custom-scripts')
</body>

</html>
