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
                @endif
                <div class="card">
                    <div class="card-header p-1 bg-white text-center">{{ __('Not Scheduled Movies') }} 
                        <button class="btn btn-primary addnewmovie ml-3">Add Movie</button>
                    </div>

                    <div class="card-body p-1 m-0">
                        <div class="row p-0 m-0">
                            @forelse($movies as $movie)
                                @if((App\Models\Movie::getNow() >= App\Models\Movie::getOnAirDate($movie->id)) && App\Models\Movie::getOnAirDate($movie->id)!='')
                                    
                                @elseif((App\Models\Movie::getNow() < App\Models\Movie::getOnAirDate($movie->id)) && App\Models\Movie::getOnAirDate($movie->id)!='')
                                    @if((App\Models\Movie::get24HoursfromNow() >= App\Models\Movie::getOnAirDate($movie->id)))
                                       
                                    @else
                                      
                                    @endif

                                @else
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 p-1 m-0 movie-thriller mb-4">
                                                <div class="card text-xs">
                                                    <div class="ribbon-wrapper m-1">
                                                        @if((App\Models\Movie::getNow() >= App\Models\Movie::getOnAirDate($movie->id)) && App\Models\Movie::getOnAirDate($movie->id)!='')
                                                            <div class="ribbon bg-danger text-xs">
                                                                <span class="fa fa-microphone-slash"></span><br>
                                                              <b class="text-light text-xs">Aired</b>
                                                            </div>
                                                        @elseif((App\Models\Movie::getNow() < App\Models\Movie::getOnAirDate($movie->id)) && App\Models\Movie::getOnAirDate($movie->id)!='')
                                                            @if((App\Models\Movie::get24HoursfromNow() >= App\Models\Movie::getOnAirDate($movie->id)))
                                                                <div class="ribbon bg-orange text-xs">
                                                                    <span class="fa fa-microphone text-lime"></span><br>
                                                                  <b class="text-light text-xs">Airing</b>
                                                                </div>
                                                            @else
                                                                <div class="ribbon bg-success text-xs">
                                                                    <span class="fa fa-clock"></span><br>
                                                                  <b class="text-light text-xs">Upcoming</b>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="ribbon bg-primary text-xs">
                                                              <b class="text-light text-xs">Not Scheduled</b>
                                                            </div>
                                                        @endif
                                                  </div>
                                            <div class="card-body p-0 m-0">
                                                @if($movie->thriller=='')
                                                <div class="bg-warning p-2 text-center text-sm"> 
                                                    <span class="text-xs text-danger">({{$movie->genre}})</span> <b>{{$movie->title}}</b>
                                                    <p> <span class="fa fa-exclamation-triangle"></span> No Thriller Uploaded</p>

                                                     @if($movie->thriller=='')
                                                        <button class="btn btn-link text-sm p-1 mb-1 addmoviethriller" data-id0="{{$movie->id}}" data-id1="{{$movie->title}}" data-id2="{{$movie->film}}" data-id3="{{$movie->director}}" data-id4="{{$movie->description}}" data-id6="{{$movie->thriller}}"> <span class="fa fa-film"> Add  Thriller</span></button>
                                                    @endif
                                                </div>
                                                @else
                                                    <div class="bg-light p-2 text-center text-sm"> 
                                                        <span class="text-xs text-danger">({{$movie->genre}})</span> <b>{{$movie->title}}</b>
                                                        <p>Thriller Available. </p>
                                                        <button class="btn btn-link text-sm p-1 mb-1 viewthriller" data-id0="{{$movie->id}}" data-id1="{{$movie->title}}" data-id2="{{$movie->film}}" data-id3="{{$movie->director}}" data-id4="{{$movie->description}}" data-id6="{{$movie->thriller}}"> <span class="fa fa-film"> View Thriller Here</span></button>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="card-body p-1 m-0 text-xs" style="max-height:150px;overflow-y:auto;">
                                                <b>Film : </b> ({{$movie->film}}) <br>
                                                <b>Directed : </b>{{$movie->director}} 
                                                @if($movie->thriller!='')
                                                <br>
                                                    @if(App\Models\Movie::getOnAirDate($movie->id)=='')
                                                        <button class="btn  btn-link text-sm p-0 m-0 addmoviereleasedate" data-id0="{{$movie->id}}" data-id1="{{$movie->title}}" data-id2="{{$movie->film}}" data-id3="{{$movie->director}}" data-id4="{{$movie->description}}">Set Upcoming Date</button>
                                                    @else
                                                        <button class="btn  btn-link text-sm p-0 m-0 updatemoviereleasedate" data-id0="{{$movie->id}}" data-id1="{{$movie->title}}" data-id2="{{$movie->film}}" data-id3="{{$movie->director}}" data-id4="{{$movie->description}}" title="{{App\Models\Movie::getTimeForHumans(App\Models\Movie::getOnAirDate($movie->id))}}"><b>Scheduled: </b> ({{App\Models\Movie::getOnAirDate($movie->id)}})</button>
                                                    @endif 
                                                @endif 

                                                <span class="" style="white-space:pre-line;">
                                                    {{$movie->description}}
                                                </span>
                                            </div>
                                            <div class="bg-light p-1 text-xs"> 
                                                <button class="btn btn-dark text-sm p-0 pr-1 pl-1 mb-1 updatemovie" data-id0="{{$movie->id}}" data-id1="{{$movie->title}}" data-id2="{{$movie->film}}" data-id3="{{$movie->director}}" data-id4="{{$movie->description}}"><span class="fa fa-edit"></span></button>
                                                <button class="btn btn-danger text-sm p-0 pr-1 pl-1 mb-1 deletemovie" data-id0="{{$movie->id}}" data-id1="{{$movie->title}}" data-id2="{{$movie->film}}" data-id3="{{$movie->director}}" data-id4="{{$movie->description}}"><span class="fa fa-trash"></span></button>
                                                <button class="btn btn-info text-sm p-0 pr-1 pl-1 mb-1 viewmoviereviews"> <span class="fa fa-comments"></span></button>
                                                @if($movie->thriller!='')
                                                    @if(App\Models\Movie::getOnAirDate($movie->id)!='')
                                                        <button class="btn btn-secondary text-sm p-0 pr-1 pl-1 mb-1 m-1 getmovieseat" data-id0="{{$movie->id}}" data-id1="{{$movie->title}}" data-id2="{{$movie->film}}" data-id3="{{$movie->director}}" data-id4="{{$movie->description}}" data-id6="{{$movie->thriller}}" data-id7="{{App\Models\Movie::getUpcomingId($movie->id)}}" data-id8="{{App\Models\Movie::getUpcomingIdScreen(App\Models\Movie::getUpcomingId($movie->id))}}" title="Booking Seats"> <span class="fa fa-wheelchair"> </span></button>

                                                        <button class="btn btn-secondary text-sm p-0 pr-1 pl-1 mb-1 m-1 bookedseatdetails" data-id0="{{$movie->id}}" data-id1="{{$movie->title}}" data-id2="{{$movie->film}}" data-id3="{{$movie->director}}" data-id4="{{$movie->description}}" data-id6="{{$movie->thriller}}" data-id7="{{App\Models\Movie::getUpcomingId($movie->id)}}" data-id8="{{App\Models\Movie::getUpcomingIdScreen(App\Models\Movie::getUpcomingId($movie->id))}}" data-id9="{{App\Models\Movie::getUpcomingIdScreenName(App\Models\Movie::getUpcomingIdScreen(App\Models\Movie::getUpcomingId($movie->id)))}}" title="View Tickets and Details"> <span class="fa fa-eye"> </span></button>
                                                    @endif 
                                                @endif 
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="col-md-12 col-sm-12 col-xs-12 p-1 m-0 movie-thriller mb-4">
                                    <div class="card text-xs">
                                        <div class="card-body p-1 m-0">
                                            <h4 class="text-center text-danger">No Movies Found</h4>
                                        </div>
                                        <div class="card-body p-1 m-0 text-xs">
                                            <h4 class="text-center text-dark">Please try to Create Some</h4>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                            
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


    // Dropzone.options.dropzoneForm={
    //   autoProcessQueue:true,
    //   maxFilesize: 3000,
    //   addRemoveLinks: true,
    //   timeout: 500000,
    //   acceptedFiles: "video/*",
    //   success: function(file, response)
    //   {
    //     //reload page
    //     alert('Thriller Uploaded');
    //     return true;
    //   },
    //   error: function(file, response)
    //   {
    //     //error uploading
    //     alert('Thriller Not Uploaded');
    //     return false;
    //   }
    // };

  });

</script>
@endpush