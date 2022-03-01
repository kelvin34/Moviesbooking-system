@extends('layouts.admin')
@section('title')
Screens | {{ config('app.name', 'Laravel') }}
@endsection
@section('css')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
                @elseif(\Session::has('dbErrorSeat'))
                    <input type="hidden" name="dbErrorSeat" id="dbErrorSeat" value="{{ \Session::get('dbErrorSeat') }}">
                @endif
                <div class="card">
                    <div class="card-header p-1 bg-white text-center">{{ __('Screens') }} 
                        <button class="btn btn-primary addscreen ml-3">Add Screen</button>
                    </div>

                    <div class="card-body p-1 m-0">
                        <div class="row p-0 m-0">
                            @forelse($screens as $screen)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 p-1 m-0 mb-4">
                                <div class="card text-xs">
                                    <div class="card-body p-1 m-0 text-xs" style="">
                                        <b>Screen : </b>{{$screen->screen}}<br> 
                                        <b>SeatsRow(Left) : </b> {{$screen->rowsleft}}<br>
                                        <b>SeatsRow(Center) : </b>{{$screen->rowscenter}}<br>
                                        <b>SeatsRow(Right) : </b>{{$screen->rowsright}}<br>
                                        <b>Capacity : </b>{{$screen->capacity}}<br>
                                    </div>
                                    <div class="bg-light p-1 text-center text-xs"> 
                                        @if(!App\Http\Controllers\MoviesController::getScreenUsage($screen->id))
                                            <button class="btn btn-dark text-sm p-0 pr-1 pl-1 mb-1 m-1 updatescreen" data-id0="{{$screen->id}}" data-id1="{{$screen->screen}}" data-id2="{{$screen->rowsleft}}" data-id3="{{$screen->rowscenter}}" data-id5="{{$screen->rowsright}}" data-id4="{{$screen->capacity}}"><span class="fa fa-edit"></span></button>
                                            <button class="btn btn-danger text-sm p-0 pr-1 pl-1 mb-1 m-1 deletescreen" data-id0="{{$screen->id}}" data-id1="{{$screen->screen}}" data-id2="{{$screen->rowsleft}}" data-id3="{{$screen->rowscenter}}" data-id5="{{$screen->rowsright}}" data-id4="{{$screen->capacity}}"><span class="fa fa-trash"></span></button>
                                        @else
                                            <button class="btn btn-info text-sm p-0 pr-1 pl-1 mb-1 m-1 moviesscreen" data-id0="{{$screen->id}}" data-id1="{{$screen->screen}}" data-id2="{{$screen->rowsleft}}" data-id3="{{$screen->rowscenter}}" data-id5="{{$screen->rowsright}}" data-id4="{{$screen->capacity}}"><span class="fa fa-eye"></span></button>
                                        @endif
                                        
                                        <button class="btn btn-success text-sm p-0 pr-1 pl-1 mb-1 m-1 seatsscreen" data-id0="{{$screen->id}}" data-id1="{{$screen->screen}}" data-id2="{{$screen->rowsleft}}" data-id3="{{$screen->rowscenter}}" data-id5="{{$screen->rowsright}}" data-id4="{{$screen->capacity}}"><span class="fa fa-wheelchair"></span></button>
                                        <button class="btn btn-secondary text-xs p-0 pr-1 pl-1 mb-1 m-1 seatsscreensection" data-id0="{{$screen->id}}" data-id1="{{$screen->screen}}" data-id2="{{$screen->rowsleft}}" data-id3="{{$screen->rowscenter}}" data-id5="{{$screen->rowsright}}" data-id4="{{$screen->capacity}}"><span class="fa fa-circle"> Section</span></button>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="col-md-12 col-sm-12 col-xs-12 p-1 m-0 mb-4">
                                    <div class="card text-xs">
                                        <div class="card-body p-1 m-0">
                                            <h4 class="text-center text-danger">No Screens Found</h4>
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
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
  $(function () {

    var successmsg=$('#successmsg').val();
    var dberrormsg=$('#dberrormsg').val();
    var dbErrorSeat=$('#dbErrorSeat').val();
    

    if (successmsg) {
        $('.erroradding').html('');
        alert(successmsg);
    }
    if (dbErrorSeat) {
        $('.erroradding').html('');
        alert(dbErrorSeat);
    }

    if (dberrormsg) {
      $('.erroradding').html(dberrormsg);
      $('#modalscreen-title').html('Errors Found During New Screen Add');
      $('#modalscreen').modal('show');
    }
  });

</script>
@endpush