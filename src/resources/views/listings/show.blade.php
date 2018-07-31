@extends('job-core::layouts.app')

@section('title', $listing->pageTitle)
@section('description', $listing->pageDescription)

@section('content')
    @include('job-core::partials.title', [
        'fa' => 'fa-user-plus',
        'title' => $listing->title,
        'subtitle' => $listing->subtitle,
        'link' => route('listings.show', ['listing' => $listing->slug])
    ])
    @include('job-core::listings.partials.apply-button', [
        'class' => 'd-md-none mt-3'
    ])
    <div class="my-3 p-3 bg-white rounded box-shadow">
        @include('job-core::listings.partials.attributes')
        @include('job-core::partials.adsense', ['class' => 'd-block d-md-none mb-4'])
        <div class="row">
            <div class="col-12 col-md-9">
                @include('job-core::listings.partials.content')
                <div class="row">
                    <div class="col-12 col-md-6 offset-md-3 mt-1 mb-4">
                        @include('job-core::listings.partials.apply-button', [
                            'extra' => true
                        ])
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                @include('job-core::listings.partials.related')
            </div>
        </div>
    </div>
    @if($agency = $listing->relatedAgencies()->hasDescription()->first())
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <div class="row">
                <div class="col-12 col-md-9">
                    @include('job-core::agencies.partials.agency', compact('agency'))
                </div>
            </div>
        </div>
    @elseif($location = $listing->relatedLocations()->hasDescription()->first())
        @if($listing->relatedLocations()->count() === 1)
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <div class="row">
                    <div class="col-12 col-md-9">
                        @include('job-core::locations.partials.location', compact('location'))
                    </div>
                </div>
            </div>
        @endif
    @endif
    @if(count($listings))
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <div class="row">
                <div class="col-md-9">
                    @include('job-core::listings.partials.listings')
                </div>
            </div>
        </div>
    @endif
@endsection