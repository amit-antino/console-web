<!DOCTYPE html>
<html>

<head>
    <title>Simreka Console Dashboard</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
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
    <link rel="stylesheet" type="text/css" href="{{asset('assets/tour_guide/sample/css/sample.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/tour_guide/src/jquery.mytour.css')}}" />

    <!-- end plugin css -->

    @stack('plugin-styles')
    <!-- common css -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" />
    <!-- end common css -->
    @stack('style')
    <style>
        .dataTables_info {
            font-weight: normal;
        }

        .paginate_button {
            font-weight: normal;
        }

        tbody {
            font-weight: normal;
        }

        label {
            font-weight: normal;
        }
    </style>
</head>
@php
$get_cookie_value = sessionGet();
@endphp

<body data-base-url="{{url('/')}}" id="sidebar_folded_id">
    <script src="{{ asset('assets/js/spinner.js') }}"></script>
    <div class="main-wrapper" id="app">
        @include('layout.console.sidebar')
        <div class="page-wrapper">
            @include('layout.console.header')
            <div class="page-content">
                @yield('content')
            </div>
            @include('layout.console.footer')
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
    <div class="modal fade issue-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_logoutLabel">Report an Issue</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{url('/ticket')}}" role="ticket">
                        @CSRF
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="title">Title
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Title"></i></span>
                                </label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Title Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type">Select Issue Type
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Reporting/Issue Type"></i></span>
                                </label>
                                <select id="type" name="type" class="form-control" onchange="getPrio(this.value)">
                                    <option value="0">Feedback</option>
                                    <option value="1">Bug</option>
                                    <option value="2">Feature Request</option>
                                    <option value="3">Question</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="prio" style="display:none;">
                                <label for="priorty">Select Priority Levels
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Priority Levels"></i></span>
                                </label>
                                <select id="priorty" name="priorty" class="form-control">
                                    <option value="0">Immediate</option>
                                    <option value="1">High</option>
                                    <option value="2">Low</option>
                                </select>
                            </div>
                            <!-- <div class="form-group col-md-6">
                                <label for="image">Upload Attachment
                                    <i data-toggle="tooltip" title="upload_image. Maximum file size is 1 MB" class="icon-sm" data-feather="info" data-placement="top"></i>
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="file" id="image" name="image" multiple>
                                </div>
                            </div> -->
                            <div class="form-group col-md-12">
                                <label for="description">Description
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Description"></i></span>
                                </label>
                                <textarea id="description" name="description" class="form-control" maxlength="10000" rows="5" placeholder="Description"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="ticket"]' class="btn btn-sm btn-secondary submit">
                        <!-- <span id="cover_footer" class="spinner-border spinner-border-sm" style="display: none;"></span> -->
                        Submit
                    </button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade quick_start_guide" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    There is no document available, please request for document through report an issue.

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
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

                    </tbody>
                </table>
             </div>
        </div>


    <!-- base js -->

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>



    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->

    <!-- common js -->
    <script src="{{ asset('assets/js/template.js') }}"></script>

    <script src="{{asset('assets/js/common.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/tour_guide/src/jquery.mytour.1.0.7.min.js')}}"></script>
    <!-- end common js -->
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                isLocal: false
            });
        });

        function getPrio(val) {
            if (val == 1) {
                document.getElementById("prio").style.display = "";
            } else {
                document.getElementById("prio").style.display = "none";
            }
        }
    </script>
    @if(!empty($get_cookie_value) && $get_cookie_value=='active')
    <script type="text/javascript">
        $(function() {
            $('#sidebar_folded_id').addClass('sidebar-folded');
        });
    </script>
    @endif
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#tour').mytour(); /* simplest way to start */
            // full options
            //jQuery.init();

            $('#tour').mytour({
                start: 0, // start at which step

                buttons: { // buttons:
                    next: 'Next', // next step.
                    prev: 'Prev', // previous step.
                    start: 'Start', // backward to the first set step.
                    finish: 'Finish', // stop presentation.
                    menu: true // show/ hide the dropdown menu with the steps
                },

                autoPlay: false, // (true/ false) if true, start the tour automaticaly
                timer: 5000, // time elipsed before goes to the next step (if null, then don't goes)

                steps: '#my-tour-steps', // which objects will contain the steps that will be displayed for the user.
                stepHolder: 'li', // which tag is used to hold the step content

                onStart: function() { // callback method, called when my-tour is started
                    $('#tour').css('display', 'inline');
                },

                onShow: function() { // callback method, called when my-tour is played for the 1st time
                    $('#panel').html('Running ...');
                },

                beforePlay: null, // callback method, called always before play any step

                afterPlay: null, // callback method, called always after has played any step

                onFinish: function() { // callback method, called when my-tour is finished
                    $('#panel').html('The tour has finished.');
                },

                debug: false // (true/false) if set TRUE, log on console each step
            });

        });
    </script>

    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-25947408-5', 'auto');
        ga('send', 'pageview');
    </script>
    @stack('custom-scripts')
</body>

</html>
