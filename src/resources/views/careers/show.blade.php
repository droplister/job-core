@extends('job-core::layouts.app')

@section('title', $career->value . ' (' . $career->code . ') - ' . config('job-core.keyword'))
@section('description', 'Browse from the over ' . number_format($listings->total()) . ' ' . $career->value . ' career opportunities available today within the U.S. Federal Government.')

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-graduation-cap',
        'title' => $career->value,
        'subtitle' => config('job-core.keyword'),
        'link' => route('careers.show', ['career' => $career->slug])
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