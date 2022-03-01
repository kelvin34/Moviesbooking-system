@extends('layouts.dashboard')
@section('title')
Client Movies | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="">
    <div class="row justify-content-center m-1">

        <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1 p-0">
            <div class="col-md-12 mx-auto p-0">
             
                <div class="card mt-1">
                    <div class="card-header p-1 bg-warning text-center">{{ __('Check Our Movies') }} 
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
    loadAllMovies();
  });
</script>
@endpush