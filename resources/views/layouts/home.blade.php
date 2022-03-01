<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
      <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css.css') }}" rel="stylesheet">
</head>
<body class="bg-white">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-success fixed-top shadow-sm">
            <div class="container">
                <img
                    width="30"
                    alt="{{ config('app.name', 'Movies Booking System') }} Logo"
                    src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNTAgMjUwIj4KICAgIDxwYXRoIGZpbGw9IiNERDAwMzEiIGQ9Ik0xMjUgMzBMMzEuOSA2My4ybDE0LjIgMTIzLjFMMTI1IDIzMGw3OC45LTQzLjcgMTQuMi0xMjMuMXoiIC8+CiAgICA8cGF0aCBmaWxsPSIjQzMwMDJGIiBkPSJNMTI1IDMwdjIyLjItLjFWMjMwbDc4LjktNDMuNyAxNC4yLTEyMy4xTDEyNSAzMHoiIC8+CiAgICA8cGF0aCAgZmlsbD0iI0ZGRkZGRiIgZD0iTTEyNSA1Mi4xTDY2LjggMTgyLjZoMjEuN2wxMS43LTI5LjJoNDkuNGwxMS43IDI5LjJIMTgzTDEyNSA1Mi4xem0xNyA4My4zaC0zNGwxNy00MC45IDE3IDQwLjl6IiAvPgogIDwvc3ZnPg=="
                  />
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                <img
                    width="30"
                    alt="{{ config('app.name', 'Movies Booking System') }} Logo"
                    src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNTAgMjUwIj4KICAgIDxwYXRoIGZpbGw9IiNERDAwMzEiIGQ9Ik0xMjUgMzBMMzEuOSA2My4ybDE0LjIgMTIzLjFMMTI1IDIzMGw3OC45LTQzLjcgMTQuMi0xMjMuMXoiIC8+CiAgICA8cGF0aCBmaWxsPSIjQzMwMDJGIiBkPSJNMTI1IDMwdjIyLjItLjFWMjMwbDc4LjktNDMuNyAxNC4yLTEyMy4xTDEyNSAzMHoiIC8+CiAgICA8cGF0aCAgZmlsbD0iI0ZGRkZGRiIgZD0iTTEyNSA1Mi4xTDY2LjggMTgyLjZoMjEuN2wxMS43LTI5LjJoNDkuNGwxMS43IDI5LjJIMTgzTDEyNSA1Mi4xem0xNyA4My4zaC0zNGwxNy00MC45IDE3IDQwLjl6IiAvPgogIDwvc3ZnPg=="
                  />
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/movies') }}">{{ __('Movies') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/onair') }}">{{ __('On Air') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/upcoming') }}">{{ __('Upcoming') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/aboutus') }}">{{ __('About Us') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/contactus') }}">{{ __('Contact US') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/partners') }}">{{ __('Partners') }}</a>
                        </li>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/home') }}">{{ __('Dashboard') }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="/create-client-account">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="" style="padding-top: 80px;">
            @yield('content')

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
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                          <input type="hidden" name="movie_id" id="movie_id" class="form-control " disabled>
                                          <input type="hidden" name="screen_id" id="screen_id" class="form-control " disabled>
                                          <input type="hidden" name="seat_id" id="seat_id" class="form-control " disabled>
                                          <input type="hidden" name="upcoming" id="upcoming" class="form-control " disabled>
                                          <input type="text" name="movie_name" id="movie_name" title="Movie Title/Name" class="form-control p-1 m-1" disabled>
                                          <input type="text" name="screen_name" id="screen_name" title="Screen Name" class="form-control p-1 m-1" disabled>
                                          <input type="text" name="seat_name" id="seat_name" title="Seat Name" class="form-control p-1 m-1" disabled>
                                          <input type="text" name="seat_section" id="seat_section" title="Section Type" class="form-control p-1 m-1" disabled>
                                      </div>
                                      <div class="col-8">
                                          <!-- stt -->
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
                                          <!-- endd -->
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
            <!-- end modal seats -->

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


        </main>
    </div>

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
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
@stack('scripts')
<script type="text/javascript">
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

    $(document).on('click', '.getmovieseat', function(e){
        e.preventDefault();
        $('#modalscreenseat-body').html("Loading Seats. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
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

        $('#modalscreenseat').modal('show');
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


</script>
</body>
</html>
