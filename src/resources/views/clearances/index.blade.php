@extends('job-core::layouts.app')

@section('title', config('job-core.keyword') . ' by Clearance Level')
@section('description', 'Looking for ' . strtolower(config('job-core.keyword')) . ' for the government that require a certain clearance level?')

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-info-circle',
        'title' => 'Clearance Levels',
        'link' => route('clearances.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12">
                @include('job-core::clearances.partials.chunk')
            </div>
        </div>
    </div>
@endsection