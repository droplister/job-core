@extends('layouts.app')

@section('title', $career->value . ' (' . $career->code . ') - ' . config('job-core.keyword'))

@section('content')
    @include('partials.title', [
        'fa' => 'fa-graduation-cap',
        'title' => $career->value,
        'subtitle' => config('job-core.keyword'),
        'link' => route('careers.show', ['career' => $career->slug])
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('careers.partials.careers')
            </div>
        </div>
    </div>
@endsection