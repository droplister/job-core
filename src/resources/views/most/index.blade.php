@extends('job-core::layouts.app')

@section('title', config('job-core.most_page_title'))

@section('content')
    @include('job-core::partials.title', [
        'fa' => config('job-core.most_icon'),
        'title' => config('job-core.most_title'),
        'subtitle' => config('job-core.keyword'),
         'link' => route('most.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::careers.partials.careers')
            </div>
        </div>
    </div>
@endsection