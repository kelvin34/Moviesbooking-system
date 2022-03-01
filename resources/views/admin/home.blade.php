@extends('layouts.admin')
@section('title')
Dashboard | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="">
    <div class="row justify-content-center m-1">

        <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1 p-0">
            <div class="col-md-12 mx-auto p-0">
                <div class="card">
                    
                    <div class="card-body p-1 m-0" style="padding-top: 10px;">
                          <div class="col-12 p-0 m-0">
                            
                                <ul class="pagination pagination-month text-center p-0 m-0 text-xs" style="padding: 4px;overflow-x: auto;">
                                  <li class="page-item monthlystatsprev"><a class="page-link" href="#">« Prev</a></li>
                                    {{ App\Http\Controllers\MoviesController::getMonths() }}
                                </ul>
                                <div class="card " style="padding: 2px;margin: 5px;">
                                  <div class="card-header bg-white p-1 text-center">  
                                    <span class="mx-auto text-lg">Tickets and Movies History</span>
                                    (<span class="text-left text-sm text-bold col-12 monthy-title"></span>)
                                        <div class="card-tools m-1">
                                          <button type="button" class="btn btn-tool p-1 text-right" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                          </button>
                                        </div>
                                  </div>
                                  <div class="card-body p-1 mb-0 m-0">
                                    <div class=" p-0 m-0">
                                      
                                      <div class="row justify-content-center m-0" id="monthlyhistory">
                                        
                                      </div>
                                    </div>
                                  </div>
                                </div> 


                                <div class="card " style="padding: 2px;margin: 5px;">
                                  <div class="card-header bg-white p-1 text-center">  
                                    <span class="mx-auto text-lg">Latest Requests</span>
                                    (<span class="text-left text-sm text-bold col-12 monthy-title"></span>)
                                        <div class="card-tools m-1">
                                          <button type="button" class="btn btn-tool p-1 text-right" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                          </button>
                                        </div>
                                  </div>
                                  <div class="card-body p-1 m-0">
                                    <div class=" p-2">
                                      
                                      <div class="row justify-content-center " id="monthlyrequests">
                                        <div class="callout callout-info p-1 m-1">
                                          <h5>I am an info callout!</h5>

                                          <p>Follow the steps to continue to payment.</p>
                                        </div>
                                        <div class="callout callout-info p-1 m-1">
                                          <h5>I am an info callout!</h5>

                                          <p>Follow the steps to continue to payment.</p>
                                        </div>
                                        <div class="callout callout-info p-1 m-1">
                                          <h5>I am an info callout!</h5>

                                          <p>Follow the steps to continue to payment.</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div> 


                                <div class="card " style="padding: 2px;margin: 5px;">
                                  <div class="card-header bg-white p-1 text-center">  
                                    <span class="mx-auto text-lg">Newest Members</span>
                                    (<span class="text-left text-sm text-bold col-12 monthy-title"></span>)
                                        <div class="card-tools m-1">
                                          <button type="button" class="btn btn-tool p-1 text-right" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                          </button>
                                        </div>
                                  </div>
                                  <div class="card-body p-1 m-0">
                                    <div class=" p-2">
                                      
                                      <div class="row justify-content-center " >

                                        <div class="card-body row justify-content-center p-0 m-0 products-list" id="monthlymembers">
                                          <div class="col-lg-3 col-md-4 col-6 m-0 p-1">
                                            <div class="callout callout-info p-2">
                                                <div class="product-img">
                                                  <img src="{{ asset('assets/img/avatar.png') }}" class="profile-user-img img-circle" alt="User Image">
                                                </div>
                                                <div class="product-info">
                                                  <a class="users-list-name" href="#">Alexander Pierce</a>
                                                <span class="users-list-date">Today</span>
                                                </div>
                                            </div>
                                          </div>

                                          <div class="col-lg-3 col-md-4 col-6 m-0 p-1">
                                            <div class="callout callout-info p-2">
                                                <div class="product-img">
                                                  <img src="{{ asset('assets/img/avatar.png') }}" class="profile-user-img img-circle" alt="User Image">
                                                </div>
                                                <div class="product-info">
                                                  <a class="users-list-name" href="#">Alexander Pierce</a>
                                                <span class="users-list-date">Today</span>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-3 col-md-4 col-6 m-0 p-1">
                                            <div class="callout callout-info p-2">
                                                <div class="product-img">
                                                  <img src="{{ asset('assets/img/avatar.png') }}" class="profile-user-img img-circle" alt="User Image">
                                                </div>
                                                <div class="product-info">
                                                  <a class="users-list-name" href="#">Alexander Pierce</a>
                                                <span class="users-list-date">Today</span>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-3 col-md-4 col-6 m-0 p-1">
                                            <div class="callout callout-info p-2">
                                                <div class="product-img">
                                                  <img src="{{ asset('assets/img/avatar.png') }}" class="profile-user-img img-circle" alt="User Image">
                                                </div>
                                                <div class="product-info">
                                                  <a class="users-list-name" href="#">Alexander Pierce</a>
                                                <span class="users-list-date">Today</span>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-3 col-md-4 col-6 m-0 p-1">
                                            <div class="callout callout-info p-2">
                                                <div class="product-img">
                                                  <img src="{{ asset('assets/img/avatar.png') }}" class="profile-user-img img-circle" alt="User Image">
                                                </div>
                                                <div class="product-info">
                                                  <a class="users-list-name" href="#">Alexander Pierce</a>
                                                <span class="users-list-date">Today</span>
                                                </div>
                                            </div>
                                          </div>
                                          

                                        </div>

                                      </div>
                                    </div>
                                  </div>
                                </div> 

                                <div class="card " style="padding: 2px;margin: 5px;">
                                  <div class="card-header bg-white p-1 text-center">  
                                    <span class="mx-auto text-lg">Latest Movies</span>
                                    (<span class="text-left text-sm text-bold col-12 monthy-title"></span>)
                                        <div class="card-tools m-1">
                                          <button type="button" class="btn btn-tool p-1 text-right" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                          </button>
                                        </div>
                                  </div>
                                  <div class="card-body p-1 m-0">
                                    <div class=" p-2">
                                      
                                      <div class="row justify-content-center ">
                                        <div class="card-body row justify-content-center p-0 m-0 products-list" id="monthlymovies">
                                          <div class="col-lg-4 col-6 m-0 p-1">
                                            <div class="callout callout-info p-0">
                                              <div class="product-img">
                                                  <span class="fa fa-film fa-3x text-warning"></span>
                                                </div>
                                                <div class="product-info">
                                                  <a href="javascript:void(0)" class="product-title">Samsung TV
                                                    <span class="badge badge-warning float-right">$1800</span></a>
                                                  <span class="product-description">
                                                    Samsung 32" 1080p
                                                  </span>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-6 m-0 p-1">
                                              <div class="callout callout-info p-0">
                                                <div class="product-img">
                                                  <span class="fa fa-film fa-3x text-warning"></span>
                                                </div>
                                                <div class="product-info">
                                                  <a href="javascript:void(0)" class="product-title">Samsung TV
                                                    <span class="badge badge-warning float-right">$1800</span></a>
                                                  <span class="product-description">
                                                    Samsung 32" 1080p
                                                  </span>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-6 m-0 p-1">
                                              <div class="callout callout-info p-0">
                                                <div class="product-img">
                                                  <span class="fa fa-film fa-3x text-warning"></span>
                                                </div>
                                                <div class="product-info">
                                                  <a href="javascript:void(0)" class="product-title">Bicycle
                                                    <span class="badge badge-info float-right">$700</span></a>
                                                  <span class="product-description">
                                                    26" Mongoose 
                                                  </span>
                                                </div>
                                            </div>
                                          </div>

                                          <div class="col-lg-4 col-6 m-0 p-1">
                                              <div class="callout callout-info p-0">
                                                <div class="product-img">
                                                  <span class="fa fa-film fa-3x text-warning"></span>
                                                </div>
                                                <div class="product-info">
                                                  <a href="javascript:void(0)" class="product-title">
                                                    Xbox One <span class="badge badge-danger float-right">
                                                    $350
                                                  </span>
                                                  </a>
                                                  <span class="product-description">
                                                    Xbox One Console
                                                  </span>
                                                </div>
                                            </div>  
                                          </div>
                                          <div class="col-lg-4 col-6 m-0 p-1">
                                              <div class="callout callout-info p-0">
                                                <div class="product-img">
                                                  <span class="fa fa-film fa-3x text-warning"></span>
                                                </div>
                                                <div class="product-info">
                                                  <a href="javascript:void(0)" class="product-title">PlayStation 4
                                                    <span class="badge badge-success float-right">$399</span></a>
                                                  <span class="product-description">
                                                    PlayStation 4 
                                                  </span>
                                                </div>
                                            </div>
                                          </div>


                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div> 

                              </div>
                        </div>
                </div>
                
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-3 order-1 order-md-2 elevation-1 p-0">
            <div class="">
                <div class="card p-0 m-0  mb-0">
                    <div class="card-header bg-white p-0">
                        <form class="m-0">
                            <div class="form-group row p-1 m-0 mb-0">
                                <div class="mr-1">
                                    <input type="text" id="searchmovie" name="searchmovie" class="form-control" placeholder="Search Movies Here">
                                </div>
                                <div class="text-right text-xs">
                                    <input type="submit" id="searchmoviebtn" name="searchmoviebtn" class="btn btn-warning" value="Search">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="p-1 m-1 bg-light">
                        axw
                    </div>
                </div>
            </div>
        </div>


        
    </div>
