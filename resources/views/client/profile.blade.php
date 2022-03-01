@extends('layouts.dashboard')
@section('title')
Profile | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="" style="">
    <div class="row justify-content-center" style="">
        <div class="col-md-12" style="">
            <div class="card" style="border: none;">

                <div class="card-body" style="padding-top: 10px;">
                        <div class="row">
                        <div class="col-sm-4">
                             <div class="card card-primary card-outline">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="profile-user-img img-fluid img-circle"
                                       src="/assets/img/avatar.png"
                                       alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{ Auth::user()->fname }}</h3>

                                <p class="text-muted text-center">{{ Auth::user()->roles }} (Created On: {{ Auth::user()->created_at->diffForHumans() }})</p>
                                <ul class="list-group list-group-unbordered mb-3">
                                  <li class="list-group-item">
                                    <b>Fname</b> <a class="float-right">{{ Auth::user()->fname }}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Lname</b> <a class="float-right">{{ Auth::user()->lname }}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>IDno</b> <a class="float-right">{{ Auth::user()->idno }}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ Auth::user()->email }}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Phone</b> <a class="float-right">{{ Auth::user()->phone }}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Created At</b> <a class="float-right">{{ Auth::user()->created_at }}</a>
                                  </li>
                                </ul>

                              </div>
                              <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-sm-8">

                            @if ($errors->any())
                              <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                              </div><br/>
                            @endif

                            @if(\Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                <h4>{{ \Session::get('success') }}</h4>
                            </div>
                            @endif
                            @if(\Session::has('dbError'))
                            <div class="alert alert-success" role="alert">
                                <h4>{{ \Session::get('dbError') }}</h4>
                            </div>
                            @endif
                          <div class="row">
                            <div class="col-sm-12">
                            <form role="form" class="form-horizontal" method="post" action="{{ route('homeusers.update',Auth::user()->id) }}">
                                @csrf
                                @method('PATCH')
                            <div class="card card-primary card-outline" style="margin-bottom: 5%;min-height: 200px;text-align: center;">
                              <div class="card-body">
                                    <h5 style="text-align: center;">Update Information for:  {{ Auth::user()->fname }} {{ Auth::user()->lname }} </h5>

                                <div class="form-group row">
                                    <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('Fname') }}</label>

                                    <div class="col-md-8">
                                        <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ Auth::user()->fname }}" placeholder="fname" required autocomplete="fname" autofocus>

                                        @error('fname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('Lname') }}</label>

                                    <div class="col-md-8">
                                        <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ Auth::user()->lname }}" placeholder="lname" required autocomplete="lname" autofocus>

                                        @error('lname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                                    <div class="col-md-8">
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ Auth::user()->phone }}" placeholder="phone" required autocomplete="phone" autofocus>

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="Idno" class="col-md-4 col-form-label text-md-right">{{ __('Idno') }}</label>

                                    <div class="col-md-8">
                                        <input id="idno" type="number" class="form-control @error('idno') is-invalid @enderror" name="idno" value="{{ Auth::user()->idno }}" placeholder="idno" required autocomplete="idno" autofocus>

                                        @error('idno')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group float-right">
                                    <div> 
                                        <button  class="btn btn-success btn-small btn-block" name="" id=""  type="submit" ><i class="fa fa-edit"></i> Update Your Information</button>
                                    </div>
                                </div>
                                 
                              </div>
                            </div>

                        </form>
                    </div>
                    <!-- end update personal details -->
                   
                </div>

                <div class="row">
                    <div class="col-sm-12">
                            <form role="form" class="form-horizontal" method="post" action="{{ route('clients.update',Auth::user()->id) }}">
                                @csrf
                                @method('PATCH')
                            <div class="card card-primary card-outline" style="margin-bottom: 5%;min-height: 200px;text-align: center;">
                              <div class="card-body">
                                    <h5 style="text-align: center;">Change Password </h5>
                                <div class="form-group row">
                                    <label for="Password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                                    <div class="col-md-8">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Password" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-8">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group float-right">
                                    <div> 
                                        <button  class="btn btn-success btn-small btn-block" name="" id=""  type="submit" ><i class="fa fa-lock"></i> Change Password</button>
                                    </div>
                                </div>
                                 
                              </div>
                            </div>

                        </form>
                    </div>
                    <!-- end change password -->
                </div>

               

                </div>

                
                

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
