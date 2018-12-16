@extends('layouts.dashboard')

@section('title', 'Rider Details')

@section('content')
<div class="panel">
    <div class="panel-body">
        <div class="fixed-fluid">
            <div class="fixed-md-200 pull-sm-left fixed-right-border">
                <div class="text-center">
                    <div class="pad-ver">
                        <img src="{{ $rider->rider_avatar }}" class="img-lg img-circle" alt="Profile Picture">
                    </div>
                    <h4 class="text-lg text-overflow mar-no">{{ $rider->first_name }} {{ $rider->last_name }}</h4>
                    <p class="text-sm text-muted">Rider</p>
                </div>
                <hr>

                <p class="pad-ver text-main text-sm text-uppercase text-bold">About Rider</p>
                <p><i class="demo-pli-calendar-4 icon-lg icon-fw"></i> {{ \Carbon\Carbon::parse($rider->date_of_birth)->format('dS F Y') }}</p>
                <p><i class="demo-pli-old-telephone icon-lg icon-fw"></i> {{ $rider->primary_phone_number }}</p>

            </div>
        </div>
    </div>
</div>
@endsection
