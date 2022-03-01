@extends('layouts.admin')
@section('title')
Movies | {{ config('app.name', 'Laravel') }}
@endsection
@section('css')
      <!-- dropzonejs -->
      <link rel="stylesheet" href="{{ asset('assets/dropzone/basic.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/dropzone/dropzone.css') }}">
@endsection
@section('content')
<div class="">
    <div class="row justify-content-center m-1">

        <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1 p-0">
            <div class="col-md-12 mx-auto p-0">
                
                @if(\Session::has('dbError'))
                    <input type="hidden" name="dberrormsg" id="dberrormsg" value="{{ \Session::get('dbError') }}">
                @elseif(\Session::has('success'))
                    <input type="hidden" name="successmsg" id="successmsg" value="{{ \Session::get('success') }}">
                @elseif(\Session::has('dbErrorUpcoming'))
                    <input type="hidden" name="dbErrorUpcoming" id="dbErrorUpcoming" value="{{ \Session::get('dbErrorUpcoming') }}">
                @elseif(\Session::has('dbErrorStreaming'))
                    <input type="hidden" name="dbErrorStreaming" id="dbErrorStreaming" value="{{ \Session::get('dbErrorStreaming') }}">
                @endif
                <div class="card">
                    <div class="card-header p-1 bg-white text-center">{{ __('Movies') }} 
                        <button class="btn btn-primary addnewmovie ml-3">Add Movie</button>
                    </div>

                    <div class="card-body p-1 m-0">
                       <!-- style="background:url("http://127.0.0.1:8085/assets/movies/4_Cover_Stupid times.jpg");background-repeat: no-repeat;" -->
                        <div class="row p-0 m-0" id="allmovies">

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
    <!-- dropzone -->
    <!-- <script src="{{ asset('assets/dropzone/dropzone.js') }}"></script> -->
<script type="text/javascript">
  $(function () {

    var successmsg=$('#successmsg').val();
    var dberrormsg=$('#dberrormsg').val();
    var dbErrorUpcoming=$('#dbErrorUpcoming').val();
    var dbErrorStreaming=$('#dbErrorStreaming').val();

    if (successmsg) {
        $('.erroradding').html('');
        alert(successmsg);
    }

    if (dberrormsg) {
        $('.erroradding').html(dberrormsg);
        $('#modalmovie-title').html('Errors Found During New Movie Add');
        $('#modalmovie').modal('show');
    }

    if (dbErrorUpcoming) {
        $('.erroradding').html(dbErrorUpcoming);
        $('#modalreleaseon-title').html('Errors Found During Setting Upcoming Movie');
        $('#modalreleaseon').modal('show');
    }

    if (dbErrorStreaming) {
        $('.erroradding').html(dbErrorStreaming);
        $('#modalmoviestream-title').html('Errors Found Setting Movie Stream Link');
        $('#modalmoviestream').modal('show');
    }

    loadAllMovies();
  });

</script>
@endpush