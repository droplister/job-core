@include('job-core::partials.h-tag', [
    'tag' => 'h2',
    'class' => 'h6',
    'title' => $location->name,
])
@if(\Request::route()->getName() === 'listings.show' && strlen($location->description) > 1000)
    @include('job-core::partials.p-tag', [
        'text' => str_limit(strip_tags($location->description), 1000),
        'pb' => 'pb-3 border-bottom border-gray',
    ])
@else
    @foreach($location->chunkParagraphs($location->description) as $paragraph)
        @include('job-core::partials.p-tag', [
            'text' => $paragraph,
            'pb' => $loop->last ? 'pb-3 border-bottom border-gray' : 'pb-0',
        ])
    @endforeach
@endif
<small class="d-block text-right mt-3">
    <a href="{{ route('locations.show', ['location' => $location->slug]) }}">
        <i class="fa fa-user"></i> All Jobs
    </a>
</small>