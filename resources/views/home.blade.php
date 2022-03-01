@extends('layouts.dashboard')
@section('title')
Dashboard | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1 p-0">
            <div class="col-md-12 mx-auto p-0">
                <div class="card">
                    <div class="card-header bg-white p-1 text-center">{{ __('On Air Now') }}</div>

                    <div class="card-body p-1 m-0">
                        <div class="row p-0 m-0">
                            <div class="col-md-4 col-sm-4 col-xs-4 p-1 m-0 movie-thriller mb-4">
                                <div class="card text-xs">
                                    <div class="card-body p-0 m-0">
                                        <video height="150px" controls> 
                                            <source src="{{ asset('assets/movies/movie5.mp4')}}" type="video/mp4"> 
                                            Your browser does not support the video tag. 
                                       </video>
                                    </div>
                                    <div class="card-body p-1 m-0 text-xs">
                                        Movie Name On Screen Two At 0700 hours
                                        <div class="p-1 text-xs text-right"> 
                                            <button class="btn btn-secondary text-xs p-1 m-1"> <span class="fa fa-comments-0"></span>Reviews</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 p-1 m-0 movie-thriller mb-4">
                                <div class="card text-xs">
                                    <div class="card-body p-0 m-0">
                                        <video height="150px" class="p-1 m-1" controls> 
                                            <source src="{{ asset('assets/movies/movie6.mp4')}}" type="video/mp4"> 
                                            Your browser does not support the video tag. 
                                       </video>
                                    </div>
                                    <div class="card-body p-1 m-0 text-xs">
                                        Movie Name On Screen Two At 0700 hours
                                        <div class="p-1 text-xs text-right"> 
                                            <button class="btn btn-secondary text-xs p-1 m-1"> <span class="fa fa-comments-0"></span>Reviews</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 p-1 m-0 movie-thriller mb-4">
                                <div class="card text-xs">
                                    <div class="card-body p-0 m-0">
                                        <video height="150px" class="p-1 m-1" controls> 
                                            <source src="{{ asset('assets/movies/movie4.mp4')}}" type="video/mp4"> 
                                            Your browser does not support the video tag. 
                                       </video>
                                    </div>
                                    <div class="card-body p-1 m-0 text-xs">
                                        Movie Name On Screen Two At 0700 hours
                                        <div class="p-1 text-xs text-right"> 
                                            <button class="btn btn-secondary text-xs p-1 m-1"> <span class="fa fa-comments-0"></span>Reviews</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 p-1 m-0 movie-thriller mb-4">
                                <div class="card text-xs">
                                    <div class="card-body p-0 m-0">
                                        <video height="150px" class="p-1 m-1" controls> 
                                            <source src="{{ asset('assets/movies/movie3.mp4')}}" type="video/mp4"> 
                                            Your browser does not support the video tag. 
                                       </video>
                                    </div>
                                    <div class="card-body p-1 m-0 text-xs">
                                        Movie Name On Screen Two At 0700 hours
                                        <div class="p-1 text-xs text-right"> 
                                            <button class="btn btn-secondary text-xs p-1 m-1"> <span class="fa fa-comments-0"></span>Reviews</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header bg-white text-center">{{ __('Online Movies Reservation and Booking') }}</div>

                    <div class="card-body p-1 m-0">
                        <div class="row p-0 m-0">
                            <div class="col-md-4 col-sm-4 col-xs-4 p-1 m-0 movie-thriller mb-4">
                                <div class="card text-xs">
                                    <div class="card-body p-0 m-0">
                                        <video height="150px" class="p-1 m-1" controls> 
                                            <source src="{{ asset('assets/movies/movie5.mp4')}}" type="video/mp4"> 
                                            Your browser does not support the video tag. 
                                       </video>
                                    </div>
                                    <div class="card-body p-1 m-0 text-xs">
                                        Movie Name On Screen Two At 0700 hours
                                        <div class="p-1 text-xs text-right"> 
                                            <button class="btn btn-secondary text-xs p-1 m-1"> <span class="fa fa-comments-0"></span>Reviews</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 p-1 m-0 movie-thriller mb-4">
                                <div class="card text-xs">
                                    <div class="card-body p-0 m-0">
                                        <video height="150px" class="p-1 m-1" controls> 
                                            <source src="{{ asset('assets/movies/movie6.mp4')}}" type="video/mp4"> 
                                            Your browser does not support the video tag. 
                                       </video>
                                    </div>
                                    <div class="card-body p-1 m-0 text-xs">
                                        Movie Name On Screen Two At 0700 hours
                                        <div class="p-1 text-xs text-right"> 
                                            <button class="btn btn-secondary text-xs p-1 m-1"> <span class="fa fa-comments-0"></span>Reviews</button>
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