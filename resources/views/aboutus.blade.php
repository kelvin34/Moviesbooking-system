@extends('layouts.home')
@section('title')
About US | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mx-auto">
            <div class="card mt-1">
                <div class="card-header text-center">{{ config('app.name', 'Movies Booking and Resrvation System') }}</div>

                <div class="card-body mx-auto">
                    <p>This is Online Movies Reservation and Booking Website. We provide all movies ready to be aired for reservation.</p>
                    <p>This is Online Movies Reservation and Booking Website. We provide all movies ready to be aired for reservation.</p>
                    <p>This is Online Movies Reservation and Booking Website. We provide all movies ready to be aired for reservation.</p>
                    <p>This is Online Movies Reservation and Booking Website. We provide all movies ready to be aired for reservation.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
