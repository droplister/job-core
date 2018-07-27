@extends('job-core::layouts.app')

@section('title', config('job-core.keyword') . ' for the ' . $agency->value)
@if($agency->description)
    @section('description', $listings->total() . ' ' . config('job-core.keyword') . ' for the ' . $agency->value . '. ' . str_limit(strip_tags($agency->description), 150))
@elseif($listings->total() > 3)
    @section('description', $listings->total() . ' ' . config('job-core.keyword') . ' for the ' . $agency->value . ', including ' . explode(', ', $listings[0]->position_title)[0] . ', ' . explode(', ', $listings[1]->position_title)[0] . ', and ' . explode(', ', $listings[2]->position_title)[0] . '. Find the one that is best suited to you on ' . config('job-core.domain') . '.')
@else
    @section('description', $listings->total() . ' ' . config('job-core.keyword') . ' for the ' . $agency->value . '. Find the one that is best suited to you on ' . config('job-core.domain') . '.')
@endif

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-university',
        'title' => $agency->value,
        'subtitle' => config('job-core.keyword'),
        'link' => route('agencies.show', ['agency' => $agency->slug])
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::listings.partials.listings')
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::agencies.partials.agencies')
            </div>
        </div>
    </div>
    @if($agency->description)
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <div class="row">
                <div class="col-12 col-md-9">
                    @include('job-core::agencies.partials.agency')
                </div>
            </div>
        </div>
    @endif
@endsection