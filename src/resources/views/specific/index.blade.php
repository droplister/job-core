@extends('job-core::layouts.app')

@section('title', config('job-core.keyword') . ' for Veterans')

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-star',
        'title' => 'Veterans',
        'subtitle' => config('job-core.keyword'),
         'link' => route('specific.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::agencies.partials.agencies')
            </div>
        </div>
    </div>
@endsection