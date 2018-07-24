@extends('layouts.app')

@section('title', $schedule->value . ' ' . config('job-core.keyword'))

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-calendar',
        'title' => $schedule->value,
        'subtitle' => config('job-core.keyword'),
         'link' => route('schedules.show', ['schedule' => $schedule->slug])
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::schedules.partials.schedules')
            </div>
        </div>
    </div>
@endsection