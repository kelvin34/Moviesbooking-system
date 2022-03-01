@extends('layouts.admin')
@section('title')
Payments | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="">
    <div class="row justify-content-center m-1">

        <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1 p-0">
            <div class="col-md-12 mx-auto p-0">


                <div class="card mt-1">
                    <div class="card-header p-1 bg-white text-center">{{ __('Wallet Usages') }} 
                    </div>
                    <div class="card-body p-1 m-0">
                        <div class="row p-0 m-0 justify-content-center" id="allmywallets">
                            
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
                </div>
            </div>
        </div>


        
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
  $(function () {
    loadAllWallets();
  });
</script>
@endpush