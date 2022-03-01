@extends('layouts.admin')
@section('title')
Subscription Plans | {{ config('app.name', 'Laravel') }}
@endsection
@section('css')
     <!-- Select2 -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">

                @if(\Session::has('dbError'))
                    <div class="card-header text-center">
                        <div class="alert alert-danger" role="alert">
                            <h4>{{ \Session::get('dbError') }}</h4>
                        </div>
                    <input type="hidden" name="dberrormsg" id="dberrormsg" value="{{ \Session::get('dbError') }}">
                    </div>
                @endif
                @if(\Session::has('success'))
                    <div class="card-header text-center">
                        <div class="alert alert-success" role="alert">
                            <h4>{{ \Session::get('success') }}</h4>
                        </div>
                      <input type="hidden" name="successmsg" id="successmsg" value="{{ \Session::get('success') }}">
                    </div>
               @endif
                    <div class="card-header bg-white text-center">{{ __('Create Plan') }}</div>
                    <div class="card-body">
                        <form method="POST" action="/accounts/new/plan/create">
                            @csrf
                            <div class="form-group row">
                                <label for="plan" class="col-md-4 col-form-label text-md-right">{{ __('Plan Name') }} <span class="text-danger"><sup>*</sup></span></label>

                                <div class="col-md-8">
                                    <input id="plan" type="text" class="form-control @error('plan') is-invalid @enderror" name="plan" value="{{ old('plan') }}" placeholder="Plan Name" required autocomplete="plan" autofocus>

                                    @error('plan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="days" class="col-md-4 col-form-label text-md-right">{{ __('Days') }} <span class="text-danger"><sup>*</sup></span></label>

                                <div class="col-md-8">
                                    <input id="days" type="text" class="form-control @error('days') is-invalid @enderror" name="days" value="{{ old('days') }}" placeholder="Days" required autocomplete="days" autofocus>

                                    @error('days')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }} <span class="text-danger"><sup>*</sup></span></label>

                                <div class="col-md-8">
                                    <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" placeholder="Amount" required autocomplete="amount">

                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                              <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }} <span class="text-danger"><sup>*</sup></span></label>

                              <div class="col-md-8">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" placeholder="Plan Description" required autocomplete="description"></textarea>
                                  @error('description')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                              </div>
                          </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8  offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit New Plan') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                
            </div>
        </div>

        <div class="col-md-12">
            <div class="card" style="border: none;">
                <div class="card-body" style="padding-top: 10px;">
                    <h3 class="text-center m-0 p-1">All Plans</h3>
                    <div class="row">
                        @forelse($plans as $plan)
                        <div class="col-md-4 col-sm-6 col-12 p-1 m-0">
                            <div class="info-box">
                              <span class="info-box-icon bg-orange p-1 m-0 text-sm text-white">Shs. {{ $plan->amount }} </span>

                              <div class="info-box-content">
                                <span class="info-box-text">{{ $plan->plan }}<span class="text-bold"></span> (<span class="text-xs text-olive">{{ $plan->status }}</span>)</span>
                                <span class="info-box-number">{{ $plan->days }} Days</span>
                                <span class="info-box-number text-xs">Current Subscribed:<span class="text-orange"> {{ \App\Models\Movie::getSubscribedMembers($plan->id)}} </span></span>
                                <span class="info-box-text text-xs" style="white-space:pre-line;">{{ $plan->description }}</span>
                                
                              </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12 col-sm-12 col-12 p-1 m-0">
                            <div class="info-box">
                              <span class="info-box-icon bg-orange p-1 m-0 text-sm"><i class="fa fa-exclamation-triangle fa-2x"></i> </span>

                              <div class="info-box-content">
                                <span class="info-box-text">No Plans</span>
                                <span class="info-box-number"></span>
                                <span class="info-box-text text-xs">Your Have No Plans Set</span>
                              </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment-timezone-with-data-2012-2022.min.js') }}"></script>
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
        var thistimezone=moment.tz.guess();
        $('#timezone').val(thistimezone);
    });
</script>
@endpush
