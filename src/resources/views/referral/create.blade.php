@extends('job-core::layouts.app')

@section('title', 'Referral')

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-envelope-o',
        'title' => 'Referral',
        'link' => route('referral.create')
    ])
    @include('job-core::partials.session')
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::referral.partials.form')
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::partials.referral')
            </div>
        </div>
    </div>
@endsection