@extends('job-core::layouts.app')

@section('title', config('job-core.keyword_root') . ' Careers')

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-graduation-cap',
        'title' => 'Careers',
        'link' => route('careers.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            @foreach($chunks as $nested_chunk)
                <div class="col-12 col-md-4 pb-4">
                    @foreach($nested_chunk as $chunk)
                        @include('job-core::careers.partials.chunk')
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection