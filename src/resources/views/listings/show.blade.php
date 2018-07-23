@extends('layouts.app')

@section('title', $listing->title)
@section('description', $listing->description)

@section('content')
    @include('partials.title', [
        'fa' => 'fa-user-plus',
        'title' => $listing->position_title,
        'subtitle' => $listing->subtitle,
        'link' => route('listings.show', ['listing' => $listing->slug])
    ])
    @include('listings.partials.apply-button', [
        'class' => 'd-md-none mt-3'
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        @include('listings.partials.attributes')
        <div class="row">
            <div class="col-12 col-md-9">
                @include('listings.partials.content')
                <div class="row">
                    <div class="col-12 col-md-6 offset-md-3 mt-1 mb-4">
                        @include('listings.partials.apply-button', [
                            'extra' => true
                        ])
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                @include('listings.partials.related')
            </div>
        </div>
    </div>
    @if($agency = $listing->relatedAgencies()->hasDescription()->first())
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <div class="row">
                <div class="col-12 col-md-9">
                    @include('agencies.partials.agency', compact('agency'))
                </div>
            </div>
        </div>
    @endif
    @if(count($listings))
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <div class="row">
                <div class="col-md-9">
                    @include('listings.partials.listings')
                </div>
            </div>
        </div>
    @endif
@endsection