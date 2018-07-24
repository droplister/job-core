@extends('job-core::layouts.app')

@section('title', 'Advertise')

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-info-circle',
        'title' => 'Advertise',
        'link' => route('pages.advertise')
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