@extends('job-core::layouts.app')

@section('title', $clearance->pageTitle)
@section('description', $clearance->pageDescription)

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-info-circle',
        'title' => $clearance->value,
        'subtitle' => config('job-core.keyword'),
        'link' => route('clearances.show', ['clearance' => $clearance->slug])
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::clearances.partials.clearances')
            </div>
        </div>
    </div>
@endsection