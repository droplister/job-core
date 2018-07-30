@include('job-core::partials.h-tag', [
    'tag' => 'h2',
    'class' => 'h6',
    'title' => $location->name,
])
@if(\Request::route()->getName() === 'listings.show')
    @include('job-core::partials.p-tag', [
        'text' => strip_tags($location->description),
        'pb' => 'pb-3 border-bottom border-gray',
    ])
    <small class="d-block text-right mt-3">
        <a href="{{ route('locations.show', ['location' => $location->slug]) }}">
            <i class="fa fa-user"></i> All Jobs
        </a>
    </small>
@else
    @foreach($location->chunkParagraphs($location->description) as $paragraph)
        @include('job-core::partials.p-tag', [
            'text' => $paragraph,
            'pb' => $loop->last ? 'pb-3 border-bottom border-gray' : 'pb-0',
        ])
    @endforeach
    <br />
@endif