@extends('layouts.app')

@section('title', config('job-core.keyword_root') . ' Job Schedules')

@section('content')
    @include('partials.title', [
        'fa' => 'fa-list',
        'title' => 'Schedules',
        'link' => route('schedules.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12">
                @include('schedules.partials.chunk')
            </div>
        </div>
    </div>
@endsection