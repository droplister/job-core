@extends('layouts.app')

@section('title', $plan->value)

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-list',
        'title' => $plan->value,
        'subtitle' => config('job-core.keyword'),
          'link' => route('plans.show', ['plan' => $plan->slug])
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::plans.partials.plans')
            </div>
        </div>
    </div>
@endsection