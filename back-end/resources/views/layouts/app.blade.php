<!doctype html >
@php
    $setting=\App\Models\Setting::first();
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{LaravelLocalization::getCurrentLocaleDirection()}}">

<head>


    <meta charset="utf-8" />
    <title>{{ $setting?$setting->name:config('app.name', 'Laravel') }} | @yield('page_title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('/assets/images/favicon.ico')}}">

    <!-- plugin css -->
    <link href="{{asset('/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    @if(str_replace('_', '-', app()->getLocale())=='ar')
    <link href="{{asset('assets/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css" />
    @else
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    @endif
    <!-- DataTables -->
    <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .loader-container{
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: rgba(100,100,100,.5);
            padding: 20%;
            top: 0;
            left: 0;
            z-index: 10000;
        }
        .loader {
            width: 82px;
            height: 18px;
            position: relative;
            margin: auto;
            display: block;
        }
        .loader::before , .loader::after {
            content: '';
            position: absolute;
            left: 50%;
            transform: translate(-50% , 10%);
            top: 0;
            background: #036937;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            animation: jump 0.5s ease-in infinite alternate;
        }

        .loader::after {
            background: #0000;
            color: #fff;
            top: 100%;
            box-shadow: 32px -20px , -32px -20px;
            animation: split 0.5s ease-out infinite alternate;
        }

        @keyframes split {
            0% { box-shadow: 8px -20px, -8px -20px}
            100% { box-shadow: 32px -20px , -32px -20px}
        }
        @keyframes jump {
            0% { transform: translate(-50% , -150%)}
            100% { transform: translate(-50% , 10%)}
        }
        .errors-count{
            border-radius: 50%;
            width: 15px;
            height: 15px;
            margin-left: 1.2em;
        }
        .nav-errors{
            /*color: #912f2f!important;*/
        }
        .website-logo{
            height: 5em;
            width: 6em;
        }
        table .waves-effect{
            min-width: 50px;
            margin: 3px;
        }
        @font-face {
            font-family: 'arabicFont'; /*a name to be used later*/
            src: url('{{asset('/fonts/Cairo.ttf')}}'); /*URL to font*/
        }
        @font-face {
            font-family: 'jannahFont'; /*a name to be used later*/
            src: url('{{asset('/fonts/janna.ttf')}}'); /*URL to font*/
        }
        *{
            font-family: arabicFont;
        }
        .filters_container label{
            font-size: 17px;
        }
        .flatpickr-input[readonly] {
            direction: ltr;
        }
        .table th {
            font-weight: 600;
            font-size:1.3em;
        }
    </style>

@yield('css')
    <!-- fontawesome icons init -->

</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">
    @auth()
    @include('Dashboard.Includes.header')
    {{--@include('Dashboard.Includes.leftSideMenu')--}}
    @endauth

        <div class="loader-container">
            <span class="loader"></span>
            <h3 class="text-center text-white">{{__('frontend.loading')}}</h3>
        </div>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
        <div class="main-content m-md-0">
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    <!-- end main content-->


</div>
<!-- END layout-wrapper -->
@auth()
@include('Dashboard.Includes.rightSideMenu')
@endauth
<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

<!-- apexcharts -->
<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

<!-- Plugins js-->
<script src="{{asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js')}}"></script>

<script src="{{asset('assets/js/pages/dashboard.init.js')}}"></script>

<!-- Required datatable js -->
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/jq.tablesort.js')}}"></script>
<!-- Sweet Alerts js -->
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/fontawesome.init.js')}}"></script>
<script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>

<script src="{{asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script>


    $(document).ready(function () {
        $('.loader-container').addClass('d-none');
        @if(session('success'))
        Swal.fire({
            title: "{{__('frontend.success')}}",
            text: '{{session('success')}}',
            icon: "success",
            confirmButtonColor: "#1cbb8c",
            confirmButtonText: "{{__('frontend.ok')}}",
        });
        @endif
            $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function() {
                $('.loader-container').removeClass('d-none');
            },
            complete: function() {
                $('.loader-container').addClass('d-none');
            },
        });
        $(document).ready(function(){
            $(".select2-search-disable").select2({minimumResultsForSearch:1/0})

            $(".custom-data-table .data-search-input").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(this).closest('.custom-data-table').find('table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

    });
</script>
@yield('js')

</body>

</html>
