<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    @yield('style')
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        
        .page-footer {
            background-color: #494949;
            color: white;
        }
        footer.page-footer .footer-copyright {
            overflow: hidden;
            color: rgba(255,255,255,.6);
            background-color: rgba(0,0,0,.2);
        }
        .bg-maroon {
            background-color: #8d1436 !important;
        }
        #mainnav.navbar-light .navbar-nav .nav-link {
            color: rgb(255 255 255);
            font-weight: 600 !important;
        }
        #mainnav.navbar-light .navbar-nav .nav-link:hover {
            color: #FFb61C;
            font-weight: 600 !important;
        }
        #nav-logo{
            max-height: 42px;
        }
        #mainnav .dropdown-menu {
            background: #8d1436;
            border-radius: 0px;
        }
        #mainnav .dropdown-item {
            color: #fff;
            font-weight: 600;
        }

        #mainnav .dropdown-item:hover, .dropdown-item:focus {
            background-color: #801533;
            color: #FFb61C !important;
        }
        .modal-header{
            border-bottom: 0px !important;
        }
        .modal-footer{
            border-top: 0px !important;
        }
        .modal-title {
            font-weight: 600;
        }

        .modal:before {
        vertical-align: middle;
        }
        .green-text {
            color: #00563F;
        }
        .green-border-top {
            border-top: solid 4px #00563F;
        }


        /* nav */
        .breadcrumb {
            background: white;
            border: 1px solid thin;

            border: solid #ccc;
            border-width: 1px 0px 1px 0px;
            border-radius: 0px;
        }

        /* lighbox */
        .lightbox-toggle {
        color: black;
        }

        .backdrop {
            z-index: 1;
            opacity: .0;
            filter: alpha(opacity=0);
            display: none;
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            background: #000;
        }
        
        .box {
            z-index: 2;
            position: fixed;
            opacity: 1;
            display: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            height: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            -moz-box-shadow: 0px 0px 5px #444444;
            -webkit-box-shadow: 0px 0px 5px #444444;
            box-shadow: 0px 0px 5px #444444;

            * {
                z-index: 3;
            }

            .close {
                float: right;
                cursor: pointer;
            }
            .footer{
                margin-bottom: -100px;
            }
        }
    </style>
</head>