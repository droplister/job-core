@extends('job-core::layouts.app')

@section('title', $level->value . ' ' . config('job-core.keyword'))

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-info-circle',
        'title' => $level->value,
        'subtitle' => config('job-core.keyword'),
        'link' => route('levels.show', ['level' => $level->slug])
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::levels.partials.levels')
            </div>
        </div>
    </div>
@endsection