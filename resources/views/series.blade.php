@extends('layouts.home')
@section('title')
Series | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mx-auto">
            <div class="card p-0 m-0">
                <div class="card-header text-center">Search Your Series Here</div>

                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <label for="searchmovie" class="col-md-2">Search Here</label>
                            <div class="col-md-8">
                                <input type="text" id="searchmovie" name="searchmovie" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="submit" id="searchmoviebtn" name="searchmoviebtn" class="btn btn-warning" value="Search Now">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header bg-warning text-center">{{ __('Your Searched Series Here') }}</div>

                <div class="card-body p-1 m-0">
                    <div class="card">
                        <div class="row p-0 m-0">
                            <div class="col-md-5 p-1 m-0">
                                <div class="card-body m-1">
                                    <p>Serie Name:</p>
                                    <p>Screen:</p>
                                    <p>Time:</p>
                                    <p>Description:</p>
                                </div>
                            </div>
                            <div class="col-md-4 p-1 m-0">
                                <div class="card-body m-1">
                                    <video width="100%" controls> 
                                        <source src="{{ asset('asset/movies/movie5.mp4')}}" type="video/mp4"> 
                                        Your browser does not support the video tag. 
                                   </video>
                                </div>
                            </div>
                            <div class="col-md-3 p-1 m-0  bg-warning">
                                <div class="card-body mt-0 text-xs"> 
                                    <h5>Series Reviews</h5>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card mt-2">
                        <div class="row p-0 m-0">
                            <div class="col-md-5 p-1 m-0">
                                <div class="card-body m-1">
                                    <p>Serie Name:</p>
                                    <p>Screen:</p>
                                    <p>Time:</p>
                                    <p>Description:</p>
                                </div>
                            </div>
                            <div class="col-md-4 p-1 m-0">
                                <div class="card-body m-1">
                                    <video width="100%" controls> 
                                        <source src="{{ asset('asset/movies/movie1.mp4')}}" type="video/mp4"> 
                                        Your browser does not support the video tag. 
                                   </video>
                                </div>
                            </div>
                            <div class="col-md-3 p-1 m-0  bg-warning">
                                <div class="card-body mt-0 text-xs"> 
                                    <h5>Series Reviews</h5>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="row p-0 m-0">
                            <div class="col-md-5 p-1 m-0">
                                <div class="card-body m-1">
                                    <p>Serie Name:</p>
                                    <p>Screen:</p>
                                    <p>Time:</p>
                                    <p>Description:</p>
                                </div>
                            </div>
                            <div class="col-md-4 p-1 m-0">
                                <div class="card-body m-1">
                                    <video width="100%" controls> 
                                        <source src="{{ asset('asset/movies/movie6.mp4')}}" type="video/mp4"> 
                                        Your browser does not support the video tag. 
                                   </video>
                                </div>
                            </div>
                            <div class="col-md-3 p-1 m-0  bg-warning">
                                <div class="card-body mt-0 text-xs"> 
                                    <h5>Series Reviews</h5>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="row p-0 m-0">
                            <div class="col-md-5 p-1 m-0">
                                <div class="card-body m-1">
                                    <p>Serie Name:</p>
                                    <p>Screen:</p>
                                    <p>Time:</p>
                                    <p>Description:</p>
                                </div>
                            </div>
                            <div class="col-md-4 p-1 m-0">
                                <div class="card-body m-1">
                                    <video width="100%" controls> 
                                        <source src="{{ asset('asset/movies/movie3.mp4')}}" type="video/mp4"> 
                                        Your browser does not support the video tag. 
                                   </video>
                                </div>
                            </div>
                            <div class="col-md-3 p-1 m-0  bg-warning">
                                <div class="card-body mt-0 text-xs"> 
                                    <h5>Series Reviews</h5>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                    <p>User:, Review: rating</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
