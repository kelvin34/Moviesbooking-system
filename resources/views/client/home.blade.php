@extends('layouts.dashboard')
@section('title')
Dashboard | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="">
    <div class="row justify-content-center m-1">

        <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1 p-0">
            <div class="col-md-12 mx-auto p-0">
                <div class="card">
                    
                    <div class="card-body p-0 m-0" style="padding-top: 10px;">
                          <div class="col-12 p-0 m-0">
                            
                                <ul class="pagination pagination-month text-center p-0 m-0 text-xs" style="padding: 4px;overflow-x: auto;">
                                  <li class="page-item monthlystatsprev"><a class="page-link" href="#">« Prev</a></li>
                                    {{ App\Http\Controllers\MoviesController::getMonths() }}
                                </ul>
                                <div class="card " style="padding: 2px;margin: 5px;">
                                  <div class="card-header bg-white p-1 text-center">  
                                    <span class="mx-auto">Your Tickets and Movies History</span>
                                    (<span class="text-left text-sm text-bold col-12" id="monthy-title"></span>)
                                        <div class="card-tools m-1">
                                          <button type="button" class="btn btn-tool p-1 text-right" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                          </button>
                                        </div>
                                  </div>
                                  <div class="card-body p-1 m-0">
                                    <div class=" p-2">
                                      
                                      <div class="row justify-content-center " id="monthlybills">
                                        
                                      </div>
                                    </div>
                                  </div>
                                </div> 

                              </div>


                        </div>
                </div>

                <div class="card mt-1">
                    <div class="card-header p-1 bg-warning text-center">{{ __('Airing Today some time As Stated') }} 
                    </div>
                    <div class="card-body p-1 m-0">
                        <div class="row p-0 m-0 justify-content-center" id="airingnowmovies">
                            
                        </div>
                    </div>
                </div>

                <div class="card mt-1 ">
                    <div class="card-header p-1 bg-success text-center">{{ __('Upcoming / Scheduled Movies Some days Later') }} 
                    </div>

                    <div class="card-body p-1 m-0">
                        <div class="row p-0 m-0 justify-content-center" id="upcomingmovies">
                            
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header p-1 bg-info text-center">{{ __('Get to know movies you can request') }} 
                    </div>

                    <div class="card-body p-1 m-0">
                        <div class="row p-0 m-0 justify-content-center" id="allmovies">
                           
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

                    <div class="p-1 m-1 bg-teal" id="searchmovieinfo">
                        Search Info
                    </div>
                    <div class="p-1 m-1 bg-white">
                        <div class="card-header bg-olive p-1">
                            <h4 class="text-center text-sm">Latest Tickets</h4>
                        </div>
                        
                        <div class="text-sm latesttickets">
                            <div class="p-2 callout callout-info">
                              <span class="text-sm">753-R28L32-20210916212734(Reserved)</span>

                              <p class="text-xs text-danger">Click Here to Complete Payment.</p>
                            </div>

                            <div class="p-2 callout callout-warning">
                              <h5>7-R2L3-20210916212734(Booked)</h5>

                              <p>View Ticket.</p>
                            </div>
                        </div>
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
    loadAiringMovies();
    loadUpcomingMovies();
    loadAllMovies();
    function getcurrentMonthDash(month,monthly,yearly,currentdate){
      if(monthly==0){
        $('#monthlybills').html("Loading Current Month. Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      }
      else{
        $('#monthlybills').html("Loading "+monthly+", "+yearly+". Please Wait... "+'<img src="{{ asset('assets/img/spinner.gif') }}" class="img-circle" alt="loading...">');
      }
      $.ajax({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"').attr('content')
          },
        type:'POST',
        url:'/movies/dash/hist',
        data:{month:month},
        success: function(data)
        {
          if(monthly==0){
            $('#monthy-title').html('Current Month');
          }
          else{
            $('#monthy-title').html(monthly+', '+yearly);
          }
          $('#monthlybills').html(data);
        },
        error: function(xhr, status, error){
          var errorMessage = xhr.status + ': ' + xhr.statusText
          if (errorMessage=="0: error") {
              errorMessage="No Connection" 
          }
          $('#monthlybills').html(errorMessage+"<br>Could Not Load Data for "+monthly+', '+yearly);
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