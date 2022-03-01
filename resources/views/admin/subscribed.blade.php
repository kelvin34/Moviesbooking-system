@extends('layouts.admin')
@section('title')
Subscribed Members | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="" style="">
    <div class="row justify-content-center" style="">
        <div class="col-md-12 p-0 m-0" style="">
            <div class="card" style="border: none;">

                <div class="card-body" style="padding-top: 10px;">
                        <div class="row">
                            @forelse($subscribed as $member)
                            <div class="col-sm-4">
                             <div class="card card-primary card-outline">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="profile-user-img img-fluid img-circle"
                                       src="/assets/img/avatar.png"
                                       alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{ $member->fname }}</h3>

                                <p class="text-muted text-center">{{ \App\Models\Movie::getPlan($member->plan) }} (Member Since: {{ $member->created_at->diffForHumans() }})</p>
                                <ul class="list-group list-group-unbordered mb-3">
                                  <li class="list-group-item">
                                    <b>Name</b> <a class="float-right">{{ \App\Models\Movie::getNames($member->member) }}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>IDno</b> <a class="float-right">{{ \App\Models\Movie::getIdno($member->member) }}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ \App\Models\Movie::getEmail($member->member) }}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Phone</b> <a class="float-right">{{ \App\Models\Movie::getPhone($member->member) }}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Subscribed On</b> <a class="float-right">{{ $member->created_at }}</a>
                                  </li>
                                </ul>

                              </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-sm-4">
                             <div class="card card-primary card-outline">
                              <div class="card-body box-profile">
                                
                                <h3 class="profile-username text-center">No Subcribed Members</h3>

                                <p class="text-muted text-center">No Subcribed Member or User Found</p>
                              </div>
                            </div>
                        </div>

                        @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
