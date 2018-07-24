@if($listing->qualification_summary)
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Qualifications'
    ])
    @foreach($listing->chunkParagraphs($listing->qualification_summary) as $paragraph)
        @include('job-core::partials.p-tag', [
            'text' => $paragraph,
            'pb' => $loop->last ? 'pb-4' : 'pb-0',
        ])
    @endforeach
@endif