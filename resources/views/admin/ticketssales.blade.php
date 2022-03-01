@extends('layouts.admin')
@section('title')
Ticket Sales | {{ config('app.name', 'Laravel') }}
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
                    <div class="card-header p-1 bg-white text-center">{{ __('Ticket Sales Summary Per Airing') }} 
                    </div>

                    <div class="card-body p-1 m-0">
                        <div class="row p-0 m-0" id="tiketsalesperAiring">
                            
                            
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

    loadTicketSalesPerMovies();

  });

</script>
@endpush