@extends('layouts.app')

@section('title', 'Security Clearance Levels')

@section('content')
    @include('partials.title', [
        'fa' => 'fa-info-circle',
        'title' => 'Levels',
        'link' => route('levels.index')
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12">
                @include('levels.partials.chunk')
            </div>
        </div>
    </div>
@endsection