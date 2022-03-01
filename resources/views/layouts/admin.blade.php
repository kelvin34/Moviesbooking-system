<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Tempusdominus Bootstrap 4 -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
      <!-- iCheck -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
      <!-- JQVMap -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
      <!-- Theme style -->
      <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker3.css') }}">
      <!-- summernote -->
        <!-- Select2 -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

         <!-- Toastr -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

      <!-- DataTables -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css.css') }}" rel="stylesheet">
    @yield('css')
</head>
<!-- <a href="/admin/dashboard" class="brand-link">
          <img src="{{ asset('assets/img/logo.png') }}" alt="App Logo" class="brand-image elevation-1" style="opacity: .8">
          <span>Admin</span>
         <br>
        </a> -->
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div id="app" >
    <div class="wrapper">
      <!-- Navbar -->
       <!-- style="background-color: #EAFAFA;padding:0px;" -->
      <nav class="main-header navbar navbar-expand navbar-primary fixed-top bg-success sidebar-collapse p-0">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin/home" class="nav-link">Home</a>
          </li>

        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fa fa-bell fa-2x text-white"></i>
              <span class="badge badge-light navbar-badge unreadcount">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right bg-light m-0 p-0" style="width: 400px;">
              <span class="dropdown-item dropdown-header">Notifications <span class="badge badge-success text-dark float-right p-1 text-sm"><span class="unreadcount">0</span> New</span></span>
                <div class="allunreadnotifications bg-white" id="allunreadnotifications">
                
                </div>
                

              <div class="dropdown-divider"></div>
              <button class="btn btn-link btn-block btn-outline"><a href="/admin/notifications" class="text-dark" >View All Notifications</a></button>
              
            </div>
          </li>
          <li class="nav-item">
            <div class="user-panel mt-1 pb-1 mb-1 d-flex">
                <div class="">
                  <img src="{{ asset('assets/img/avatar.png') }}" class="profile-user-img img-circle elevation-2" alt="User Image">
                </div>
            </div>
          </li>
          <li class="nav-item dropdown">
              @if (Route::has('login'))
                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->fname }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right bg-info" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('/admin/profile') }}">{{ __('Profile') }}</a>
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
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @endauth
            @endif
          </li>

        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar elevation-4 bg-secondary">
        <!-- Brand Logo -->
        <img
            width="30"
            alt="{{ config('app.name', 'Movies Booking System') }} Logo"
            src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNTAgMjUwIj4KICAgIDxwYXRoIGZpbGw9IiNERDAwMzEiIGQ9Ik0xMjUgMzBMMzEuOSA2My4ybDE0LjIgMTIzLjFMMTI1IDIzMGw3OC45LTQzLjcgMTQuMi0xMjMuMXoiIC8+CiAgICA8cGF0aCBmaWxsPSIjQzMwMDJGIiBkPSJNMTI1IDMwdjIyLjItLjFWMjMwbDc4LjktNDMuNyAxNC4yLTEyMy4xTDEyNSAzMHoiIC8+CiAgICA8cGF0aCAgZmlsbD0iI0ZGRkZGRiIgZD0iTTEyNSA1Mi4xTDY2LjggMTgyLjZoMjEuN2wxMS43LTI5LjJoNDkuNGwxMS43IDI5LjJIMTgzTDEyNSA1Mi4xem0xNyA4My4zaC0zNGwxNy00MC45IDE3IDQwLjl6IiAvPgogIDwvc3ZnPg=="
          />

        <a class="navbar-brand" href="{{ url('/home') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        <div class="user-panel pb-1 d-flex">
            <div class="image">
              <img src="{{ asset('assets/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a class="dropdown-item text-light" href="/admin/my-account"><span class="text-lime text-bold">{{ Auth::user()->fname }} ({{ Auth::user()->roles }})</span></a>
                 
            </div>
          </div>

        <!-- Sidebar -->
        <div class="sidebar bg-dark">
          <!-- Sidebar user panel (optional) -->
        

          <!-- SidebarSearch Form -->
          <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->

              <li class="nav-item">
                <a href="/admin/home" class="nav-link">
                  <i class="fa fa-home nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/admin/onair" class="nav-link">
                  <i class="fa fa-fire nav-icon"></i>
                  <p>On Air</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="/admin/movies" class="nav-link">
                  <i class="fa fa-film nav-icon"></i>
                  <p>Movies</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/admin/upcoming" class="nav-link">
                  <i class="fa fa-fire nav-icon"></i>
                  <p>Upcoming</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/admin/screens" class="nav-link">
                  <i class="fa fa-desktop nav-icon"></i>
                  <p>Screens</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link text-light">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Accounts
                    <i class="fas fa-angle-left right"></i>
                    
                  </p>
                </a>
                <ul class="nav nav-treeview bg-olive">
                  <li class="nav-item">
                    <a href="/admin/newmember" class="nav-link">
                      <i class="fa fa-user nav-icon"></i>
                      <p>New Member</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="/admin/members" class="nav-link">
                      <i class="fa fa-users nav-icon"></i>
                      <p>Members</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="/admin/plans" class="nav-link">
                      <i class="fa fa-list nav-icon"></i>
                      <p>Subs Plans</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="/admin/subscribed" class="nav-link">
                      <i class="fa fa-users nav-icon"></i>
                      <p>Subscribed</p>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="/admin/payments" class="nav-link">
                      <i class="fa fa-briefcase nav-icon"></i>
                      <p>Payments</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="/admin/wallets" class="nav-link">
                      <i class="fa fa-book nav-icon"></i>
                      <p>Wallets Usage</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="/admin/tickets-sales" class="nav-link">
                      <i class="fa fa-credit-card  nav-icon"></i>
                      <p>Tickets Sales</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="/admin/requests" class="nav-link">
                  <i class="fa fa-bomb nav-icon"></i>
                  <p>Requests</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/admin/refunds" class="nav-link">
                  <i class="fa fa-gift nav-icon"></i>
                  <p>Refunds</p>
                </a>
              </li>
              
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
              @if(Auth::user()->roles=="Admin")
                <div class="content-wrapper">
                  <!-- Content Header (Page header) -->
                    <div class="content-header bg-white " style="padding: 5px;padding-top:50px;margin: 0px;">
                      <div class="row mb-2 elevation-3">
                        @yield('HeaderTitle')
                      </div>
                    </div>
                  <section class="content bg-white">

                    <div class="">
                        @yield('content')
                @else
                  <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                      <div class="content-header bg-white " style="padding: 5px;padding-top:50px;margin: 0px;">
                        <div class="row mb-2 elevation-3">
                          @yield('HeaderTitle')
                        </div>
                      </div>
                    <section class="content bg-white">

                      <div class="">
                          <div class="p-1 m-1">
                          <h4 class="text-danger text-center">Unauthorised Access. Please Logout</h4>
                      </div>
                @endif

              <!-- confirmation modals -->
                <div class="modal fade" id="confirm-modal" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title text-center" id="confirm-title">Default Modal</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body bg-warning" id="confirm-msg" style="padding: 10px;margin:10px;">
                      <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary confirm-okay" id="confirm-okay">Save changes</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- end of modals -->

              <!-- message Modal modals -->
                <div class="modal fade" id="message-modal" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                      <h4 class="modal-title " id="message-title">Message Title</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body bg-success" id="message-msg" style="padding: 10px;margin:10px;">
                      <p>Message Body</p>
                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- end of modals -->

              <!-- start modal page -->
              <div class="modal fade" id="modalpage" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="modal-title text-center" id="modalpage-title">Message Title</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalpage-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      <p>Message Body</p>
                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal page -->


              <!-- start modal movie new -->
              <div class="modal fade" id="modalmovie" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalmovie-title">Add New Movie</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalmovie-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      <!-- start -->
                          <div class="card-body p-1 m-0">
                              <form method="POST" action="/admin/movie/new" class="m-0 p-0">
                                  @csrf
                                  <span class="text-danger erroradding"></span>
                                  <input type="hidden" name="movieid" id="movieid" value="">
                                  <div class="form-group row m-1">
                                      <label for="title" class="col-md-3 col-form-label text-md-right">{{ __('Movie Title') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="First Title" required autocomplete="title" autofocus>

                                          @error('title')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1" id="genrediv">
                                      <label for="genre" class="col-md-3 col-form-label text-md-right">{{ __('Movie Genre') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                        <select class="form-control select2bs4" name="genre" id="genre" >
                                          <option value="">Movie Genre</option>
                                          <option value="Action">Action</option>
                                          <option value="Drama">Drama</option>
                                          <option value="Series">Series</option>
                                          <option value="Documentary">Documentary</option>
                                          <option value="Other">Other</option>
                                        </select>
                                          @error('genre')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  

                                  <div class="form-group row m-1">
                                      <label for="film" class="col-md-3 col-form-label text-md-right">{{ __('Film/Studio') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="film" type="text" class="form-control @error('film') is-invalid @enderror" name="film" value="{{ old('film') }}" placeholder="Film/Studio" required autocomplete="film" autofocus>

                                          @error('film')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1" >
                                      <label for="director" class="col-md-3 col-form-label text-md-right">{{ __('Director') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="director" type="text" class="form-control @error('director') is-invalid @enderror" name="director" value="{{ old('director') }}" placeholder="Director(s)" required autocomplete="director" autofocus>

                                          @error('director')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>


                                  <div class="form-group row m-1">
                                      <label for="description" class="col-md-3 col-form-label text-md-right">{{ __('Description') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" placeholder="Movie Description" required autocomplete="description"></textarea>
                                          @error('description')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1 mb-0">
                                      <div class="col-md-9  offset-md-3">
                                          <button type="submit" class="btn btn-primary" id="submitbtn">
                                              {{ __('Submit New Movie Details') }}
                                          </button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal movie new -->

              <!-- start modal page -->
            <div class="modal fade" id="thrillerpage" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="thrillerpage-title">Preview Thriller</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="thrillerpage-body">
                      <p>Thriller Here</p>
                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
            <!-- end modal page -->

              <!-- start modal movie thriller -->
              <div class="modal fade" id="modalthriller" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalthriller-title">Upload Thriller</h4>
                      <button type="button" class="close closeaddmoviethriller" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalthriller-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      <!-- start -->
                          <div class="card-body p-1 m-0">
                                  <div class="col-md-12 p-0 m-1">
                                      <form></form>

                                      <form method="post" action="/admin/movie/thriller/add" class="dropzone" id="dropzoneForm" style="border: 4px dotted gray; ">
                                          @csrf
                                          
                                          <input type="hidden" name="movieidthriller" id="movieidthriller" value="">
                                      </form> 
                                    </div>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right closeaddmoviethriller" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal movie thriller -->

              <!-- start modal movie cover -->
              <div class="modal fade" id="modalcover" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalcover-title">Upload Thriller</h4>
                      <button type="button" class="close closeaddmoviethriller" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalcover-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      <!-- start -->
                          <div class="card-body p-1 m-0">
                                  <div class="col-md-12 p-0 m-1">
                                      <form></form>

                                      <form method="post" action="/admin/movie/cover/add" class="dropzone" id="dropzoneFormCover" style="border: 4px dotted gray; ">
                                          @csrf
                                          
                                          <input type="hidden" name="movieidcover" id="movieidcover" value="">
                                      </form> 
                                    </div>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right closeaddmoviethriller" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal movie cover -->

              <!-- start modal screens new -->
              <div class="modal fade" id="modalscreen" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalscreen-title">Add New Screen</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalscreen-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      <!-- start -->
                          <div class="card-body p-1 m-0">
                              <form method="POST" action="/admin/screen/new" class="m-0 p-0">
                                  @csrf
                                  <span class="text-danger erroradding"></span>
                                  <input type="hidden" name="screenmovieid" id="screenmovieid" value="">
                                  <div class="form-group row m-1">
                                      <label for="screen" class="col-md-3 col-form-label text-md-right">{{ __('Screen Name') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="screen" type="text" class="form-control @error('screen') is-invalid @enderror" name="screen" value="{{ old('screen') }}" placeholder="Screen Name" required autocomplete="screen" autofocus>

                                          @error('screen')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>


                                  <div class="form-group row m-1">
                                      <label for="rowsleft" class="col-md-3 col-form-label text-md-right">{{ __('Seats/Row (Left)') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="rowsleft" type="number" class="form-control @error('rowsleft') is-invalid @enderror" name="rowsleft" value="{{ old('rowsleft') }}" min="1" max="100" placeholder="Seats Per Row in Left Column" required autocomplete="rowsleft" autofocus>

                                          @error('rowsleft')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1">
                                      <label for="rowscenter" class="col-md-3 col-form-label text-md-right">{{ __('Seats/Row (Center)') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="rowscenter" type="number" class="form-control @error('rowscenter') is-invalid @enderror" name="rowscenter" value="{{ old('rowscenter') }}" min="1" max="100" placeholder="Seats Per Row in Center Column" required autocomplete="rowscenter" autofocus>

                                          @error('rowscenter')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>


                                  <div class="form-group row m-1">
                                      <label for="rowsright" class="col-md-3 col-form-label text-md-right">{{ __('Seats/Row (Right)') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="rowsright" type="number" class="form-control @error('rowsright') is-invalid @enderror" name="rowsright" value="{{ old('rowsright') }}" min="1" max="100" placeholder="Seats Per Row in Right Column" required autocomplete="rowsright" autofocus>

                                          @error('rowsright')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>


                                  <div class="form-group row m-1" >
                                      <label for="capacity" class="col-md-3 col-form-label text-md-right">{{ __('Screen Capacity') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="capacity" type="number" class="form-control @error('capacity') is-invalid @enderror" name="capacity" value="{{ old('capacity') }}"  min="3" max="100000" placeholder="Capacity" required autocomplete="capacity" autofocus>

                                          @error('capacity')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>


                                  <div class="form-group row m-1 mb-0">
                                      <div class="col-md-9  offset-md-3">
                                          <button type="submit" class="btn btn-primary" id="screensubmitbtn">
                                              {{ __('Submit New Screen Details') }}
                                          </button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal screens new -->


              <!-- start modal set upcoming date -->
              <div class="modal fade" id="modalreleaseon" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalreleaseon-title">Set Movie Release and On Air Date</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalreleaseon-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      <!-- start -->
                          <div class="card-body p-1 m-0">
                              <form method="POST" action="/admin/upcoming/new" class="m-0 p-0">
                                  @csrf
                                  <span class="text-danger erroradding"></span>
                                  <input type="hidden" name="upcomingmovieid" id="upcomingmovieid" value="">
                                  <input type="hidden" name="releasedatemovieid" id="releasedatemovieid" value="">
                                  <input type="hidden" name="timezone" id="timezone">
                                  <input type="hidden" name="release_on" id="release_on">
                                  <input type="hidden" name="release_off" id="release_off">

                                  <div class="form-group row m-1">
                                      <label for="screenair" class="col-md-3 col-form-label text-md-right">{{ __('Screen') }} <span class="text-danger"><sup>*</sup></span></label>
                                      <div class="col-md-9">
                                        <select class="form-control select2bs4" name="screenair" id="screenair" required style="width: 100%;">
                                          <option value="">Choose Screen</option>
                                          
                                        </select>
                                        @error('screenair')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                        @enderror
                                      </div>

                                  </div>

                                  <div class="form-group row m-1">
                                    <label for="" class="col-md-3 col-form-label text-md-right">{{ __('Airing From') }} <span class="text-danger"><sup>*</sup></span></label>
                                   
                                    <div class="col-md-9 row">
                                      <div class="col-md-7">
                                        <input type="date" id="startreleasedated" class="form-control @error('datetimeto') is-invalid @enderror" name="startreleasedated" value="{{ old('startreleasedated') }}" placeholder="{{date('d/M/Y')}}"  required autocomplete="startreleasedated" autofocus>
                                      </div>
                                      <div class="col-md-5">
                                        <input type="time" id="startreleasetimed" class="form-control @error('startreleasetimed') is-invalid @enderror" name="startreleasetimed" value="{{ old('startreleasetimed') }}" placeholder="23:59"  required autocomplete="startreleasetimed" autofocus>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group row m-1">
                                    <label for="" class="col-md-3 col-form-label text-md-right">{{ __('Airing To') }} <span class="text-danger"><sup>*</sup></span></label>
                                   
                                    <div class="col-md-9 row">
                                      <div class="col-md-7">
                                        <input type="date" id="endreleasedated" class="form-control @error('datetimeto') is-invalid @enderror" name="endreleasedated" value="{{ old('endreleasedated') }}" placeholder="{{date('d/M/Y')}}"  required autocomplete="endreleasedated" autofocus>
                                      </div>
                                      <div class="col-md-5">
                                        <input type="time" id="endreleasetimed" class="form-control @error('endreleasetimed') is-invalid @enderror" name="endreleasetimed" value="{{ old('endreleasetimed') }}" placeholder="23:59"  required autocomplete="endreleasetimed" autofocus>
                                      </div>
                                    </div>
                                  </div>



                                  <div class="form-group row m-1">
                                      <label for="release_on_info" class="col-md-3 col-form-label text-md-right">{{ __('Release Times') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input type="text"  id="release_on_info" readonly class="form-control @error('release_on_info') is-invalid @enderror" name="release_on_info" value="{{date('d/m/Y H:i')}}" placeholder="Airing Date and Time"  required autocomplete="release_on_info" autofocus>

                                            @error('release_on_info')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                      
                                  </div>


                                  <div class="form-group row m-1">
                                      <label for="VVIP" class="col-md-3 col-form-label text-md-right">{{ __('VVIP(Kshs)') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="VVIP" type="number" class="form-control @error('VVIP') is-invalid @enderror" name="VVIP" value="{{ old('VVIP') }}" min="1" max="100000" placeholder="VVIP Charges" required autocomplete="VVIP" autofocus>

                                          @error('VVIP')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1" >
                                      <label for="VIP" class="col-md-3 col-form-label text-md-right">{{ __('VIP(Kshs)') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="VIP" type="number" class="form-control @error('VIP') is-invalid @enderror" name="VIP" value="{{ old('VIP') }}"  min="1" max="100000" placeholder="VIP Charges" required autocomplete="VIP" autofocus>

                                          @error('VIP')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1" >
                                      <label for="Regular" class="col-md-3 col-form-label text-md-right">{{ __('Regular(Kshs)') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="Regular" type="number" class="form-control @error('Regular') is-invalid @enderror" name="Regular" value="{{ old('Regular') }}"  min="1" max="100000" placeholder="Regular Charges" required autocomplete="Regular" autofocus>

                                          @error('Regular')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1" >
                                      <label for="Terraces" class="col-md-3 col-form-label text-md-right">{{ __('Terraces(Kshs)') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="Terraces" type="number" class="form-control @error('Terraces') is-invalid @enderror" name="Terraces" value="{{ old('Terraces') }}"  min="1" max="100000" placeholder="Terraces Charges" required autocomplete="Terraces" autofocus>

                                          @error('Terraces')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>


                                  <div class="form-group row m-1 mb-0">
                                      <div class="col-md-9  offset-md-3">
                                          <button type="submit" class="btn btn-primary" id="releasedatesubmitbtn">
                                              {{ __('Submit On Air Date Details') }}
                                          </button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal set upcoming date -->


              <!-- start modal set movie stream -->
              <div class="modal fade" id="modalmoviestream" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalmoviestream-title">Set Movie Stream</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalmoviestream-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      <!-- start -->
                          <div class="card-body p-1 m-0">
                              <form method="POST" action="/admin/upcoming/stream" class="m-0 p-0">
                                  @csrf
                                  <span class="text-danger erroradding"></span>
                                  <input type="hidden" name="upcomingmoviestreamid" id="upcomingmoviestreamid" value="">
                                  <input type="hidden" name="releasedatemoviestreamid" id="releasedatemoviestreamid" value="">

                                  <div class="form-group row m-1">
                                      <label for="stream" class="col-md-3 col-form-label text-md-right">{{ __('Stream Link') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input type="text" class="form-control @error('stream') is-invalid @enderror" name="stream" id="stream" value="{{ old('stream') }}" placeholder="Movie Stream link" required autocomplete="stream" autofocus>

                                          @error('stream')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1 mb-0">
                                      <div class="col-md-9  offset-md-3">
                                          <button type="submit" class="btn btn-primary" id="moviestreamsubmitbtn">
                                              {{ __('Submit Stream Link') }}
                                          </button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal set movie stream -->

              <!-- start modal screens seats -->
              <div class="modal fade" id="modalscreenseat" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalscreenseat-title">Seat Arrangements</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="card-body text-center p-0 m-0" style="overflow-x:auto;">
                    <table border="1" class="table text-sm">
                        <tr>
                          <td class="p-1 bg-light">Available</td>
                          <td class="p-1 bg-purple">Taken</td>
                          <td class="p-1 bg-info">Selected</td>
                          <td class="p-1 bg-danger">Not Available</td>
                          <td class="p-1 text-lime">VVIP</td>
                          <td class="p-1 text-pink">VIP</td>
                          <td class="p-1 text-dark">Regular</td>
                          <td class="p-1 text-warning">Terraces</td>
                          <td class="p-1 text-dark"><i class="fa fa-check text-danger"> Not Yet In</i></td>
                          <td class="p-1 text-dark text-xs"><i class="fa fa-check text-success"> Accepted In</i></td>
                        </tr>
                      </table>
                    </div>
                    <div class="modal-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      
                      <!-- start -->
                          <div class="card-body text-center p-1 m-0">

                              <form method="POST" action="/admin/screen/new" class="m-0 p-0">
                                  @csrf
                                  <span class="text-danger erroradding"></span>
                                  <input type="hidden" name="screenid" id="screenid" value="">
                                  <input type="hidden" name="screenidmovie" id="screenidmovie" value="">
                                  <div class="text-center" id="modalscreenseat-body">
                                    
                                  </div>
                              </form>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-danger closebookedticketcheck">Refresh</button>
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal screens seats -->

              <!-- start modal screens usage -->
              <div class="modal fade" id="modalscreenusage" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalscreenusage-title">Screen Usages</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      
                      <!-- start -->
                          <div class="card-body p-1 m-0">
                            <div class="row justify-content-center" id="modalscreenusage-body">
                              
                            </div>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal screens usage -->

              <!-- start modal screens seats sections -->
              <div class="modal fade " id="modalscreensection" role="dialog" aria-hidden="false" data-backdrop="false" >
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalscreensection-title">Seat Sections</h4>
                      <button type="button" class="close closeseatsscreensection" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- start -->
                          <div class="card-body text-center p-1 m-0">

                              <form method="POST" action="/admin/screen/update" class="m-0 p-0">
                                  @csrf
                                  <div class="form-group row bg-light p-0 m-0 ">
                                    <label for="updatestatus" class="col-md-3 col-form-label text-md-right">Choose what to Update</label>

                                    <div class="col-md-4 p-1 m-0">
                                        <select name="updatestatus" id="updatestatus" class="select form-control" required="required">
                                            <option value="">Choose what to Update...</option>
                                            <option value="VVIP">Set VVIP Seat</option>
                                            <option value="VIP">Set VIP Seat</option>
                                            <option value="Regular">Set Regular Seat</option>
                                            <option value="Terraces">Set Terraces Seat</option>
                                            <option value="Good">Set Good Condition</option>
                                            <option value="Blocked">Set Blocked Condition</option>
                                            <option value="Maintenance">Set Maintenance Condition</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-sm-2 p-1 m-0">
                                        <button  class="btn btn-success  btn-large" name="submitupdatebtn" id="submitupdatebtn"  type="submit" >Update Selected</button>
                                    </div>
                                    <div class="col-sm-2 m-0" style="padding: 0px;">
                                         <span style="position:fixed;z-index:999999;color:red;font-size:20px;padding: 2px;margin: 2px;"> Selected(<i class="badge" id="selectedseatforupdate" style="font-size:25px;">0</i>)</span>
                                    </div>
                                </div>
                                  <span class="text-danger erroradding"></span>
                                  <input type="hidden" name="screenidmovieid" id="screenidmovieid" value="">
                                    <table border="1" id="example1" class="table text-xs">
                                      <thead class="">
                                        <tr class="bg-info">
                                          <th class="p-1">Sno</th>
                                          <th class="p-1">Seat</th>
                                          <th class="p-1">Section</th>
                                          <th class="p-1">Status</th>
                                        </tr>
                                      </thead>
                                      <tbody id="modalscreensection-body" class="p-0">

                                      </tbody>
                                    </table>
                              </form>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right closeseatsscreensection" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal screens seats sections -->

              <!-- start modal ticket booked-->
              <div class="modal fade" id="modalticketsseat" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalticketsseat-title">Seat Arrangements</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="card-body text-center p-0 m-0" style="overflow-x:auto;">
                    <table border="1" class="table text-sm">
                        <tr>
                          <td class="p-1 bg-light">Available</td>
                          <td class="p-1 bg-purple">Taken</td>
                          <td class="p-1 bg-info">Selected</td>
                          <td class="p-1 bg-danger">Not Available</td>
                          <td class="p-1 text-lime">VVIP</td>
                          <td class="p-1 text-pink">VIP</td>
                          <td class="p-1 text-dark">Regular</td>
                          <td class="p-1 text-warning">Terraces</td>
                        </tr>
                      </table>
                    </div>
                    <div class="modal-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      
                      <!-- start -->
                          <div class="card-body text-center p-1 m-0">

                              <form method="POST" action="/admin/screen/new" class="m-0 p-0">
                                  @csrf
                                  <span class="text-danger erroradding"></span>
                                  <input type="hidden" name="screenidticket" id="screenidticket" value="">
                                  <input type="hidden" name="screenidticketmovie" id="screenidticketmovie" value="">
                                  <div class="text-center" id="modalticketsseat-body">
                                    
                                  </div>
                              </form>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal ticket booked-->

              <!-- start modal booked seat details -->
              <div class="modal fade " id="modalbookedseatdetails" role="dialog" aria-hidden="false" data-backdrop="false" >
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalbookedseatdetails-title">Seat Sections</h4>
                      <button type="button" class="close closebookedtickets" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- start -->
                          <div class="card-body text-center p-1 m-0">
                            <table border="1" id="example2" class="table text-xs">
                              <thead class="">
                                <tr class="bg-info">
                                  <th class="p-1">Seat</th>
                                  <th class="p-1">Ticket</th>
                                  <th class="p-1">Holder</th>
                                  <th class="p-1">Sold</th>
                                  <th class="p-1">Used</th>
                                  <th class="p-1">Status</th>
                                </tr>
                              </thead>
                              <tbody id="modalbookedseatdetails-body" class="p-0">

                              </tbody>
                            </table>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right closebookedtickets" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal booked seat details -->

                <!-- start modal seats -->
            <div class="modal fade" id="modalseats" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-cyan text-center">
                      <h4 class="mx-auto" id="modalseats-title">Confirm Payment</h4>
                      <button type="button" class="close closeseatpayment" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- start -->
                      <div class="card-body p-1 m-0">
                          <form method="POST" action="/admin/screen/new" class="m-0 p-0">
                              @csrf
                              <span class="text-danger erroradding"></span>
                              <input type="hidden" name="screenmovieid" id="screenmovieid" value="">
                              <div class="row">
                                  <div class="col-4 p-0 m-0">
                                      <input type="hidden" name="movie_id" id="movie_id" class="form-control " readonly>
                                      <input type="hidden" name="screen_id" id="screen_id" class="form-control " readonly>
                                      <input type="hidden" name="seat_id" id="seat_id" class="form-control " readonly>
                                      <input type="hidden" name="upcoming" id="upcoming" class="form-control " readonly>
                                      <input type="text" name="movie_name" id="movie_name" title="Movie Title/Name" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="screen_name" id="screen_name" title="Screen Name" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="seat_name" id="seat_name" title="Seat Name" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="seat_section" id="seat_section" title="Section Type" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="ticket_amount" id="ticket_amount" title="Ticket Amount" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="start_date" id="start_date" title="Movie Start Time" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="end_date" id="end_date" title="Movie End Time" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="payment_method" id="payment_method" title="Payment Method" value="Payment Method: MPESA" class="form-control p-1 m-1" readonly>
                                  </div>
                                  <div class="col-8">
                                      <!-- stt -->
                                      <label class="col-md-12 col-form-label text-md-center">{{ __('Confirm Amount And Proceed to Pay for Ticket') }} <span class="text-danger"><sup>*</sup></span></label>
                                      <div class="form-group row m-1">
                                          
                                          <label for="your_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }} <span class="text-danger"><sup>*</sup></span></label>

                                          <div class="col-md-8">
                                              <input id="your_number" type="text" class="form-control @error('your_number') is-invalid @enderror" name="your_number" value="254{{ Auth::user()->phone }}" readonly placeholder="Phone Number" required autocomplete="your_number" autofocus>

                                              @error('your_number')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                          </div>
                                      </div>

                                      <div class="form-group row m-1">
                                          
                                          <label for="wallet_balance" class="col-md-4 col-form-label text-md-right">{{ __('Wallet Bal') }} <span class="text-danger"><sup>*</sup></span></label>

                                          <div class="col-md-8">
                                              <input id="wallet_balance" type="text" class="form-control @error('wallet_balance') is-invalid @enderror" name="wallet_balance" readonly placeholder="Phone Number" required autocomplete="wallet_balance" autofocus>

                                              @error('wallet_balance')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                          </div>
                                      </div>

                                      <div class="form-group row m-1">
                                          <label for="total_amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount to Pay') }} <span class="text-danger"><sup>*</sup></span></label>

                                          <div class="col-md-8">
                                              <input id="total_amount" type="text" class="form-control @error('total_amount') is-invalid @enderror" name="total_amount" value="{{ old('total_amount') }}" readonly placeholder="Total Amount" required autocomplete="total_amount" autofocus>

                                              @error('total_amount')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                          </div>
                                      </div>


                                      <div class="form-group row m-1 mb-0 text-center">
                                          <div class="col-md-12 justify-content-center">
                                              <button type="button" class="btn btn-success" id="ticketbooksubmitbtn">
                                                  {{ __('Pay Now') }}(MPESA)
                                              </button>
                                          </div>
                                      </div>

                                      <div class="form-group row m-1">
                                          <div class="col-md-12" id="bookingstatus">
                                              
                                          </div>
                                      </div>
                                      <!-- endd -->
                                  </div>
                              </div>
                              
                          </form>
                      </div>
                      <!-- end -->
                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right closeseatpayment" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
            <!-- end modal seats -->


            <!-- start modal unpaid ticket -->
            <div class="modal fade" id="modalsuccessticket" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-cyan text-center">
                      <h4 class="mx-auto" id="modalsuccessticket-title">Reserved Seat</h4>
                      <button type="button" class="close closebookedticketcheck" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- start -->
                      <div class="card-body p-1 m-0">
                          <form method="POST" action="/admin/screen/new" class="m-0 p-0">
                              @csrf
                              <span class="text-danger erroradding"></span>
                              <div class="row">
                                  <div class="col-6 p-1 m-0">
                                      <input type="hidden" name="successmovie_id" id="successmovie_id" class="form-control " readonly>
                                      <input type="hidden" name="successscreen_id" id="successscreen_id" class="form-control " readonly>
                                      <input type="hidden" name="successseat_id" id="successseat_id" class="form-control " readonly>
                                      <input type="hidden" name="successupcoming" id="successupcoming" class="form-control " readonly>
                                      <input type="text" name="successmovie_name" id="successmovie_name" title="Movie Title/Name" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successscreen_name" id="successscreen_name" title="Screen Name" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successseat_name" id="successseat_name" title="Seat Name" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successseat_section" id="successseat_section" title="Section Type" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successticket_amount" id="successticket_amount" title="Ticket Amount" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successstart_date" id="successstart_date" title="Movie Start Time" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successend_date" id="successend_date" title="Movie End Time" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successpayment_method" id="successpayment_method" title="Payment Method" value="Payment Method: MPESA" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successstatus" id="successstatus" title="Ticket Status" class="form-control p-1 m-1" readonly>
                                  </div>
                                  <div class="col-6 p-1 m-0">
                                      <!-- stt -->
                                      <input type="text" name="successnames" id="successnames" title="Wallet Bal" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successyour_number" id="successyour_number" title="Phone Number" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successaccountno" id="successaccountno" title="Account Number" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successticket" id="successticket" title="Ticket" class="form-control p-1 m-1" readonly>
                                      <div class="bg-light p-1" id="successholder_status">
                                        
                                      </div>
                                      <div class="bg-light p-1" id="checkinstatus">
                                        
                                      </div>
                                      <!-- endd -->
                                  </div>
                              </div>
                              
                          </form>
                      </div>
                      <!-- end -->
                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right closebookedticketcheck" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
            <!-- end modal unpaid ticket -->

            <!-- start modal movie requests -->
              <div class="modal fade" id="modalnewrequest" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalnewrequest-title">View Movie Request</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalnewrequest-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      <!-- start -->
                          <div class="card-body p-1 m-0">
                              <form method="POST" action="/client/movie/requests/new" class="m-0 p-0">
                                  @csrf
                                  <span class="text-danger erroradding"></span>
                                  <input type="hidden" name="request_id" id="request_id">
                                  <div class="form-group row m-1">
                                      <label for="movie_title" class="col-md-3 col-form-label text-md-right">{{ __('Movie Requested') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="movie_title" type="text" class="form-control @error('movie_title') is-invalid @enderror" name="movie_title" value="{{ old('movie_title') }}" placeholder="Movie Title" required readonly autocomplete="movie_title" autofocus>

                                          @error('movie_title')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1">
                                      <label for="movie_request" class="col-md-3 col-form-label text-md-right">{{ __('Movie Request') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                        <textarea id="movie_request" class="form-control @error('movie_request') is-invalid @enderror" name="movie_request" value="{{ old('movie_request') }}" placeholder="Movie Description explaining Your request" rows="5" required readonly autocomplete="movie_request"></textarea>
                                          @error('movie_request')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1">
                                      <label for="requestmovieid" class="col-md-3 col-form-label text-md-right">{{ __('Movie Found') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                        <select class="form-control select2bs4" name="requestmovieid" id="requestmovieid" required style="width: 100%;">
                                          <option value="">Movie Found</option>
                                        </select>
                                          

                                          @error('requestmovieid')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1">
                                      <label for="request_comments" class="col-md-3 col-form-label text-md-right">{{ __('Comments') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                        <textarea id="request_comments" class="form-control @error('request_comments') is-invalid @enderror" name="request_comments" value="{{ old('request_comments') }}" placeholder="Your Response" rows="5" required autocomplete="request_comments"></textarea>
                                          @error('request_comments')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1 mb-0">
                                      <div class="col-md-9  offset-md-3">
                                          <button type="submit" class="btn btn-primary" id="savenewrequest">
                                              {{ __('Respond to Movie Request') }}
                                          </button>
                                      </div>
                                  </div>

                                  <div class="form-group row m-1 mb-0 text-center">
                                      <div class="col-md-12 bg-light justify-content-center newrequestresult" >
                                          
                                      </div>
                                  </div>

                              </form>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal movie requests -->

              <!-- start modal refund requests -->
              <div class="modal fade" id="modalnewrefundrequest" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalnewrefundrequest-title">View Refund Request</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalnewrefundrequest-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      <!-- start -->
                          <div class="card-body p-1 m-0">
                              <form method="POST" action="/client/movie/requests/new" class="m-0 p-0">
                                  @csrf
                                  <span class="text-danger erroradding"></span>
                                  <input type="hidden" name="refund_id" id="refund_id" value="">
                                  <div class="form-group row m-1">
                                      <label for="amount_requested" class="col-md-3 col-form-label text-md-right">{{ __('Amount Requested') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="amount_requested" type="text" class="form-control @error('amount_requested') is-invalid @enderror" name="amount_requested" value="{{ old('amount_requested') }}" placeholder="Amount Requested" required readonly autocomplete="amount_requested" autofocus>

                                          @error('amount_requested')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1">
                                      <label for="reason" class="col-md-3 col-form-label text-md-right">{{ __('Reason') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                        <textarea id="reason" class="form-control @error('reason') is-invalid @enderror" name="reason" value="{{ old('reason') }}" placeholder="Refund Request explaining Your request and Specify Ticket" rows="4" required readonly autocomplete="reason"></textarea>
                                          @error('reason')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1">
                                      <label for="amount_refunded" class="col-md-3 col-form-label text-md-right">{{ __('Amount Refund') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="amount_refunded" type="text" class="form-control @error('amount_refunded') is-invalid @enderror" name="amount_refunded" value="{{ old('amount_refunded') }}" placeholder="Amount Refund" required autocomplete="amount_refunded" autofocus>

                                          @error('amount_refunded')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1">
                                      <label for="refund_comments" class="col-md-3 col-form-label text-md-right">{{ __('Comments') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                        <textarea id="refund_comments" class="form-control @error('refund_comments') is-invalid @enderror" name="refund_comments" value="{{ old('refund_comments') }}" placeholder="Your Response Comments" rows="4" required autocomplete="refund_comments"></textarea>
                                          @error('refund_comments')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1 mb-0">
                                      <div class="col-md-9  offset-md-3">
                                          <button type="submit" class="btn btn-primary" id="savenewrefundrequest">
                                              {{ __('Submit New Refund Request') }}
                                          </button>
                                      </div>
                                  </div>

                                  <div class="form-group row m-1 mb-0 text-center">
                                      <div class="col-md-12 bg-light justify-content-center newrefundrequestresult" >
                                          
                                      </div>
                                  </div>

                              </form>
                          </div>
                      <!-- end -->

                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal refund requests -->

          </div>
        </section>
      </div>

      </div>   
</div>

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<!-- <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- input mask -->
<!-- <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script> -->
<!-- Toastr -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<!-- ChartJS -->
<!-- <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script> -->
<!-- JQVMap -->
<!-- <script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script> -->
<!-- <script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> -->
<!-- jQuery Knob Chart -->
<!-- <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script> -->
<!-- daterangepicker -->
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment-timezone-with-data-2012-2022.min.js') }}"></script>
<!-- <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script> -->
<!-- <script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script> -->
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>


<!-- overlayScrollbars -->
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- App App -->
<script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
<!-- App for demo purposes -->
<!-- <script src="{{ asset('assets/dist/js/demo.js') }}"></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.min.js"></script> -->
<!-- DataTables  & Plugins -->
  <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/dropzone/dropzone.js') }}"></script>
  @stack('scripts')

  <script type="text/javascript">
    $(function () {
      load_notifications();
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      var thistimezone=moment.tz.guess();
      $('#timezone').val(thistimezone);
      loadScreens();
      caclDate();
      getselectedseatsforupdate();
      getMyMovieRequests();
      getMyRefundRequests();
      loadMovies();

      Dropzone.options.dropzoneForm={
        autoProcessQueue:true,
        maxFilesize: 3072, // 3GB
        chunkSize: 100000000, // 10MB
        addRemoveLinks: true,
        timeout: 0,
        acceptedFiles: "video/*",
        success: function(file, response)
        {
          //reload page
          alert('Thriller Uploaded');
          return true;
        },
        error: function(file, response)
        {
          //error uploading
          alert('Thriller Not Uploaded');
          return false;
        }
      };

      Dropzone.options.dropzoneFormCover={
        autoProcessQueue:true,
        maxFilesize: 10, // 10MB
        chunkSize: 100000000, // 10MB
        addRemoveLinks: true,
        timeout: 5000000,
        acceptedFiles: "image/*",
        success: function(file, response)
        {
          //reload page
          alert('Cover Uploaded');
          return true;
        },
        error: function(file, response)
        {
          //error uploading
          alert('Cover Not Uploaded');
          return false;
        }
      };
    });

        var movie_id ='';
        var movie_name = '';
        var screen_name = '';
        var screen_id = '';
        var upcoming = '';
        var seat_id = '';
        var seat_name = '';
        var seat_section = '';
        var ticket_amount = '';
        var start_date = '';
        var end_date = '';
        var ticket_id = '';
        var ticket = '';
        var status = '';
        var wallet = ''; 
        var sold_on ='';
        var used_on ='';

    function load_notifications(){
      $.ajax({
          url:"/client/notifications/unread",
            method:"GET",
            success:function(data){
              var alldata=JSON.parse(data);
              $('.unreadcount').html(alldata.length);
              $('#allunreadnotifications').html('');
              var notifications=document.getElementById('allunreadnotifications');
              for (var i = 0; i < alldata.length; i++) {
               if (i==9) {
                break;
               }
                var sno=i+1;
                var unread="";
                var link='/admin/notifications/'+alldata[i].id;   
                
                if (alldata[i].data['typeSent']=="New Client") {
                  unread='<div class="dropdown-divider"></div><a href="'+link+'" class="dropdown-item text-olive text-xs">'+sno+'. '+alldata[i].data['typeSent']+'<span class="float-right text-muted text-sm" id="'+alldata[i].id+'">'+getTimeDiff(alldata[i].id,alldata[i].created_at)+'</span> </a>'; 
                }
                else if (alldata[i].data['typeSent']=="Movie Request") {
                  unread='<div class="dropdown-divider"></div><a href="'+link+'" class="dropdown-item text-olive text-xs">'+sno+'. '+alldata[i].data['typeSent']+'<span class="float-right text-muted text-sm" id="'+alldata[i].id+'">'+getTimeDiff(alldata[i].id,alldata[i].created_at)+'</span> </a>'; 
                }
                else if (alldata[i].data['typeSent']=="Movie Request Response") {
                  unread='<div class="dropdown-divider"></div><a href="'+link+'" class="dropdown-item text-olive text-xs">'+sno+'. '+alldata[i].data['typeSent']+'<span class="float-right text-muted text-sm" id="'+alldata[i].id+'">'+getTimeDiff(alldata[i].id,alldata[i].created_at)+'</span> </a>'; 
                }
                else if (alldata[i].data['typeSent']=="Refund Request") {
                  unread='<div class="dropdown-divider"></div><a href="'+link+'" class="dropdown-item text-olive text-xs">'+sno+'. '+alldata[i].data['typeSent']+'<span class="float-right text-muted text-sm" id="'+alldata[i].id+'">'+getTimeDiff(alldata[i].id,alldata[i].created_at)+'</span> </a>'; 
                }
                else if (alldata[i].data['typeSent']=="Refund Request Response") {
                  unread='<div class="dropdown-divider"></div><a href="'+link+'" class="dropdown-item text-olive text-xs">'+sno+'. '+alldata[i].data['typeSent']+'<span class="float-right text-muted text-sm" id="'+alldata[i].id+'">'+getTimeDiff(alldata[i].id,alldata[i].created_at)+'</span> </a>'; 
                }
                else{
                  unread='<div class="dropdown-divider"></div><a href="'+link+'" class="dropdown-item text-olive text-xs">'+sno+'. '+alldata[i].data['typeSent']+'(Movie:'+alldata[i].data['movie_name']+')<span class="float-right text-muted text-sm" id="'+alldata[i].id+'">'+getTimeDiff(alldata[i].id,alldata[i].created_at)+'</span> </a>'; 
                }
                  notifications.innerHTML=notifications.innerHTML+unread;
              }
              if (alldata.length==0) {
                  $('#allunreadnotifications').html('You have no notification');
              }
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('.unreadcount').html('0');
              $('#allunreadnotifications').html('Error: '+errorMessage);
          }
      });
    }

    function loadAllPayments(){
      $('#allpayments').html('<h4 class="mx-auto"> Loading All Payments. <br> Please Wait... <br>'+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></h4>');
        $.ajax({
            url:"/admin/myaacount/payments",
            method:"GET",
            success:function(data){
              $('#allpayments').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#allpayments').html(errorMessage);
          }
        });
    }

    function loadAllWallets(){
      $('#allmywallets').html('<h4 class="mx-auto"> Loading All Payments. <br> Please Wait... <br>'+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></h4>');
        $.ajax({
            url:"/admin/myaacount/wallets",
            method:"GET",
            success:function(data){
              $('#allmywallets').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#allmywallets').html(errorMessage);
          }
        });
    }

    function loadAllMovies(){
        $('#allmovies').html('<h4 class="mx-auto"> Loading All Movies. <br> Please Wait... <br>'+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></h4>');
        $.ajax({
            url:"/admin/movies/load/all",
            method:"GET",
            success:function(data){
              $('#allmovies').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#allmovies').html(errorMessage);
          }
        });
    }

    function loadUpcomingMovies(){
        $('#upcomingmovie').html('<h4 class="mx-auto"> Loading Upcoming Movies. <br> Please Wait... <br>'+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></h4>');
        $.ajax({
            url:"/admin/movies/load/upcoming",
            method:"GET",
            success:function(data){
              $('#upcomingmovie').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#upcomingmovie').html(errorMessage);
          }
        });
    }

    function loadAiringMovies(){
        $('#onairmovie').html('<h4 class="mx-auto"> Loading Live or to be Aired Movies. <br> Please Wait... <br>'+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></h4>');
        $.ajax({
            url:"/admin/movies/load/onair",
            method:"GET",
            success:function(data){
              $('#onairmovie').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#onairmovie').html(errorMessage);
          }
        });
    }

    function loadTicketSalesPerMovies(){
        $('#tiketsalesperAiring').html('<h4 class="mx-auto"> Loading Ticket Sales per Aired Movies. <br> Please Wait... <br>'+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></h4>');
        $.ajax({
            url:"/admin/movies/load/ticketsales",
            method:"GET",
            success:function(data){
              $('#tiketsalesperAiring').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#tiketsalesperAiring').html(errorMessage);
          }
        });
    }

    function load_seat_details(screen,upcoming,title){
      $('#modalscreenseat-body').html("Loading Seats. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      $.ajax({
            url:"/admin/seats/get/"+screen+"/"+upcoming,
            method:"GET",
            success:function(data){
              $('#modalscreenseat-body').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#modalscreenseat-title').html('View Seats Error for '+title);
              $('#modalscreenseat-body').html(errorMessage);
          }
        });
    }

    function loadHolderStatus(seat_id,upcoming,ticket_id,status){
      $('#successholder_status').html("Loading Status. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      $.ajax({
            url:"/admin/seats/get/status/"+seat_id+"/"+upcoming+"/"+ticket_id+"/"+status,
            method:"GET",
            success:function(data){
              $('#successholder_status').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#successholder_status').html(errorMessage);
          }
        });
    }

    function getMyMovieRequests(){
      $('.myrequests').html("Loading Movie Requests. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        
      $.ajax({
        url:"/admin/movie/requests/all",
        method:"GET",
        success: function(data)
        {
          $('.myrequests').html(data);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + xhr.statusText
          if (errorMessage=="0: error") {
              errorMessage="No Connection" 
          }
          $('.myrequests').html(errorMessage+"<br>Could Not Load My Movie Requests Data");
        }
      });
    }

    function getMyRefundRequests(){
      $('.myrequestedrefunds').html("Loading Refund Requests. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        
      $.ajax({
        url:"/admin/refunds/all",
        method:"GET",
        success: function(data)
        {
          $('.myrequestedrefunds').html(data);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + xhr.statusText
          if (errorMessage=="0: error") {
              errorMessage="No Connection" 
          }
          $('.myrequestedrefunds').html(errorMessage+"<br>Could Not Load My Refund Requests Data");
        }
      });
    }

    $(document).on('click', '.getmovieseat', function(e){
      e.preventDefault();
      var id = $(this).data("id0");
      var title = $(this).data("id1");
      var film = $(this).data("id2");
      var director = $(this).data("id3");
      var description = $(this).data("id4");
      var thriller = $(this).data("id6");
      var upcoming = $(this).data("id7");
      var screen = $(this).data("id8");
      $('.erroradding').html('');
      $('#modalscreenseat-title').html('View Seats for '+title);
      load_seat_details(screen,upcoming,title);
      $('#modalscreenseat').modal('show');
      $(document).on('click', '.closebookedticketcheck', function(e){
            load_seat_details(screen,upcoming,title);
        });
    }); 

    function caclDate(){
      var startreleasedated=$('#startreleasedated').val();
      var startreleasetimed=$('#startreleasetimed').val();
      var endreleasetimed=$('#endreleasetimed').val();
      var endreleasedated=$('#endreleasedated').val();
      var release_on_date_start=startreleasedated+" "+startreleasetimed;
      var release_on_date_end=endreleasedated+" "+endreleasetimed;
      $('#release_on').val(release_on_date_start);
      $('#release_off').val(release_on_date_end);
      $('#release_on_info').val('From: '+release_on_date_start+' To: '+release_on_date_end);
    }

    $(document).on('change','#startreleasedated', function(){ 
      caclDate();
    });
    $(document).on('change','#startreleasetimed', function(){ 
      caclDate();
    });

    $(document).on('change','#endreleasedated', function(){ 
      caclDate();
    });
    $(document).on('change','#endreleasetimed', function(){ 
      caclDate();
    });

  function loadScreens(){
    $.ajax({
      url:"/admin/screens/load",
      method:"GET",
      success:function(data){
        var alldata=JSON.parse(data);

        var screenair=document.getElementById('screenair');
        screenair.innerHTML='<option value="">Choose Screen</option>';
        for (var i = 0; i < alldata.length; i++) {
            var sno=i+1;
            screenair.innerHTML=screenair.innerHTML+'<option value="'+alldata[i].id+'">'+sno+'. <span class="text-xs">'+alldata[i].screen+'( '+alldata[i].capacity+')</span></option>';
        }
        
        if (alldata.length==0) {
            var noscreenair='<option value="">No Screen Found</option>';
            $('#screenair').html(noscreenair);
        }
        
      },
      error: function(xhr, status, error){
        var errorMessage = xhr.status + ': ' + xhr.statusText
        if (errorMessage=="0: error") {
            errorMessage="No Connection" 
        }
        var screenair='<option value="">'+errorMessage+'</option>';
        $('#screenair').html(screenair);
        
      }
    });
  }

  function loadMovies(){
    $.ajax({
      url:"/admin/movies/load",
      method:"GET",
      success:function(data){
        var alldata=JSON.parse(data);
        var requestmovieid=document.getElementById('requestmovieid');
        requestmovieid.innerHTML='<option value="">Movie Found</option>';
        for (var i = 0; i < alldata.length; i++) {
            var sno=i+1;
            requestmovieid.innerHTML=requestmovieid.innerHTML+'<option value="'+alldata[i].id+'">'+sno+'. <span class="text-xs">'+alldata[i].title+'( '+alldata[i].status+')</span></option>';
        }
        
        if (alldata.length==0) {
            var norequestmovieid='<option value="">No Movie Found</option>';
            $('#requestmovieid').html(norequestmovieid);
        }
        
      },
      error: function(xhr, status, error){
        var errorMessage = xhr.status + ': ' + xhr.statusText
        if (errorMessage=="0: error") {
            errorMessage="No Connection" 
        }
        var screenair='<option value="">'+errorMessage+'</option>';
        $('#screenair').html(screenair);
        
      }
    });
  }

  $(document).on('click', '.viewthriller', function(e){
        e.preventDefault();
        $('#thrillerpage-body').html("Loading Thriller. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        var id = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        var thriller = $(this).data("id6");
        $('.erroradding').html('');
        $('#thrillerpage-title').html('Thriller for '+title);
        $('#thrillerpage-body').html('<video width="100%" controls> <source src="{{ asset('assets/movies/')}}/'+id+'_'+thriller+'" type="video/mp4"> Your browser does not support the video tag. </video>');
        $('#thrillerpage').modal('show');
    }); 

    $(document).on('click', '.addnewmovie', function(e){
        e.preventDefault();
          $('#genrediv').show();
          $('#movieid').val('');
          $('#title').val('');
          $('#film').val('');
          $('#director').val('');
          $('#description').val('');
          $('.erroradding').html('');
          $('#submitbtn').html('Submit New Movie Details');
          $('#modalmovie-title').html('Add New Movie');
          $('#modalmovie').modal('show');
    }); 

    $(document).on('click', '.addmoviethriller', function(e){
        e.preventDefault();
        var id = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        $('.erroradding').html('');
        $('#genrediv').hide();
        $('#movieidthriller').val(id);
        $('#title').val(title);
        $('#film').val(film);
        $('#director').val(director);
        $('#description').val(description);
        $('#submitbtn').html('Submit Thriller Details');
        $('#modalthriller-title').html('Upload Thriller for Movie '+title);
        $('#modalthriller').modal('show');

        $(document).on('click', '.closeaddmoviethriller', function(e){
            window.location.href="";
        }); 
    }); 

    $(document).on('click', '.addmoviecover', function(e){
        e.preventDefault();
        var id = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        $('.erroradding').html('');
        $('#genrediv').hide();
        $('#movieidcover').val(id);
        $('#title').val(title);
        $('#film').val(film);
        $('#director').val(director);
        $('#description').val(description);
        $('#submitbtn').html('Submit Cover Details');
        $('#modalcover-title').html('Upload Cover for Movie '+title);
        $('#modalcover').modal('show');

        $(document).on('click', '.closeaddmoviethriller', function(e){
            window.location.href="";
        }); 
    }); 

    $(document).on('click', '.updatemoviecover', function(e){
        e.preventDefault();
        var id = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        $('.erroradding').html('');
        $('#genrediv').hide();
        $('#movieidcover').val(id);
        $('#title').val(title);
        $('#film').val(film);
        $('#director').val(director);
        $('#description').val(description);
        $('#submitbtn').html('Upload Cover Details');
        $('#modalcover-title').html('Update Cover for Movie: '+title);
        $('#modalcover').modal('show');

        $(document).on('click', '.closeaddmoviethriller', function(e){
            window.location.href="";
        }); 
    }); 

    $(document).on('click', '.updatemovie', function(e){
        e.preventDefault();
        var id = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        $('.erroradding').html('');
        $('#genrediv').hide();
        $('#movieid').val(id);
        $('#title').val(title);
        $('#film').val(film);
        $('#director').val(director);
        $('#description').val(description);
        $('#submitbtn').html('Submit Update Details');
        $('#modalmovie-title').html('Update Movie '+title);
        $('#modalmovie').modal('show');
    }); 

    $(document).on('click', '.deletemovie', function(e){
        e.preventDefault();
        var id = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        if (confirm("Do You want to delete Movie: "+title+" ?")) {
          $.ajax({
            url:"/admin/movies/delete/"+id,
            method:"GET",
            success:function(data){
              alert(data);
              window.location.href="";
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              alert('No Movie Deleted :Error:: ' + errorMessage);
          }
        });
      }
    }); 

    $(document).on('click', '.addmoviereleasedate', function(e){
        e.preventDefault();
        var id = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        $('.erroradding').html('');
        $('#releasedatemovieid').val(id);

        $('#upcomingmovieid').val('');
        $('#screenair').val('');
        $('#release_on').val('');
        $('#release_off').val('');
        $('#startreleasedated').val('');
        $('#endreleasedated').val('');
        $('#startreleasetimed').val('');
        $('#endreleasetimed').val('');
        $('#release_on_info').val('');
        $('#VVIP').val('');
        $('#VIP').val('');
        $('#Regular').val('');
        $('#Terraces').val('');

        $('#releasedatesubmitbtn').html('Submit Release Date Details');
        $('#modalreleaseon-title').html('Release Date for Movie '+title);
        $('#modalreleaseon').modal('show');
    }); 

    $(document).on('click', '.updatemoviereleasedate', function(e){
        e.preventDefault();
        var id = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        var upcoming= $(this).data("id5");
        $('.erroradding').html('');
        $('#releasedatemovieid').val(id);
        $('#upcomingmovieid').val(upcoming);
        $.ajax({
          url:"/admin/upcoming/load/"+upcoming,
          method:"GET",
          success:function(data){
            var alldata=JSON.parse(data);
            for (var i = 0; i < alldata.length; i++) {
                $('#screenair').val(alldata[i].screen);
                $('#release_on').val(alldata[i].release_on);
                $('#release_off').val(alldata[i].release_off);
                $('#release_on_info').val('From: '+alldata[i].release_on+' To: '+alldata[i].release_off+"(UTC)");
                $('#VVIP').val(alldata[i].VVIP);
                $('#VIP').val(alldata[i].VIP);
                $('#Regular').val(alldata[i].Regular);
                $('#Terraces').val(alldata[i].Terraces);
            }
            if (alldata.length==0) {
                alert('No Upcoming Details Found for this Movie');
            }
            else{
                $('#releasedatesubmitbtn').html('Submit Changes for Release Date');
                $('#modalreleaseon-title').html('Release Date Changes for Movie '+title);
                $('#modalreleaseon').modal('show');
            }
            
          },
          error: function(xhr, status, error){
            var errorMessage = xhr.status + ': ' + xhr.statusText
            if (errorMessage=="0: error") {
                errorMessage="No Connection" 
            }
            alert('No Upcoming Details Found for this Movie :Error:: ' + errorMessage);
        }
      });
        
    }); 

    $(document).on('click', '.updatemoviestream', function(e){
        e.preventDefault();
        var upcoming = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        var id= $(this).data("id5");
        var stream= $(this).data("id6");
        $('.erroradding').html('');
        $('#releasedatemoviestreamid').val(id);
        $('#upcomingmoviestreamid').val(upcoming);
        $('#stream').val(stream);
        $('#moviestreamsubmitbtn').html('Submit Movie Stream Link');
        $('#modalmoviestream-title').html('Movie Stream Link::  '+title);
        $('#modalmoviestream').modal('show');
    }); 

    $(document).on('click', '.addmoviestream', function(e){
        e.preventDefault();
        var upcoming = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        var id= $(this).data("id5");
        $('.erroradding').html('');
        $('#releasedatemoviestreamid').val(id);
        $('#upcomingmoviestreamid').val(upcoming);
        $('#moviestreamsubmitbtn').html('Submit Movie Stream Link');
        $('#modalmoviestream-title').html('Movie Stream Link::  '+title);
        $('#modalmoviestream').modal('show');
    }); 

    $(document).on('click', '.addscreen', function(e){
        e.preventDefault();
          $('#screenmovieid').val('');
          $('#screen').val('');
          $('#rowsleft').val('');
          $('#rowscenter').val('');
          $('#rowsright').val('');
          $('#capacity').val('');
          $('.erroradding').html('');
          $('#screensubmitbtn').html('Submit New Screen Details');
          $('#modalscreen-title').html('Add New Screen');
          $('#modalscreen').modal('show');
    }); 

    $(document).on('click', '.updatescreen', function(e){
        e.preventDefault();
        var id = $(this).data("id0");
        var screen = $(this).data("id1");
        var rowsleft = $(this).data("id2");
        var rowscenter = $(this).data("id3");
        var rowsright = $(this).data("id5");
        var capacity = $(this).data("id4");
        $('.erroradding').html('');
        $('#screenmovieid').val(id);
        $('#screen').val(screen);
        $('#rowsleft').val(rowsleft);
        $('#rowscenter').val(rowscenter);
        $('#rowsright').val(rowsright);
        $('#capacity').val(capacity);
        $('#screensubmitbtn').html('Submit Screen Update Details');
        $('#modalscreen-title').html('Update Screen '+screen);
        $('#modalscreen').modal('show');
    }); 


    $(document).on('click', '.seatsscreen', function(e){
        e.preventDefault();
        $('#modalscreenseat-body').html("Loading Seats. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        var id = $(this).data("id0");
        var screen = $(this).data("id1");
        var rowsleft = $(this).data("id2");
        var rowscenter = $(this).data("id3");
        var rowsright = $(this).data("id5");
        var capacity = $(this).data("id4");
        $('.erroradding').html('');
        $('#screenid').val(id);
        $('#modalscreenseat-title').html('View Seats for '+screen);
        $.ajax({
            url:"/admin/seats/get/"+id,
            method:"GET",
            success:function(data){
              $('#modalscreenseat-body').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#modalscreenseat-title').html('View Seats Error for '+screen);
              $('#modalscreenseat-body').html(errorMessage);
          }
        });

        $('#modalscreenseat').modal('show');
    }); 

    $(document).on('click', '.moviesscreen', function(e){
        e.preventDefault();
        $('#modalscreenusage-body').html("Loading Seats. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        var id = $(this).data("id0");
        var screen = $(this).data("id1");
        var rowsleft = $(this).data("id2");
        var rowscenter = $(this).data("id3");
        var rowsright = $(this).data("id5");
        var capacity = $(this).data("id4");
        $('.erroradding').html('');
        $('#modalscreenusage-title').html('View Movies Aired IN: '+screen);
        $.ajax({
            url:"/admin/screens/usage/"+id,
            method:"GET",
            success:function(data){
              $('#modalscreenusage-body').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#modalscreenusage-title').html('View Seats Error for '+screen);
              $('#modalscreenusage-body').html(errorMessage);
          }
        });

        $('#modalscreenusage').modal('show');
    }); 

    $(document).on('click', '.seatsscreensection', function(e){
        e.preventDefault();
        $('#modalscreensection-body').html("Loading Seats. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        $('#screenidmovieid').val('');
        var id = $(this).data("id0");
        var screen = $(this).data("id1");
        var rowsleft = $(this).data("id2");
        var rowscenter = $(this).data("id3");
        var rowsright = $(this).data("id5");
        var capacity = $(this).data("id4");
        $('.erroradding').html('');
        $('#screenidmovieid').val(id);
        $('#modalscreensection-title').html('View Seats for '+screen);
        $.ajax({
            url:"/admin/seats/section/"+id,
            method:"GET",
            success:function(data){
              $('#modalscreensection-body').html(data);
              // $("#example1").DataTable().reset();
              $("#example1").DataTable({
                "responsive": true, "lengthChange": true, "autoWidth": false,"ordering":false
              });
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#modalscreensection-title').html('View Seats Error for '+screen);
              $('#modalscreensection-body').html(errorMessage);
          }
        });

        $('#modalscreensection').modal('show');
        $(document).on('click', '.closeseatsscreensection', function(e){
            window.location.href="";
        });
    }); 

    $(document).on('click', '.bookedseatdetails', function(e){
        e.preventDefault();
        $('#modalbookedseatdetails-body').html("Loading Tickets. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        var id = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        var thriller = $(this).data("id6");
        var upcoming = $(this).data("id7");
        var screen_id = $(this).data("id8");
        var screen = $(this).data("id9");
        $('#modalbookedseatdetails-title').html('View Tickets for Movie: '+title+' , Screen: '+screen);
        $.ajax({
            url:"/admin/seats/tickets/"+upcoming,
            method:"GET",
            success:function(data){
              $('#modalbookedseatdetails-body').html(data);
              // table =$("#example2").DataTable().destroy();
                $("#example2").DataTable({
                  "responsive": true, "lengthChange": true, "autoWidth": false,"ordering":false
                });
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#modalbookedseatdetails-title').html('View Seats Error for '+screen);
              $('#modalbookedseatdetails-body').html(errorMessage);
          }
        });

        $('#modalbookedseatdetails').modal('show');
    }); 

    $(document).on('click', '.bookmovieseat', function(e){
        e.preventDefault();
        $('#modalseats-body').html("Loading Selected Seat. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        movie_id = $(this).data("id0");
        movie_name = $(this).data("id1");
        screen_name = $(this).data("id2");
        screen_id = $(this).data("id3");
        upcoming = $(this).data("id4");
        seat_id = $(this).data("id5");
        seat_name = $(this).data("id6");
        seat_section = $(this).data("id7");
        ticket_amount = $(this).data("id8");
        start_date = $(this).data("id9");
        end_date = $(this).data("id10");
        wallet = $(this).data("id11");
        $('#movie_id').val(movie_id);
        $('#movie_name').val('Movie : '+movie_name);
        $('#screen_name').val('Screen: '+screen_name);
        $('#seat_section').val('Section: '+seat_section);
        $('#screen_id').val(screen_id);
        $('#upcoming').val(upcoming);
        $('#movie_id').val(movie_id);
        $('#seat_name').val('Seat Name:'+seat_name);
        $('#ticket_amount').val('Ticket Amount:'+ticket_amount);
        $('#start_date').val('Start Date:'+start_date);
        $('#end_date').val('End Date:'+end_date);
        $('#total_amount').val(ticket_amount);
        $('#wallet_balance').val(wallet);
        $('#modalseats-title').html(movie_name+ ' Pay for Seat '+seat_name+'('+seat_section+')');
        $('#modalseats').modal('show');
    }); 

    $(document).on('click', '.reservedticket', function(e){
        e.preventDefault();
        $('#checkinstatus').html("");
        $('#modalsuccessticket-body').html("Loading Selected Ticket. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        movie_id = $(this).data("id0");
        movie_name = $(this).data("id1");
        screen_name = $(this).data("id2");
        screen_id = $(this).data("id3");
        upcoming = $(this).data("id4");
        seat_id = $(this).data("id5");
        seat_name = $(this).data("id6");
        seat_section = $(this).data("id7");
        ticket_amount = $(this).data("id8");
        start_date = $(this).data("id9");
        end_date = $(this).data("id10");
        ticket_id = $(this).data("id11");
        ticket = $(this).data("id12");
        status = $(this).data("id13");
        wallet = $(this).data("id14");
        sold_on = $(this).data("id15");
        used_on = $(this).data("id16");
        holder_names = $(this).data("id17");
        holder_phone = $(this).data("id18");

        $('#successmovie_id').val(movie_id);
        $('#successmovie_name').val('Movie : '+movie_name);
        $('#successscreen_name').val('Screen: '+screen_name);
        $('#successseat_section').val('Section: '+seat_section);
        $('#successscreen_id').val(screen_id);
        $('#successupcoming').val(upcoming);
        $('#successmovie_id').val(movie_id);
        $('#successseat_name').val('Seat Name:'+seat_name);
        $('#successticket_amount').val('Ticket Amount:'+ticket_amount);
        $('#successstart_date').val('Start Date:'+start_date);
        $('#successend_date').val('End Date:'+end_date);
        $('#successtotal_amount').val('Total Amount: '+ticket_amount);
        $('#successstatus').val('Status : '+status);
        $('#successwallet_balance').val('Wallet :'+wallet);
        $('#successticket').val('Ticket : '+ticket);
        $('#successaccountno').val('Account No: '+ticket_id);
        $('#successsold_on').val('Placed On: '+sold_on);
        $('#successused_on').val('Used On: '+used_on);
        $('#successnames').val('Name: '+holder_names);
        $('#successyour_number').val('Phone: '+holder_phone);
        loadHolderStatus(seat_id,upcoming,ticket_id,status);

        $('#modalsuccessticket-title').html(movie_name+ ' Reserved or Used Ticket '+seat_name+'('+seat_section+')');
        $('#modalsuccessticket').modal('show');

        $(document).on('click', '.closebookedticketcheck', function(e){
            load_seat_details(screen_id,upcoming,movie_name);
        });
    }); 

    $(document).on('click', '.acceptcheckinclient', function(e){
      e.preventDefault();
        ticket_id = $(this).data("id1");
        upcoming = $(this).data("id2");
        seat_id = $(this).data("id3");
        $('#checkinstatus').html("");
        if (confirm("Do You want to Accept this Check in for this Movie ?")) {
          $('#checkinstatus').html("Checking In. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
          $('#checkiinnow').hide();
            $.ajax({
              headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
                },
              type:'POST',
              url:'/admin/movie/ticket/checkin',
              data:{ticket_id:ticket_id,upcoming:upcoming,seat_id:seat_id},
              success: function(data)
              {
                $('#checkinstatus').html(data);
              },
              error: function(xhr, status, error){
                var errorMessage = xhr.status + ': ' + xhr.statusText
                if (errorMessage=="0: error") {
                    errorMessage="No Connection" 
                }
                $('#checkinstatus').html("Error: "+errorMessage);
                $('#checkiinnow').show();
                $('#checkiinnow').html("Try Again");
              }
            });
          }
     
    });

    $(document).on('click', '.requestedrefund', function(e){
        e.preventDefault();
        $('#amount_refunded').val('');
        $('#refund_comments').val('');
        $('.newrefundrequestresult').html("");
        var refund_id = $(this).data("id0");
        var amount_requested = $(this).data("id1");
        var reason = $(this).data("id2");
        var amount_refunded = $(this).data("id3");
        var comments = $(this).data("id4");
        var status = $(this).data("id5");
        var sent_at = $(this).data("id6");
        var resolved = $(this).data("id7");
        $('#reason').val(reason);
        $('#amount_requested').val(amount_requested);
        $('#refund_id').val(refund_id);
        $('#savenewrefundrequest').show();
        $('#savenewrefundrequest').html("Submit Refund Request Response");
        $('#modalnewrefundrequest-title').html('Respond to Refund Request');
        $('#modalnewrefundrequest').modal('show');
    }); 

    $(document).on('click', '#savenewrefundrequest', function(e){
      e.preventDefault();
        var refund_id=$('#refund_id').val();
        var amount_refunded=$('#amount_refunded').val();
        var refund_comments=$('#refund_comments').val();
        $('.newrefundrequestresult').html("");
        if(refund_comments==''){
          alert('Response Comment Must be Filled');
        }
        else{
          if (confirm("Do You want to Respond to this Refund Request ?")) {
            $('.newrefundrequestresult').html("Responding to Request. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
            $('#savenewrefundrequest').hide();
              $.ajax({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
                  },
                type:'POST',
                url:'/admin/refund/requests/response',
                data:{refund_id:refund_id,amount_refunded:amount_refunded,refund_comments:refund_comments},
                success: function(data)
                {
                  getMyRefundRequests();
                  $('.newrefundrequestresult').html(data);
                  $('#amount_refunded').val('');
                  $('#refund_comments').val('');
                },
                error: function(xhr, status, error){
                  var errorMessage = xhr.status + ': ' + xhr.statusText
                  if (errorMessage=="0: error") {
                      errorMessage="No Connection" 
                  }
                  $('.newrefundrequestresult').html("Error: "+errorMessage);
                  $('#savenewrefundrequest').show();
                  $('#savenewrefundrequest').html("Try Again");
                }
              });
          }
        }
    });

    $(document).on('click', '.requestedmovie', function(e){
        e.preventDefault();
        var request_id = $(this).data("id0");
        var movie_requested = $(this).data("id1");
        var movie = $(this).data("id2");
        var request = $(this).data("id3");
        var comments = $(this).data("id4");
        var status = $(this).data("id5");
        var sent_at = $(this).data("id6");

        $('#movie_title').val(movie_requested);
        $('#movie_request').val(request);
        $('#requestmovieid').val(movie);
        $('#request_id').val(request_id);
        $('#modalnewrequest-title').html('View Movie Request: '+movie_requested);
        $('#savenewrequest').show();
        $('#savenewrequest').html("Submit Your Response");
        $('#modalnewrequest').modal('show');
    }); 
    
    $(document).on('click', '#savenewrequest', function(e){
      e.preventDefault();
        var request_comments=$('#request_comments').val();
        var requestmovieid=$('#requestmovieid').val();
        var request_id=$('#request_id').val();
        $('.newrequestresult').html("");
        if (confirm("Do You want to Respond to this Movie Request ?")) {
          $('.newrequestresult').html("Responding to Request. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
          $('#savenewrequest').hide();
            $.ajax({
              headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
                },
              type:'POST',
              url:'/admin/movie/requests/response',
              data:{request_id:request_id,requestmovieid:requestmovieid,request_comments:request_comments},
              success: function(data)
              {
                getMyMovieRequests();
                $('.newrequestresult').html(data);
                $('#requestmovieid').val('');
                $('#request_comments').val('');
              },
              error: function(xhr, status, error){
                var errorMessage = xhr.status + ': ' + xhr.statusText
                if (errorMessage=="0: error") {
                    errorMessage="No Connection" 
                }
                $('.newrequestresult').html("Error: "+errorMessage);
                $('#savenewrequest').show();
                $('#savenewrequest').html("Try Again");
              }
            });
          }
    });

    $(document).on('click','.seatvaluesdiv',(function(e){
        var seatids=$(this).data("id1");
        var thisselseats=document.getElementById(seatids);
        if (thisselseats.checked===true) {
            this.style.backgroundColor='grey';
        }
        else{
            this.style.backgroundColor='#FFFFFF';
        }
        getselectedseatsforupdate();
    }));

    function getselectedseatsforupdate(){

        var selectedseats=0,allselected=0;
      
        $('.selectedseatforupdate').each(function(){
            allselected=allselected+1;
            if($(this).is(":checked")){
              selectedseats=selectedseats+1;
            }
        })
        $('#selectedseatforupdate').html(selectedseats+'/'+allselected);
    }
    
    $(document).on('click', '.closebookedtickets', function(e){
        window.location.href="";
    });

    function getTimeDiff(id,time){
      $.ajax({
        url:"/clients/notifications/diff/"+time,
        success:function(data)
        {
          $("#"+id).html(data);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + xhr.statusText
          if (errorMessage=="0: error") {
              errorMessage="No Connection" 
          }
          return errorMessage;
        }
      });
    }
  </script>
</body>
</html>







