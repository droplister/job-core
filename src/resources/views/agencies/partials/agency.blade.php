@include('job-core::partials.h-tag', [
    'tag' => 'h2',
    'class' => 'h6',
    'title' => $agency->value,
])
@if(\Request::route()->getName() === 'listings.show')
    @include('job-core::partials.p-tag', [
        'text' => str_limit(strip_tags($agency->description), 500),
        'pb' => 'pb-3 border-bottom border-gray',
    ])
    <small class="d-block text-right mt-3">
        <a href="{{ route('agencies.show', ['agency' => $agency->slug]) }}">
            <i class="fa fa-university"></i> All Jobs
        </a>
    </small>
@else
    @foreach($agency->chunkParagraphs($agency->description) as $paragraph)
        @include('job-core::partials.p-tag', [
            'text' => $paragraph,
            'pb' => $loop->last ? 'pb-3 border-bottom border-gray' : 'pb-0',
        ])
    @endforeach
    @if($agency->url)
        <small class="d-block text-right mt-3">
            <a href="{{ $agency->url }}" target="_blank">
                <i class="fa fa-external-link"></i> Website
            </a>
        </small>
    @else
        <br />
    @endif
@endif