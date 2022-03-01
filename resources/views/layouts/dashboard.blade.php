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
    <link href="//vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
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
      <nav class="main-header navbar navbar-expand navbar-primary fixed-top bg-success sidebar-collapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="/client/home" class="nav-link">Home</a>
          </li>
        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

          <!-- Stream Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fa fa-microphone fa-2x text-orange"></i>
              <span class="badge badge-light text-lime navbar-badge unreadcountstream">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right bg-light m-0 p-0" style="width: 400px;">
              <span class="dropdown-item dropdown-header">Streams <span class="badge badge-success text-dark float-right p-1 text-sm"><span class="unreadcountstream">0</span> New</span></span>
                <div class="allunreadstreamnotifications bg-white" id="allunreadstreamnotifications">
                
                </div>

              <div class="dropdown-divider"></div>
              
            </div>
          </li>


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
              <button class="btn btn-link btn-block btn-outline"><a href="/client/notifications" class="text-dark" >View All Notifications</a></button>
              
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

                            <a class="dropdown-item" href="{{ url('/client/my-account') }}">{{ __('My Account') }}</a>
                            <a class="dropdown-item" href="{{ url('/client/profile') }}">{{ __('Profile') }}</a>
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
              <a class="dropdown-item text-light" href="/client/my-account"><span class="text-lime text-bold">{{ Auth::user()->fname }} ({{ Auth::user()->roles }})</span></a>
                 
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
                <a href="/client/home" class="nav-link">
                  <i class="fa fa-home nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="/client/movies" class="nav-link">
                  <i class="fa fa-film nav-icon"></i>
                  <p>Movies</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/client/upcoming" class="nav-link">
                  <i class="fa fa-fire nav-icon"></i>
                  <p>Upcoming</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/client/requests" class="nav-link">
                  <i class="fa fa-bomb nav-icon"></i>
                  <p>Requests</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/client/refunds" class="nav-link">
                  <i class="fa fa-gift nav-icon"></i>
                  <p>Refunds</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/client/tickets" class="nav-link">
                  <i class="fa fa-bullseye nav-icon"></i>
                  <p>My Tickets</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/client/my-account" class="nav-link">
                  <i class="far fa-user nav-icon"></i>
                  <p>My Account</p>
                </a>
              </li>
              
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      @if(Auth::user()->roles=="Client")
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
                <div class="modal fade" id="confirm-modal">
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
                    <div class="modal-footer justify-content-center p-0 bg-secondary">
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
                <div class="modal fade" id="message-modal">
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
              <div class="modal fade" id="modalpage">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-success text-center">
                      <h4 class="modal-title text-center" id="modalpage-title">Movies Title</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalpage-body" style="padding: 10px;margin:10px;max-height: 400px;overflow-y: auto;">
                      <p>Movies Body</p>
                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal page -->
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
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal screens seats -->

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

            <!-- start modal booked ticket -->
            <div class="modal fade" id="modalunpaidticket" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-cyan text-center">
                      <h4 class="mx-auto" id="modalunpaidticket-title">Confirm Payment</h4>
                      <button type="button" class="close closeunpaidticket" data-dismiss="modal" aria-label="Close">
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
                                  <div class="col-4 p-0 m-0">
                                      <input type="hidden" name="unpaidmovie_id" id="unpaidmovie_id" class="form-control " readonly>
                                      <input type="hidden" name="unpaidscreen_id" id="unpaidscreen_id" class="form-control " readonly>
                                      <input type="hidden" name="unpaidseat_id" id="unpaidseat_id" class="form-control " readonly>
                                      <input type="hidden" name="unpaidupcoming" id="unpaidupcoming" class="form-control " readonly>
                                      <input type="text" name="unpaidmovie_name" id="unpaidmovie_name" title="Movie Title/Name" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="unpaidscreen_name" id="unpaidscreen_name" title="Screen Name" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="unpaidseat_name" id="unpaidseat_name" title="Seat Name" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="unpaidseat_section" id="unpaidseat_section" title="Section Type" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="unpaidticket_amount" id="unpaidticket_amount" title="Ticket Amount" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="unpaidstart_date" id="unpaidstart_date" title="Movie Start Time" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="unpaidend_date" id="unpaidend_date" title="Movie End Time" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="unpaidpayment_method" id="unpaidpayment_method" title="Payment Method" value="Payment Method: MPESA" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="unpaidstatus" id="unpaidstatus" title="Ticket Status" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="unpaidticket" id="unpaidticket" title="Ticket Status" class="form-control p-1 m-1" readonly>
                                  </div>
                                  <div class="col-8">
                                      <!-- stt -->
                                      <label class="col-md-12 col-form-label text-md-center">{{ __('Confirm Amount And Transaction ID for Ticket') }} <span class="text-danger"><sup>*</sup></span></label>
                                      <div class="form-group row m-1">
                                          
                                          <label for="unpaidyour_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }} <span class="text-danger"><sup>*</sup></span></label>

                                          <div class="col-md-8">
                                              <input id="unpaidyour_number" type="text" class="form-control @error('your_number') is-invalid @enderror" name="unpaidyour_number" value="254{{ Auth::user()->phone }}" readonly placeholder="Phone Number" required autocomplete="your_number" autofocus>

                                              @error('your_number')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                          </div>
                                      </div>

                                      <div class="form-group row m-1">
                                          <label for="unpaidwallet_balance" class="col-md-4 col-form-label text-md-right">{{ __('Wallet Bal') }} <span class="text-danger"><sup>*</sup></span></label>

                                          <div class="col-md-8">
                                              <input id="unpaidwallet_balance" type="text" class="form-control @error('wallet_balance') is-invalid @enderror" name="unpaidwallet_balance" readonly placeholder="Wallet Bal" required autocomplete="wallet_balance" autofocus>

                                              @error('wallet_balance')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                          </div>
                                      </div>

                                      <div class="form-group row m-1">
                                          <label for="unpaidpaybill" class="col-md-4 col-form-label text-md-right">{{ __('Paybill Number') }} <span class="text-danger"><sup>*</sup></span></label>

                                          <div class="col-md-8">
                                              <input id="unpaidpaybill" type="text" class="form-control @error('paybill') is-invalid @enderror" name="unpaidpaybill"  readonly placeholder="Paybill" value="123412" required autocomplete="paybill" autofocus>

                                              @error('paybill')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                          </div>
                                      </div>

                                      <div class="form-group row m-1">
                                          <label for="unpaidaccountno" class="col-md-4 col-form-label text-md-right">{{ __('Account Number') }} <span class="text-danger"><sup>*</sup></span></label>

                                          <div class="col-md-8">
                                              <input id="unpaidaccountno" type="text" class="form-control @error('accountno') is-invalid @enderror" name="unpaidaccountno"  readonly placeholder="Account Number" required autocomplete="accountno" autofocus>

                                              @error('accountno')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                          </div>
                                      </div>

                                      <div class="form-group row m-1">
                                          <label for="unpaidtransactionid" class="col-md-4 col-form-label text-md-right">{{ __('Transaction ID') }} <span class="text-danger"><sup>*</sup></span></label>

                                          <div class="col-md-8">
                                              <input id="unpaidtransactionid" type="text" class="form-control @error('transactionid') is-invalid @enderror" name="unpaidtransactionid" maxlength="10" minlength="10" placeholder="Transaction ID" required autocomplete="transactionid" style="text-transform: uppercase;" autofocus>

                                              @error('transactionid')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                          </div>
                                      </div>

                                      <div class="form-group row m-1">
                                          <label for="unpaidtotal_amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount to Pay') }} <span class="text-danger"><sup>*</sup></span></label>

                                          <div class="col-md-8">
                                              <input id="unpaidtotal_amount" type="text" class="form-control @error('total_amount') is-invalid @enderror" name="unpaidtotal_amount" value="{{ old('total_amount') }}" placeholder="Total Amount" required autocomplete="total_amount" autofocus>

                                              @error('total_amount')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                          </div>
                                      </div>


                                      <div class="form-group row m-1 mb-0 text-center">
                                          <div class="col-md-12 justify-content-center">
                                              <button type="button" class="btn btn-success" id="ticketpaysubmitbtn">
                                                  {{ __('Confirm Transaction') }}(MPESA)
                                              </button>
                                          </div>
                                      </div>

                                      <div class="form-group row m-1 mb-0 text-center">
                                          <div class="col-md-12 bg-light justify-content-center successholder_status" >
                                              
                                          </div>
                                      </div>

                                      <div class="form-group row m-1">
                                          <div class="col-md-12" id="paymentstatus">
                                              
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
                      <button type="button" class="btn btn-default float-sm-right closeunpaidticket" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
            <!-- end modal booked ticket -->

            <!-- start modal unpaid ticket -->
            <div class="modal fade" id="modalcanceledticket" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-cyan text-center">
                      <h4 class="mx-auto" id="modalcanceledticket-title">Unsuccessful Payment</h4>
                      <button type="button" class="close closeunpaidticket" data-dismiss="modal" aria-label="Close">
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
                                  <div class="col-12 p-0 m-0">
                                      <input type="hidden" name="canceledmovie_id" id="canceledmovie_id" class="form-control " readonly>
                                      <input type="hidden" name="canceledscreen_id" id="canceledscreen_id" class="form-control " readonly>
                                      <input type="hidden" name="canceledseat_id" id="canceledseat_id" class="form-control " readonly>
                                      <input type="hidden" name="canceledupcoming" id="canceledupcoming" class="form-control " readonly>
                                      <input type="text" name="canceledmovie_name" id="canceledmovie_name" title="Movie Title/Name" class="form-control p-1 m-1 text-center" readonly>
                                      <input type="text" name="canceledscreen_name" id="canceledscreen_name" title="Screen Name" class="form-control p-1 m-1 text-center" readonly>
                                      <input type="text" name="canceledseat_name" id="canceledseat_name" title="Seat Name" class="form-control p-1 m-1 text-center" readonly>
                                      <input type="text" name="canceledseat_section" id="canceledseat_section" title="Section Type" class="form-control p-1 m-1 text-center" readonly>
                                      <input type="text" name="canceledticket_amount" id="canceledticket_amount" title="Ticket Amount" class="form-control p-1 m-1 text-center" readonly>
                                      <input type="text" name="canceledstart_date" id="canceledstart_date" title="Movie Start Time" class="form-control p-1 m-1 text-center" readonly>
                                      <input type="text" name="canceledend_date" id="canceledend_date" title="Movie End Time" class="form-control p-1 m-1 text-center" readonly>
                                      <input type="text" name="canceledpayment_method" id="canceledpayment_method" title="Payment Method" value="Payment Method: MPESA" class="form-control p-1 m-1 text-center" readonly>
                                      <input type="text" name="canceledstatus" id="canceledstatus" title="Ticket Status" class="form-control p-1 m-1 text-center" readonly>
                                      <input type="text" name="canceledticket" id="canceledticket" title="Ticket Status" class="form-control p-1 m-1 text-center" readonly>
                                      <div class="p-1 text-center">
                                          <div class="col-md-12 bg-light justify-content-center successholder_status" >
                                              
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              
                          </form>
                      </div>
                      <!-- end -->
                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right closeunpaidticket" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
            <!-- end modal unpaid ticket -->


            <!-- start modal unpaid ticket -->
            <div class="modal fade" id="modalsuccessticket" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-cyan text-center">
                      <h4 class="mx-auto" id="modalsuccessticket-title">Reserved Seat</h4>
                      <button type="button" class="close closeunpaidticket" data-dismiss="modal" aria-label="Close">
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
                                      <input type="text" name="successyour_number" id="successyour_number" title="Phone Number"  value="254{{ Auth::user()->phone }}"class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successwallet_balance" id="successwallet_balance" title="Wallet Bal" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successpaybill" id="successpaybill" title="Paybill" value="Paybill: 123412" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successaccountno" id="successaccountno" title="Account Number" class="form-control p-1 m-1" readonly>
                                      <input type="text" name="successticket" id="successticket" title="Ticket" class="form-control p-1 m-1" readonly>

                                      <div class="form-group row m-1 mb-0 text-center">
                                          <div class="col-md-12 bg-light justify-content-center successholder_status" >
                                              
                                          </div>
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
                      <button type="button" class="btn btn-default float-sm-right closeunpaidticket" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
            <!-- end modal unpaid ticket -->


            <!-- start modal pay membership plan -->
            <div class="modal fade" id="modalmembershippackage" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-cyan text-center">
                      <h4 class="mx-auto" id="modalmembershippackage-title">Reserved Seat</h4>
                      <button type="button" class="close closeunpaidticket" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- start -->
                      <div class="card-body p-1 m-0" id="modalmembershippackage-body">
                          
                      </div>
                      <!-- end -->
                    </div>
                    <div class="modal-footer p-0 bg-secondary">
                      <button type="button" class="btn btn-default float-sm-right" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
            <!-- end modal pay membership plan -->
            
            <!-- start modal movie requests -->
              <div class="modal fade" id="modalnewrequest" role="dialog" aria-hidden="false" data-backdrop="false">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header bg-olive text-center">
                      <h4 class="mx-auto" id="modalnewrequest-title">Create New Request</h4>
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
                                  <input type="hidden" name="requestmovieid" id="requestmovieid" value="">
                                  <div class="form-group row m-1">
                                      <label for="movie_title" class="col-md-3 col-form-label text-md-right">{{ __('Movie Title') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="movie_title" type="text" class="form-control @error('movie_title') is-invalid @enderror" name="movie_title" value="{{ old('movie_title') }}" placeholder="Movie Title" required autocomplete="movie_title" autofocus>

                                          @error('movie_title')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1">
                                      <label for="movie_description" class="col-md-3 col-form-label text-md-right">{{ __('Description') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                        <textarea id="movie_description" class="form-control @error('movie_description') is-invalid @enderror" name="movie_description" value="{{ old('movie_description') }}" placeholder="Movie Description explaining Your request" rows="8" required autocomplete="movie_description"></textarea>
                                          @error('movie_description')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>

                                  <div class="form-group row m-1 mb-0">
                                      <div class="col-md-9  offset-md-3">
                                          <button type="submit" class="btn btn-primary" id="savenewrequest">
                                              {{ __('Submit New Movie Request Details') }}
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
                      <h4 class="mx-auto" id="modalnewrefundrequest-title">New Refund Request</h4>
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
                                  <input type="hidden" name="movieid" id="movieid" value="">
                                  <div class="form-group row m-1">
                                      <label for="amount_requested" class="col-md-3 col-form-label text-md-right">{{ __('Amount Requested') }} <span class="text-danger"><sup>*</sup></span></label>

                                      <div class="col-md-9">
                                          <input id="amount_requested" type="text" class="form-control @error('amount_requested') is-invalid @enderror" name="amount_requested" value="{{ old('amount_requested') }}" placeholder="Amount Requested" required autocomplete="amount_requested" autofocus>

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
                                        <textarea id="reason" class="form-control @error('reason') is-invalid @enderror" name="reason" value="{{ old('reason') }}" placeholder="Refund Request explaining Your request and Specify Ticket" rows="8" required autocomplete="reason"></textarea>
                                          @error('reason')
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
        </main>
    </div>

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- input mask -->
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment-timezone-with-data-2012-2022.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- App App -->
<script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
<!-- App for demo purposes -->
<script src="{{ asset('assets/dist/js/demo.js') }}"></script>
<script src="//vjs.zencdn.net/4.12/video.js"></script>
 @stack('scripts')
<script type="text/javascript">
  load_notifications();
  load_notificationsstreams();
  getLatestTickets();
  getMyTickets();
  getMyMovieRequests();
  getMyRefundRequests();

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
                var link='/client/notifications/'+alldata[i].id;   
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

    function load_notificationsstreams(){
      $.ajax({
          url:"/client/movies/streams/count",
            method:"GET",
            success:function(count){
              $('.unreadcountstream').html(count);
              $('#allunreadstreamnotifications').html('<span class="mx-auto"> Loading. Please Wait... '+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></span>');
              if (count==0) {
                  $('#allunreadstreamnotifications').html('<h4 class="mx-auto p-1">You have no notification</h4>');
              }
              // load all streams
              $.ajax({
                url:"/clients/movies/get-streams",
                method:"GET",
                success:function(datas)
                {
                  $('#allunreadstreamnotifications').html(datas);
                },
                error: function(xhr, status, error){
                  var errorMessage = xhr.status + ': ' + xhr.statusText
                  if (errorMessage=="0: error") {
                      errorMessage="No Connection" 
                  }
                  $('#allunreadstreamnotifications').html('<h4 class="mx-auto p-1">Error: '+errorMessage+'</h4>');
                }
              });

            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('.unreadcountstream').html('0');
              $('#allunreadstreamnotifications').html('<h4 class="mx-auto p-1">Error: '+errorMessage+'</h4>');
          }
      });
    }

    function loadMembership(){
      $('#memberships').html('<h4 class="mx-auto"> Loading Membership. <br> Please Wait... <br>'+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></h4>');
        $.ajax({
            url:"/client/myaacount/membership",
            method:"GET",
            success:function(data){
              $('#memberships').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#memberships').html(errorMessage);
          }
        });
    }
    function loadMembershipSubs(){
      $('#membershipsSubs').html('<h4 class="mx-auto"> Loading Membership Plans. <br> Please Wait... <br>'+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></h4>');
        $.ajax({
            url:"/client/myaacount/membersplans",
            method:"GET",
            success:function(data){
              $('#membershipsSubs').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#membershipsSubs').html(errorMessage);
          }
        });
    }

    function loadAllPayments(){
      $('#allpayments').html('<h4 class="mx-auto"> Loading All Payments. <br> Please Wait... <br>'+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></h4>');
        $.ajax({
            url:"/client/myaacount/payments",
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
            url:"/client/myaacount/wallets",
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
            url:"/client/movies/load/all",
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
        $('#upcomingmovies').html('<h4 class="mx-auto"> Loading Upcoming Movies. <br> Please Wait... <br>'+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></h4>');
        $.ajax({
            url:"/client/movies/load/upcoming",
            method:"GET",
            success:function(data){
              $('#upcomingmovies').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#upcomingmovies').html(errorMessage);
          }
        });
    }

    function loadAiringMovies(){
        $('#airingnowmovies').html('<h4 class="mx-auto"> Loading Live or to be Aired Movies. <br> Please Wait... <br>'+'<img src="{{ asset('/assets/img/spinner.gif') }}" class="img-circle" alt="loading..."></h4>');
        $.ajax({
            url:"/client/movies/load/onair",
            method:"GET",
            success:function(data){
              $('#airingnowmovies').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#airingnowmovies').html(errorMessage);
          }
        });
    }

    function loadHolderStatus(seat_id,upcoming,ticket_id,status){
      $('.successholder_status').html("Loading Status. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      $.ajax({
            url:"/client/seats/get/status/"+seat_id+"/"+upcoming+"/"+ticket_id+"/"+status,
            method:"GET",
            success:function(data){
              $('.successholder_status').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('.successholder_status').html(errorMessage);
          }
        });
    }

    function loadWalletStatus(amount,wallet){
      $('#modalmembershippackage-body').html("");
      $('#modalmembershippackage-body').html("Loading Status. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      $.ajax({
            url:"/client/accounts/get/membership/status/"+amount+"/"+wallet,
            method:"GET",
            success:function(data){
              $('#modalmembershippackage-body').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#modalmembershippackage-body').html(errorMessage);
          }
        });
    }

    function completePackagePurchase(amount,wallet,id,member,days,plan){
      $('#modalmembershippackage-body').html("");
      $('#modalmembershippackage-body').html("Submitting. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      $.ajax({
            url:"/client/accounts/pay/membership/"+amount+"/"+wallet+"/"+id+"/"+member+"/"+days+"/"+plan,
            method:"GET",
            success:function(data){
              $('#modalmembershippackage-body').html(data);
              loadMembership();
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#modalmembershippackage-body').html(errorMessage);
          }
        });
    }


    function completePackagePurchaseNew(amount,wallet,id,member,days,plan,amountpaid,packagetransactionid){
      $('#modalmembershippackage-body').html("");
      $('#modalmembershippackage-body').html("Submitting. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      $.ajax({
            url:"/client/accounts/pay/package/"+amount+"/"+wallet+"/"+id+"/"+member+"/"+days+"/"+plan+"/"+amountpaid+"/"+packagetransactionid,
            method:"GET",
            success:function(data){
              $('#modalmembershippackage-body').html(data);
              loadMembership();
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#modalmembershippackage-body').html(errorMessage);
          }
        });
    }


    

    

    function getLatestTickets(){
      $('.latesttickets').html("Loading Latest Tckets. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        movie_id ='';
        movie_name = '';
        screen_name = '';
        seat_id = '';
        seat_name = '';
        seat_section = '';
        ticket_amount = '';
        start_date = '';
        end_date = '';
        ticket_id = '';
        ticket = '';
        status = '';
        wallet = '';
        $('#paymentstatus').html('');
        $('#ticketpaysubmitbtn').show();
        $('#ticketpaysubmitbtn').html("Confirm Transaction");
      $.ajax({
        url:"/client/tickets/latest",
        method:"GET",
        success: function(data)
        {
          $('.latesttickets').html(data);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + xhr.statusText
          if (errorMessage=="0: error") {
              errorMessage="No Connection" 
          }
          $('.latesttickets').html(errorMessage+"<br>Could Not Load Latest Ticket Data");
        }
      });
    }

    function getMyTickets(){
      $('.mytickets').html("Loading My Tckets. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        
      $.ajax({
        url:"/client/tickets/all",
        method:"GET",
        success: function(data)
        {
          $('.mytickets').html(data);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + xhr.statusText
          if (errorMessage=="0: error") {
              errorMessage="No Connection" 
          }
          $('.mytickets').html(errorMessage+"<br>Could Not Load My Tickets Data");
        }
      });
    }

    function getMyMovieRequests(){
      $('.myrequests').html("Loading My Movie Requests. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        
      $.ajax({
        url:"/client/movie/requests/all",
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
      $('.myrequestedrefunds').html("Loading My Refunds. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        
      $.ajax({
        url:"/client/refunds/all",
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


    function load_seat_details(screen,upcoming,title){
      $('#modalscreenseat-body').html("Loading Seats. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      $.ajax({
            url:"/viewers/seats/get/"+screen+"/"+upcoming,
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

    $(document).on('click', '.streammovie', function(e){
        e.preventDefault();
        var id = $(this).data("id0");
        var title = $(this).data("id1");
        var film = $(this).data("id2");
        var director = $(this).data("id3");
        var description = $(this).data("id4");
        var thriller = $(this).data("id6");
        var stream = $(this).data("id7");
        $('#thrillerpage-title').html("Streaming Movie:: "+title);
        $('#thrillerpage-body').html("Loading Movie for Streaming:: <br> "+title+" <br> Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        $('#thrillerpage').modal('show');
        // var path="{{ asset('/assets/movies/')}}/"+id+"_"+thriller;
        // var path='/client/movies/stream/now/'+id+'_'+thriller;
        // var path='http://172.18.0.180:8080/stream1';
        // http://172.18.0.180:8080/stream1
        // $('#thrillerpage-body').html(path);
        $('#thrillerpage-body').html('<video  style="height:100%;width:100%" controls autoplay >'+
            '<source src="'+stream+'" type="video/mp4" id="video_player">'+   
        '</video>');

          // videojs(document.getElementById('video_player'), {}, function() {
              
          // });
    }); 

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

    $(document).on('click', '#ticketbooksubmitbtn', function(e){
      e.preventDefault();
      if (confirm("Do You want to Book this Seat ?")) {
        $('#bookingstatus').html("Booking. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
        $('#ticketbooksubmitbtn').hide();
        $.ajax({
          headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
            },
          type:'POST',
          url:'/client/movie/seats/book',
          data:{movie_id:movie_id,movie_name:movie_name,screen_name:screen_name,screen_id:screen_id,upcoming:upcoming,seat_id:seat_id,seat_name:seat_name,seat_section:seat_section,ticket_amount:ticket_amount},
          success: function(data)
          {
            $('#bookingstatus').html(data);
            getLatestTickets();
          },
          error: function(xhr, status, error){
            var errorMessage = xhr.status + ': ' + xhr.statusText
            if (errorMessage=="0: error") {
                errorMessage="No Connection" 
            }
            $('#bookingstatus').html("Error: "+errorMessage);
            $('#ticketbooksubmitbtn').show();
            $('#ticketbooksubmitbtn').html("Try Again");
          }
        });
      }
    });

    $(document).on('click', '#ticketpaysubmitbtn', function(e){
      e.preventDefault();
      var transactionid='';
      var total_amount='';
      transactionid=$('#unpaidtransactionid').val();
      total_amount=$('#unpaidtotal_amount').val();
      if (isNaN(total_amount)) {
        alert("Amount must be a Positive Integer in Currency Format");
        $('#paymentstatus').html("Amount must be a Positive Integer in Currency Format");
      }
      else if (transactionid.length!=10) {
        alert("Transaction ID Must be a 10 character Valid Code");
        $('#paymentstatus').html("Transaction ID Must be a 10 character Valid Code");
      }
      else{
        if (confirm("Do You want to Book this Seat ?")) {
          $('#paymentstatus').html("Confirming Transaction. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
          $('#ticketpaysubmitbtn').hide();
            $.ajax({
              headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
                },
              type:'POST',
              url:'/client/movie/ticket/pay',
              data:{movie_id:movie_id,movie_name:movie_name,screen_name:screen_name,screen_id:screen_id,upcoming:upcoming,seat_id:seat_id,seat_name:seat_name,seat_section:seat_section,ticket_amount:ticket_amount,ticket_id:ticket_id,ticket:ticket,transactionid:transactionid,total_amount:total_amount},
              success: function(data)
              {
                $('#paymentstatus').html(data);
              },
              error: function(xhr, status, error){
                var errorMessage = xhr.status + ': ' + xhr.statusText
                if (errorMessage=="0: error") {
                    errorMessage="No Connection" 
                }
                $('#paymentstatus').html("Error: "+errorMessage);
                $('#ticketpaysubmitbtn').show();
                $('#ticketpaysubmitbtn').html("Try Again");
              }
            });
          }
      }
    });

    $(document).on('click', '.checkiinnow', function(e){
      e.preventDefault();
        ticket_id = $(this).data("id1");
        upcoming = $(this).data("id2");
        seat_id = $(this).data("id3");
        $('#checkinstatus').html("");
        if (confirm("Do You want to Check in for this Movie ?")) {
          $('#checkinstatus').html("Checking In. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
          $('#checkiinnow').hide();
            $.ajax({
              headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
                },
              type:'POST',
              url:'/client/movie/ticket/checkin',
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

    $(document).on('click', '.cancelnow', function(e){
      e.preventDefault();
        ticket_id = $(this).data("id1");
        upcoming = $(this).data("id2");
        seat_id = $(this).data("id3");
        $('#checkinstatus').html("");
        if (confirm("Do You want to Cancel this Movie Ticket in for this Movie ?")) {
          $('#checkinstatus').html("Cancelling. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
          $('#checkiinnow').hide();
            $.ajax({
              headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
                },
              type:'POST',
              url:'/client/movie/ticket/cancel',
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
    

    $(document).on('click', '.closeseatpayment', function(e){
        load_seat_details(screen_id,upcoming,movie_name);
        movie_id ='';
        movie_name = '';
        screen_name = '';
        screen_id = '';
        upcoming = '';
        seat_id = '';
        seat_name = '';
        seat_section = '';
        ticket_amount = '';
        start_date = '';
        end_date = '';
        $('#bookingstatus').html('');
        $('#ticketbooksubmitbtn').show();
        $('#ticketbooksubmitbtn').html("Pay Now");
    });

    $(document).on('click', '.closeunpaidticket', function(e){
        getLatestTickets();
        getMyTickets();
    });

    $(document).on('click', '.finishticketpayment', function(e){
        e.preventDefault();
        $('#modalunpaidticket-body').html("Loading Selected Ticket. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
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
        $('#unpaidmovie_id').val(movie_id);
        $('#unpaidmovie_name').val('Movie : '+movie_name);
        $('#unpaidscreen_name').val('Screen: '+screen_name);
        $('#unpaidseat_section').val('Section: '+seat_section);
        $('#unpaidscreen_id').val(screen_id);
        $('#unpaidupcoming').val(upcoming);
        $('#unpaidmovie_id').val(movie_id);
        $('#unpaidseat_name').val('Seat Name:'+seat_name);
        $('#unpaidticket_amount').val('Ticket Amount:'+ticket_amount);
        $('#unpaidstart_date').val('Start Date:'+start_date);
        $('#unpaidend_date').val('End Date:'+end_date);
        $('#unpaidtotal_amount').val(ticket_amount);
        $('#unpaidstatus').val('Status : '+status);
        $('#unpaidwallet_balance').val(wallet);
        $('#unpaidticket').val('Ticket: '+ticket);
        $('#unpaidaccountno').val(ticket_id);
        loadHolderStatus(seat_id,upcoming,ticket_id,status);

        $('#paymentstatus').html('');
        $('#ticketbooksubmitbtn').show();
        $('#ticketbooksubmitbtn').html("Confirm Transaction");
        $('#modalunpaidticket-title').html(movie_name+ ' Pay for Ticket '+seat_name+'('+seat_section+')');
        $('#modalunpaidticket').modal('show');
    }); 

    $(document).on('click', '.unpaidticketpayment', function(e){
        e.preventDefault();
        $('#modalcanceledticket-body').html("Loading Selected Ticket. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
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
        $('#canceledmovie_id').val(movie_id);
        $('#canceledmovie_name').val('Movie : '+movie_name);
        $('#canceledscreen_name').val('Screen: '+screen_name);
        $('#canceledseat_section').val('Section: '+seat_section);
        $('#canceledscreen_id').val(screen_id);
        $('#canceledupcoming').val(upcoming);
        $('#canceledmovie_id').val(movie_id);
        $('#canceledseat_name').val('Seat Name:'+seat_name);
        $('#canceledticket_amount').val('Ticket Amount:'+ticket_amount);
        $('#canceledstart_date').val('Start Date:'+start_date);
        $('#canceledend_date').val('End Date:'+end_date);
        $('#canceledstatus').val('Status : '+status);
        $('#canceledticket').val('Ticket: '+ticket);
        loadHolderStatus(seat_id,upcoming,ticket_id,status);
        $('#modalcanceledticket-title').html(movie_name+ ' Unpaid or Cancelled Ticket '+seat_name+'('+seat_section+')');
        $('#modalcanceledticket').modal('show');
    }); 

  
    $(document).on('click', '.subscribeMembership', function(e){
        e.preventDefault();
        $('#checkinstatus').html("");
        $('#modalmembershippackage-body').html("Loading Package Details. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
          member = $(this).data("id0");
          id = $(this).data("id1");
          plan = $(this).data("id2");
          days = $(this).data("id3");
          amount = $(this).data("id4");
          status = $(this).data("id5");
          wallet = $(this).data("id6");
          bal=wallet-amount;
        
        if (bal<0) {
          alert('Please Pay the remaining Amount: '+Math.abs(bal));
          loadWalletStatus(amount,wallet);
          $(document).on('click', '#packagepaysubmitbtn', function(e){
            e.preventDefault();
            var packagetransactionid='';
            var amountpaid='';
            packagetransactionid=$('#packagetransactionid').val();
            amountpaid=$('#amountpaid').val();
            if (isNaN(amountpaid)) {
              alert("Amount must be a Positive Integer in Currency Format");
              $('#modalmembershippackage-body').html("Amount must be a Positive Integer in Currency Format");
            }
            else if (packagetransactionid.length!=10) {
              alert("Transaction ID Must be a 10 character Valid Code");
              $('#modalmembershippackage-body').html("Transaction ID Must be a 10 character Valid Code");
            }
            else{
              if (confirm("Do You want to Confirm this Transaction ?")) {
                completePackagePurchaseNew(amount,wallet,id,member,days,plan,amountpaid,packagetransactionid);
                $('#modalmembershippackage-body').html("Confirming Transaction. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
                $('#ticketpaysubmitbtn').hide();
                  
                }
            }
          });

        }
        else{
          completePackagePurchase(amount,wallet,id,member,days,plan);
        }
        $('#modalmembershippackage-title').html('Paying for Package: '+plan+'('+amount+')');
        $('#modalmembershippackage').modal('show');
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
        loadHolderStatus(seat_id,upcoming,ticket_id,status);
        $('#modalsuccessticket-title').html(movie_name+ ' Reserved or Used Ticket '+seat_name+'('+seat_section+')');
        $('#modalsuccessticket').modal('show');
    }); 

    $(document).on('click', '.createmovierequest', function(e){
        e.preventDefault();
        $('#movie_title').val('');
        $('#movie_description').val('');
        $('#submitbtn').html('Submit New Movie Request');
        $('#modalnewrequest-title').html('Create New Movie Request');
        $('#modalnewrequest').modal('show');
    }); 

    $(document).on('click', '.newrefundrequest', function(e){
        e.preventDefault();
        $('#reason').val('');
        $('#amount_requested').val('');
        $('#submitbtn').html('Submit New Refund Request');
        $('#modalnewrefundrequest-title').html('Create New Refund Request');
        $('#modalnewrefundrequest').modal('show');
    }); 

    $(document).on('click', '#savenewrequest', function(e){
        e.preventDefault();
        var movie_title=$('#movie_title').val();
        var movie_description=$('#movie_description').val();
        var requestmovieid=$('#requestmovieid').val();
        $('.newrequestresult').html("");
        if (confirm("Do You want to Request this Movie ?")) {
          $('.newrequestresult').html("Sending Request. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
          $('#savenewrequest').hide();
            $.ajax({
              headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
                },
              type:'POST',
              url:'/client/movie/requests/new',
              data:{movie_title:movie_title,movie_description:movie_description,requestmovieid:requestmovieid},
              success: function(data)
              {
                getMyMovieRequests();
                $('.newrequestresult').html(data);
                $('#movie_title').val('');
                $('#movie_description').val('');
                $('#savenewrequest').show();
                $('#savenewrequest').html("Submit New Movie Request Details");
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

    $(document).on('click', '#savenewrefundrequest', function(e){
      e.preventDefault();
        var reason=$('#reason').val();
        var amount_requested=$('#amount_requested').val();
        $('.newrefundrequestresult').html("");
        if (confirm("Do You want to Request this Refund ?")) {
          $('.newrefundrequestresult').html("Sending Refund Request. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
          $('#savenewrefundrequest').hide();
            $.ajax({
              headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
                },
              type:'POST',
              url:'/client/refund/request/new',
              data:{reason:reason,amount_requested:amount_requested},
              success: function(data)
              {
                getMyRefundRequests();
                $('.newrefundrequestresult').html(data);
                $('#reason').val('');
                $('#amount_requested').val('');
                $('#savenewrefundrequest').show();
                $('#savenewrefundrequest').html("Submit New Refund Request");
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
    });

    $(document).on('click', '.cancelledticketpayment', function(e){
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
        loadHolderStatus(seat_id,upcoming,ticket_id,status);
        $('#modalsuccessticket-title').html(movie_name+ ' Canceled Ticket '+seat_name+'('+seat_section+')');
        $('#modalsuccessticket').modal('show');
    }); 

    $(document).on('click', '.requetrefundnow', function(e){
        e.preventDefault();
        ticket_id = $(this).data("id1");
        upcoming = $(this).data("id2");
        seat_id = $(this).data("id3");
        $('#checkinstatus').html("");
        if (confirm("Do You want to Request Refund for this Canceled Ticket ?")) {
          $('#checkinstatus').html("Sending Refund Request. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
          $('#savenewrefundrequest').hide();
            $.ajax({
              headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
                },
              type:'POST',
              url:'/client/refund/request/new',
              data:{ticket_id:ticket_id,upcoming:upcoming,seat_id:seat_id},
              success: function(data)
              {
                getMyRefundRequests();
                $('#checkinstatus').html(data);
                $('#savenewrefundrequest').show();
                $('#savenewrefundrequest').html("Submit New Refund Request");
              },
              error: function(xhr, status, error){
                var errorMessage = xhr.status + ': ' + xhr.statusText
                if (errorMessage=="0: error") {
                    errorMessage="No Connection" 
                }
                $('#checkinstatus').html("Error: "+errorMessage);
                $('#savenewrefundrequest').show();
                $('#savenewrefundrequest').html("Try Again");
              }
            });
          }
    });

    $(document).on('click', '.requestmovie', function(e){
        e.preventDefault();
        var id = $(this).data("id0");
        var title = $(this).data("id1");
        $('#requestmovieid').val(id);
        $('#movie_title').val(title);
        $('#movie_description').val('');
        $('#submitbtn').html('Submit New Movie Request');
        $('#modalnewrequest-title').html('Create New Movie Request');
        $('#modalnewrequest').modal('show');
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

    $(document).on('click', '#searchmoviebtn', function(e){
        e.preventDefault();
        var searchmovie = $('#searchmovie').val();
        $('#searchmovieinfo').html("");
        $('#searchmovieinfo').html("Searching <br>"+ searchmovie +"<br> Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
          $.ajax({
            url:"/client/search/"+searchmovie,
            success: function(data)
            {
              $('#searchmovieinfo').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#searchmovieinfo').html("Error: "+errorMessage);
            }
          });
    });

</script>
</body>
</html>