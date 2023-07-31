<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

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
            left: 45%;
            transform: translate(-50%, -50%);
        
        }
        .footer-button {
          
            background-color:black;
            width: 10%;
            padding: 5px;
            position: fixed;
            top: 95%;
            left: 60%;
            transform: translate(-50%, -50%);
            text-decoration-line: none;
        }
        .footer-button-2 {
          
          background-color:black;
          width: 10%;
          padding: 5px;
          position: fixed;
          top: 95%;
          left: 70%;
          margin-left:10px;
          transform: translate(-50%, -50%);
          text-decoration-line: none;
      }
      .footer-button-3 {
          
          background-color:black;
          width: 10%;
          padding: 5px;
          position: fixed;
          top: 95%;
          left: 80%;
          margin-left:20px;
          transform: translate(-50%, -50%);
          text-decoration-line: none;
      }
      .footer-button-4 {
          
          background-color:black;
          width: 10%;
          padding: 5px;
          position: fixed;
          top: 95%;
          left: 90%;
          margin-left:30px;
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

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style2.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="dashboard dashboard_1">
<div class="full_container">
    <div class="inner_container">

    <!-- Authentication Links -->
    @guest
   
  
<!-- topbar -->
<div class="topbar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" style="color:white;" href="{{ url('/') }}">
                {{ config('app.name', 'Online Store') }}
            </a>
     
        
         <ul class="flex space-x-6 mr-6 text-lg">
          <li class="nav-item dropdown">
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
          </li>
        </ul>
        </div>
        </nav>
    </div>


    @else

    
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
                   
                    <li><a href="/vendors"><i class="fa fa-table purple_color2"></i> <span>Vendors</span></a></li>
                    <li><a href="/brands"><i class="fa fa-object-group blue2_color"></i> <span>Brands</span></a></li>
                    <li><a href="/items"><i class="fa fa-object-group blue_color"></i> <span>Items</span></a></li>
                    <li><a href="/inventories"><i class="fa fa-table purple_color"></i> <span>Inventories</span></a></li>


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
                        
                <div class="full">
                <button type="button" style="margin-left: -15px;" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                
                <div style="text-align:center;margin-top:20px;margin-left:500px;">
                   <form action="" >
                    @csrf
                       <input type="text" name="name" >
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
                             
                <main class="py-4"> 
                 <div class="container">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12 main-section">
            <div class="dropdown">
                <button type="button" class="btn btn-info" data-toggle="dropdown">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                </button>
                <div class="dropdown-menu">
                    <div class="row total-header-section">
                        <div class="col-lg-6 col-sm-6 col-6">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                        </div>
                        {{-- <?php $total = 0 ?> --}}
                        {{-- @foreach((array) session('cart') as $id => $details)
                            <?php $total += $details['price'] * $details['quantity'] ?>
                        @endforeach --}}
                        {{-- <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                            <p>Total: <span class="text-info">$ {{ $total }}</span></p>
                        </div> --}}
                    </div>
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            <div class="row cart-detail">
                                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                    <img src="{{ $details['image'] ? asset('images/'.$details['image']) : asset('/images/Caption-for-Profile.jpg') }}" />
                                </div>
                                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                    <p>{{ $details['name'] }}</p>
                                    {{-- <span class="price text-info"> ${{ $details['price'] }}</span> <span class="count"> Quantity:{{ $details['quantity'] }}</span> --}}
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                            <a href="{{ url('cart') }}" class="btn btn-primary btn-block">View all</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container page">
    @yield('content')
</div>
    
                </main>
              <!-- end dashboard inner -->
           </div>
        </div>
     </div>

    
        
    @if(Auth::user() && Auth::user()->is_admin==1)
    <footer>
        <p class="copyright">Copyright &copy; 2023, All Rights reserved</p>
        <a href="/users/create" class="footer-button ">Create User</a>
        <a href="/vendors/create" class="footer-button-2 ">Create Vendor</a>
        <a href="/brands/create" class="footer-button-3 ">Create Brand</a>
        <a href="/items/create" class="footer-button-4 ">Create Item</a>
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

     {{-- <script type="text/javascript" src="js/filters.min.js"></script> --}}
     <script src="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/js/dist/mdb5/plugins/standard/filters.min.js"></script>
     @yield('scripts')
</body>
</html>
