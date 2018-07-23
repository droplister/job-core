@extends('layouts.app')

@section('title', config('job-core.keyword') . ' for the ' . $agency->value)

@section('content')
    @include('partials.title', [
        'fa' => 'fa-university',
        'title' => $agency->value,
        'subtitle' => config('job-core.keyword'),
        'link' => route('agencies.show', ['agency' => $agency->slug])
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('agencies.partials.agencies')
            </div>
        </div>
    </div>
    @if($agency->description)
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <div class="row">
                <div class="col-12 col-md-9">
                    @include('agencies.partials.agency')
                </div>
            </div>
        </div>
    @endif
@endsection