@extends('layouts.home')
@section('title')
On Air | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">

            <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1 p-0">

            <div class="col-md-12 mx-auto p-0">
                <div class="card mt-1">
                    <div class="card-header p-1 bg-warning text-center">{{ __('Airing Today some time As Stated') }} 
                    </div>
                    <div class="card-body p-1 m-0">
                        <div class="row p-0 m-0 justify-content-center" id="airingnowmovies">
                            
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
  });
</script>
@endpush