<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Online Reservations') }}</title>

    <link rel="stylesheet" href="/css/main.css">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    />
    <link href="{!! url('assets/css/signin.css') !!}" rel="stylesheet">
    
    <style>
        footer {
            position: relative;
            background-color: #ef3b2d;
            text-align: center;
        }
        .copyright{
            position: absolute;
           
            padding: 5px;
            position: fixed;
            top: 95%;
            left: 75%;
            transform: translate(-50%, -50%);
        
        }
        .footer-button {
          
            background-color:black;
            width: 10%;
            padding: 5px;
            position: fixed;
            top: 95%;
            left: 90%;
            transform: translate(-50%, -50%);
            text-decoration-line: none;
        }
  
       
    </style>

     <!-- Fonts -->
     <link rel="dns-prefetch" href="//fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

     <link rel="stylesheet" type="text/css" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/dist/mdb5/standard/core.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


     {{-- Added css --}}
      <!-- site icon -->
      <link rel="icon" href="{{asset('images/fevicon.png')}}" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
      <!-- site css -->
      <link rel="stylesheet" href="{{asset('style.css')}}" />
      <!-- responsive css -->
      <link rel="stylesheet" href="{{asset('css/responsive.css')}}" />
      <!-- color css -->
      <link rel="stylesheet" href="{{asset('css/colors.css')}}" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="{{asset('css/bootstrap-select.css')}}" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="{{asset('css/perfect-scrollbar.css')}}" />
      <!-- custom css -->
      <link rel="stylesheet" href="{{asset('css/custom.css')}}" />


      <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
      <link rel="stylesheet" type="text/css" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/dist/mdb5/standard/core.min.css">
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->


        {{-- <script type="text/javascript" src="../../js/jquery.slim.min.js"></script> --}}
        {{-- <script type="text/javascript" src="../../js/bootstrap.min.js"></script> --}}

    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script>  --}}
    {{-- <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        laravel: "#ef3b2d",
                    },
                },
            },
        };
    </script> --}}
    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>  --}}

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="dashboard dashboard_1">
    
    <!-- Authentication Links -->
    @guest
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <!-- Left Side Of Navbar -->
     <ul class="navbar-nav me-auto">

     </ul>

     <!-- Right Side Of Navbar -->
     <ul class="navbar-nav ms-auto">

        @if (Route::has('login'))
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @endif

        @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" style="color:white;" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @endif

         </ul>
     </div>

    @else

    <div class="full_container">
        <div class="inner_container">
           <!-- Sidebar  -->
           <nav id="sidebar">
              <div class="sidebar_blog_1">
                 <div class="sidebar-header">
                    {{-- <div class="logo_section">
                       <img class="logo_icon img-responsive" src="../../images/logo/logo_icon.png" alt="#" /></a>
                    </div> --}}
                 </div>
                 <div class="sidebar_user_info">
                    <div class="icon_setting"></div>
                    <div class="user_profle_side">
                       {{-- <div class="user_img"><img class="img-responsive" src="../../images/layout_img/user_img.png" alt="#" /></div> --}}
                       <div class="user_info">
                          <h6>{{ Auth::user()->username }}</h6>
                          <p><span class="online_animation"></span> Online</p>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="sidebar_blog_2">
                
                 <ul class="list-unstyled components">
                    <li class="active">
                       <li><a href="/"><i class="fa fa-dashboard yellow_color"></i> <span>Users</span></a></li>           
                    </li>
                   
                    <li><a href="/users/{{Auth::user()->id}}/edit"><i class="fa fa-table purple_color2"></i> <span>Edit User Information</span></a></li>
                    <li><a href="{{ URL('info') }}"><i class="fa fa-object-group blue2_color"></i> <span>Personal Information</span></a></li>

             </ul>
              </div>
           </nav>
           <!-- end sidebar -->
           <!-- right content -->
           <div id="content">
              <!-- topbar -->
              <div class="topbar">
                 <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        {{-- <a class="navbar-brand" style="color:white;" href="{{ url('/') }}">
                            {{ config('app.name', 'Online Reservations') }}
                        </a> --}}
                <div class="full">
                <button type="button" style="margin-left: -15px;" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                
                <div style="text-align:center;margin-top:20px;margin-left:500px;">
                   <form action="" >
                       <input type="text" name="search" >
                       <input type="submit" name="search_btn" value="Search" >
                   </form>
                </div>
               </div>
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                   <span class="navbar-toggler-icon"></span>
               </button> 

              
                       
                                                   
                           
                           <li class="nav-item dropdown">
                               <a id="navbarDropdown"  style="color:white;" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                   {{ Auth::user()->username }}
                               </a>

                               <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                   <a class="dropdown-item" href="{{ route('logout') }}"
                                      onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                       {{ __('Logout') }}
                                   </a>

                                   <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                       @csrf
                                   </form>
                               </div>
                           </li>
                          
                       @endguest
                   
           </div>
        </nav>
        </div>
           
                      
              <!-- end topbar -->
              <!-- dashboard inner -->
                 {{-- <h1 style="width:50%;margin:auto;margin-top:100px;">Welcome to Student Gate!</h1> --}}             
                <main class="py-4"> 
                 @yield('content')
                </main>
              <!-- end dashboard inner -->
           </div>
        </div>
     </div>

    
        
    
    @if(Auth::user() && Auth::user()->is_admin==1)
    <footer>
        <p class="copyright">Copyright &copy; 2023, All Rights reserved</p>
        <a href="/users/create" class="footer-button ">Create User</a>
    </footer>
    @endif


     <!-- jQuery -->
     <script src="{{ asset('js/jquery.min.js') }}"></script>
     <script src="{{ asset('js/popper.min.js') }}"></script>
     {{-- <script src="{{ asset('js/bootstrap.min.js')}}"></script> --}}

     <!-- wow animation -->
     <script src="{{ asset('js/animate.js') }}"></script>
     <!-- select country -->
     <script src="{{ asset('js/bootstrap-select.js') }}"></script>
     <!-- owl carousel -->
     <script src="{{ asset('js/owl.carousel.js') }}"></script> 
     <!-- chart js -->
     <script src="{{ asset('js/Chart.min.js') }}"></script>
     <script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
     <script src="{{ asset('js/utils.js') }}"></script>
     <script src="{{ asset('js/analyser.js') }}"></script>
     <!-- nice scrollbar -->
     <script src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>
     <script>
        var ps = new PerfectScrollbar('#sidebar');
     </script>
     <!-- custom js -->
     <script src="{{ asset('js/custom.js') }}"></script>
     <script src="{{ asset('js/chart_custom_style1.js') }}"></script>

</body>
</html>
