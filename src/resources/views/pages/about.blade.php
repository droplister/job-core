@extends('layouts.app')

@section('title', 'About ' . config('job-core.domain'))

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-question-circle',
        'title' => 'About',
        'link' => route('pages.about')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
            </div>
            <div class="col-12 col-md-3">
            </div>
        </div>
    </div>
@endsection