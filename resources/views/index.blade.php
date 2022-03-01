@extends('layouts.home')
@section('title')
Home | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">

            <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1 p-0">

            <div class="col-md-12 mx-auto p-0">
                <div class="card">
                    <div class="card-body text-center homelists">
                        <div class="callout callout-success p-2 mb-5">
                            <h4 class="text-info  text-center">Welcome</h4>
                            <p class="p-2">This is Online Movies Reservation and Booking Website.</p>
                            <p class="p-2">We provide all movies ready to be aired for reservation.</p>
                        </div>
                        <div class="callout callout-danger p-2 mb-5">
                            <h4 class="text-info  text-center">Book and Reserve</h4>
                            <p class="p-2">You can book or reserve a movie within 24 hours before its Aired</p>
                            <p class="p-2">Payment is Done Within 10 minutes after successfully booking to avoid being Marked as available</p>
                        </div>
                        <div class="callout callout-info p-2 mb-5">
                            <h4 class="text-info  text-center">Variety of Upcoming Movie</h4>
                            <p class="p-2">Upcoming Movies can be booked in advance</p>
                            <p class="p-2">Movies Scheduled 14 days before airing time are also available fo booking. You just need an account </p>
                        </div>
                        <div class="callout callout-warning p-2 mb-5">
                            <h4 class="text-info  text-center">Have Favourite Movie. Requesting Is Easy</h4>
                            <p class="p-2">Any Movie of your choice can also be scheduled for airing when requested</p>
                            <p class="p-2">You just need to raise request, give simple description of your movie or link to a not scheduled Movies</p>
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
                            <div class="form-group row p-0 m-0 mb-0">
                                <div class="mr-1">
                                    <input type="text" id="searchmovie" name="searchmovie" class="form-control" placeholder="Search Movies Here">
                                </div>
                                <div class="text-right text-xs">
                                    <input type="submit" id="searchmoviebtn" name="searchmoviebtn" class="btn btn-warning" value="Search">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="p-1 m-1 bg-light text-xs">
                        <p>Search {{ config('app.name', 'Movies Booking and Resrvation System') }}</p>
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
    loadAiringMovies();
    loadUpcomingMovies();
    loadAllMovies();
  });
</script>
@endpush