@extends('layouts.app')

@section('title', 'Hiring for ' . config('job-core.keyword'))

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-user',
        'title' => 'Paths',
        'link' => route('paths.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12">
                @include('job-core::paths.partials.chunk')
            </div>
        </div>
    </div>
@endsection