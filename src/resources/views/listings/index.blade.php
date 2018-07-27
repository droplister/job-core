@extends('job-core::layouts.app')

@section('title', 'Latest ' . config('job-core.keyword'))
@section('description', 'We track the latest ' . number_format($listings->total()) . ' ' . config('job_core.keyword') . ' posted on USAJobs.gov and other job boards. Find out more at ' . config('job-core.domain') . '.')

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-calendar',
        'title' => 'Latest',
        'subtitle' => config('job-core.keyword'),
        'link' => route('listings.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::levels.partials.levels')
            </div>
        </div>
    </div>
@endsection