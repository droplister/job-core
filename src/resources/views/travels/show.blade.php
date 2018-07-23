@extends('layouts.app')

@section('title', $travel->value . ' ' . config('job-core.keyword'))

@section('content')
    @include('partials.title', [
        'fa' => 'fa-plane',
        'title' => $travel->value,
        'subtitle' => config('job-core.keyword'),
         'link' => route('travels.show', ['travel' => $travel->slug])
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('travels.partials.travels')
            </div>
        </div>
    </div>
@endsection