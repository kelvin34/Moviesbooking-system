@extends('layouts.home')
@section('title')
Contact Us | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mx-auto">
            <div class="card mt-1">
                <div class="card-header text-center">Contact Us Through Our Varies Endpoints</div>

                <div class="card-body mx-auto text-xs">
                    <p>You Can Use Our Social Media platforms to contact US.</p>
                    <ul class="p-1 text-xs">
                        <li>Facebook: www.facebook.com/Movies</li>
                    </ul>
                    <p>You Can Also Use Our Contact form Below and Our dedicated agent will get on you as soon as possible</p>
                </div>
            </div>
            
            <div class="card mt-2">
                <div class="card-header text-center">{{ __('Contact Form') }}</div>

                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <label for="searchmovie" class="col-md-3">Your Name</label>
                            <div class="col-md-9">
                                <input type="text" id="searchmovie" name="searchmovie" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="searchmovie" class="col-md-3">Your Email</label>
                            <div class="col-md-9">
                                <input type="text" id="searchmovie" name="searchmovie" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="searchmovie" class="col-md-3">Your Issue</label>
                            <div class="col-md-9">
                                <input type="text" id="searchmovie" name="searchmovie" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="searchmovie" class="col-md-3">Description</label>
                            <div class="col-md-9">
                                <textarea id="searchmovie" name="searchmovie" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mx-auto">
                                <input type="submit" id="searchmoviebtn" name="searchmoviebtn" class="btn btn-info" value="Submit Now">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
