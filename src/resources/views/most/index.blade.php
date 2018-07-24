@extends('layouts.app')

@section('title', 'Six Figure ' . config('job-core.keyword'))

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-money',
        'title' => 'Six Figures',
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