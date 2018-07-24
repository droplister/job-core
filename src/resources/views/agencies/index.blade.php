@extends('layouts.app')

@section('title', config('job-core.keyword') . ' by Agency')

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-university',
        'title' => 'Agencies',
        'link' => route('agencies.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            @foreach($chunks as $chunk)
                <div class="col-12 col-md-4 pb-4">
                    @foreach($chunk as $agency)
                        @include('job-core::agencies.partials.chunk')
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection