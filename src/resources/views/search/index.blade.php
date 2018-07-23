@extends('layouts.app')

@section('title', 'Search Jobs')

@section('content')
    @if($listings && count($listings))
        @include('partials.title', [
            'fa' => 'fa-list',
            'title' => 'Search',
            'subtitle' => $subtitle,
            'link' => route('search.index')
        ])
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <div class="row">
                <div class="col-12 col-md-9">
                    @include('listings.partials.listings')
                </div>
                <div class="col-12 col-md-3">
                    @include('search.partials.narrow')
                </div>
            </div>
        </div>
    @else
        @include('search.partials.form')
    @endif
@endsection