@extends('layouts.app')

@section('title', config('job-core.keyword') . ' That Travel')

@section('content')
    @include('partials.title', [
        'fa' => 'fa-plane',
        'title' => 'Travel',
        'link' => route('travels.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12">
                @include('travels.partials.chunk')
            </div>
        </div>
    </div>
@endsection