</div>
@endsection
@push('scripts')

<script type="text/javascript">
  $(function () {

    getcurrentMonthDash(0,0,0,0);
    getcurrentMonthDashRequests(0,0,0,0);
    getcurrentMonthDashMembers(0,0,0,0);
    getcurrentMonthDashMovies(0,0,0,0);

    function getcurrentMonthDash(month,monthly,yearly,currentdate){
      if(monthly==0){
        $('#monthlyhistory').html("Loading Current Month. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      }
      else{
        $('#monthlyhistory').html("Loading "+monthly+", "+yearly+". Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      }
      $.ajax({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
          },
        type:'POST',
        url:'/admin/movies/dash/hist',
        data:{month:month},
        success: function(data)
        {
          if(monthly==0){
            $('.monthy-title').html('Current Month');
          }
          else{
            $('.monthy-title').html(""+monthly+', '+yearly);
          }
          $('#monthlyhistory').html(data);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + xhr.statusText
          if (errorMessage=="0: error") {
              errorMessage="No Connection" 
          }
          $('#monthlyhistory').html(errorMessage+"<br>Could Not Load Data for "+monthly+', '+yearly);
        }
      });
    }

    function getcurrentMonthDashRequests(month,monthly,yearly,currentdate){
      if(monthly==0){
        $('#monthlyrequests').html("Loading Current Month. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      }
      else{
        $('#monthlyrequests').html("Loading "+monthly+", "+yearly+". Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      }
      $.ajax({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
          },
        type:'POST',
        url:'/admin/movies/dash/hist/requests',
        data:{month:month},
        success: function(data)
        {
          if(monthly==0){
            $('.monthy-title').html('Current Month');
          }
          else{
            $('.monthy-title').html(""+monthly+', '+yearly);
          }
          $('#monthlyrequests').html(data);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + xhr.statusText
          if (errorMessage=="0: error") {
              errorMessage="No Connection" 
          }
          $('#monthlyrequests').html(errorMessage+"<br>Could Not Load Data for "+monthly+', '+yearly);
        }
      });
    }

    function getcurrentMonthDashMembers(month,monthly,yearly,currentdate){
      if(monthly==0){
        $('#monthlymembers').html("Loading Current Month. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      }
      else{
        $('#monthlymembers').html("Loading "+monthly+", "+yearly+". Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      }
      $.ajax({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
          },
        type:'POST',
        url:'/admin/movies/dash/hist/members',
        data:{month:month},
        success: function(data)
        {
          if(monthly==0){
            $('.monthy-title').html('Current Month');
          }
          else{
            $('.monthy-title').html(""+monthly+', '+yearly);
          }
          $('#monthlymembers').html(data);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + xhr.statusText
          if (errorMessage=="0: error") {
              errorMessage="No Connection" 
          }
          $('#monthlymembers').html(errorMessage+"<br>Could Not Load Data for "+monthly+', '+yearly);
        }
      });
    }

    function getcurrentMonthDashMovies(month,monthly,yearly,currentdate){
      if(monthly==0){
        $('#monthlymovies').html("Loading Current Month. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      }
      else{
        $('#monthlymovies').html("Loading "+monthly+", "+yearly+". Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      }
      $.ajax({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
          },
        type:'POST',
        url:'/admin/movies/dash/hist/movies',
        data:{month:month},
        success: function(data)
        {
          if(monthly==0){
            $('.monthy-title').html('Current Month');
          }
          else{
            $('.monthy-title').html(""+monthly+', '+yearly);
          }
          $('#monthlymovies').html(data);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + xhr.statusText
          if (errorMessage=="0: error") {
              errorMessage="No Connection" 
          }
          $('#monthlymovies').html(errorMessage+"<br>Could Not Load Data for "+monthly+', '+yearly);
        }
      });
    }

    $(document).on('click', '.monthlystats', function(e){
        e.preventDefault();
        var month = $(this).data("id0");
        var monthly = $(this).data("id1");
        var yearly = $(this).data("id2");
        var currentdate = $(this).data("id3");
        getcurrentMonthDash(month,monthly,yearly,currentdate);
        getcurrentMonthDashRequests(month,monthly,yearly,currentdate);
        getcurrentMonthDashMembers(month,monthly,yearly,currentdate);
        getcurrentMonthDashMovies(month,monthly,yearly,currentdate);
    }); 

    $(document).on('click', '.monthlystatsprev', function(e){
        e.preventDefault();
          $('#modalpage-body').html("Loading Previous Months. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
          $.ajax({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
              },
            type:'POST',
            url:'/movies/dash/hist/prev',
            data:{month:'Prev'},
            success: function(data)
            {
              $('#modalpage-title').text("Previous Months");
              $('#modalpage').modal('show');
              $('#modalpage-body').html(data);
            },
            error: function(xhr, status, error){
              var errorMessage = xhr.status + ': ' + xhr.statusText
              if (errorMessage=="0: error") {
                  errorMessage="No Connection" 
              }
              $('#modalpage-title').text("Previous Months Error");
              $('#modalpage').modal('show');
              $('#modalpage-body').html(errorMessage+"<br>Could Not Load Data for Previous Months");
            }
          });
    }); 
    

  });
</script>
@endpush