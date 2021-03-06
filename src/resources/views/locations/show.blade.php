@extends('job-core::layouts.app')

@section('title', $location->pageTitle)
@section('description', $location->pageDescription)

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-map',    
        'title' => $location->title,
        'subtitle' => config('job-core.keyword'),
         'link' => route('locations.show', ['location' => $location->slug])
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::locations.partials.locations')
            </div>
        </div>
    </div>
    @if($location->description)
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <div class="row">
                <div class="col-12 col-md-9">
                    @include('job-core::locations.partials.location')
                </div>
            </div>
        </div>
    @endif
@endsection