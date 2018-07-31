@extends('job-core::layouts.app')

@section('title', 'Search Jobs')

@section('content')
    @if(empty($_GET))
        @include('job-core::search.partials.form')
    @else
        @include('job-core::partials.title', [
            'fa' => 'fa-list',
            'title' => 'Search',
            'subtitle' => $subtitle,
            'link' => route('search.index')
        ])
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <div class="row">
                <div class="col-12 col-md-9">
                    @include('job-core::listings.partials.listings')
                </div>
                <div class="col-12 col-md-3">
                    @include('job-core::partials.filters', ['route' => 'search.index'])
                </div>
            </div>
        </div>
    @endif
@endsection