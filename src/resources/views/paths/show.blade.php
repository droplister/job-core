@extends('layouts.app')

@section('title', config('job-core.keyword') . ' for ' . $path->value)

@section('content')
    @include('partials.title', [
        'fa' => 'fa-user',
        'title' => $path->value,
        'subtitle' => config('job-core.keyword'),
          'link' => route('paths.show', ['path' => $path->slug])
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('paths.partials.paths')
            </div>
        </div>
    </div>
@endsection