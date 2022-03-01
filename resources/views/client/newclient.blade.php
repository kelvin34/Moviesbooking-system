@extends('layouts.home')
@section('title','Create Account')
@section('css')
     <!-- Select2 -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                        <div class="card-body">
                            <div class="alert alert-success" role="alert">
                                <h4>{{ \Session::get('success') }}</h4>
                                <h4 class="text-center">{{ __('An Email verification link has been sent to your email address.') }}</h4>
                                <h4 class="text-center">{{ __('Before proceeding, please check your email for a verification link.') }}</h4>
                                <h4 class="text-center">
                                    @guest
                                        @if (Route::has('login'))
                                                {{ __('Click Here to login.') }}
                                                <a class="btn btn-info p-0 m-0 align-baseline" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        @endif
                                    @else
                                            {{ __('Continue to Home Page') }}
                                            <a class="btn btn-link p-0 m-0 align-baseline" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                {{ __('Click Here for Home') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                    @endguest
                                </h4>
                            </div>
                        </div>
                      <input type="hidden" name="successmsg" id="successmsg" value="{{ \Session::get('success') }}">
                    </div>
                @else
                    <div class="card-header bg-white text-center">{{ __('Create Account') }}</div>
                    <div class="card-body">
                        <form method="POST" action="/accounts/new/client/create">
                            @csrf
                            <input type="hidden" class="form-control" id="timezone" name="timezone" autocomplete="timezone">
                            <div class="form-group row">
                                <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }} <span class="text-danger"><sup>*</sup></span></label>

                                <div class="col-md-8">
                                    <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" placeholder="First Name" required autocomplete="fname" autofocus>

                                    @error('fname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lname" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }} <span class="text-danger"><sup>*</sup></span></label>

                                <div class="col-md-8">
                                    <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" placeholder="Last Name" required autocomplete="lname" autofocus>

                                    @error('lname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} <span class="text-danger"><sup>*</sup></span></label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email Account" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }} <span class="text-danger"><sup>*</sup></span></label>

                                <div class="col-md-8">
                                    <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" data-inputmask='"mask": "9999999999"' placeholder="Phone Number" required autocomplete="phone" autofocus data-mask>

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="idno" class="col-md-4 col-form-label text-md-right">{{ __('ID No') }} <span class="text-danger"><sup>*</sup></span></label>

                                <div class="col-md-8">
                                    <input id="idno" type="number" class="form-control @error('idno') is-invalid @enderror" name="idno" value="{{ old('idno') }}" placeholder="ID Number" minlength="8" maxlength="8" required autocomplete="idno" autofocus data-mask>

                                    @error('idno')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group row">
                                    <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('gender') }} <span class="text-danger"><sup>*</sup></span></label>

                                    <div class="col-md-8">
                                        <label>
                                           <input type="radio" name="gender" value="Male"/ required=""> Male 
                                        </label>
                                        <label>
                                           <input type="radio" name="gender" value="Female"/ required=""> Female
                                        </label>
                                        <label>
                                           <input type="radio" name="gender" value="Other"/ required=""> Other
                                        </label>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }} <span class="text-danger"><sup>*</sup></span></label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New Password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }} <span class="text-danger"><sup>*</sup></span></label>

                                <div class="col-md-8">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8  offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit New Account Details') }}
                                    </button>
                                    <a class="btn btn-link" href="{{ route('login') }}">
                                        {{ __('Login') }}
                                    </a>

                                </div>
                            </div>
                        </form>
                    </div>
                @endif
                    
                
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
