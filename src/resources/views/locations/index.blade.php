@extends('job-core::layouts.app')

@section('title', config('job-core.keyword') . ' in the United States')

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-map',
        'title' => 'Browse by State',
        'link' => route('locations.index')
    ])
    <div class="my-3">
        <google-map
            v-bind:lat="{{ $google_map['lat'] }}"
            v-bind:lng="{{ $google_map['lng'] }}"
            v-bind:zoom="{{ $google_map['zoom'] }}"
        >
        </google-map>
    </div>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            @foreach($chunks as $chunk)
                <div class="col-12 col-md-3 pb-4">
                    @foreach($chunk as $location)
                        @include('job-core::locations.partials.chunk')
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection