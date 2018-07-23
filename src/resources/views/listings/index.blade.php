@extends('layouts.app')

@section('title', 'Latest')

@section('content')
    @include('partials.title', [
        'fa' => 'fa-calendar',
        'title' => 'Latest',
        'subtitle' => config('job-core.keyword_root'),
        'link' => route('listings.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('levels.partials.levels')
            </div>
        </div>
    </div>
@endsection