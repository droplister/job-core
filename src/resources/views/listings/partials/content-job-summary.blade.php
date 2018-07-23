@if($listing->job_summary)
    @include('partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Job Summary'
    ])
    @foreach($listing->chunkParagraphs($listing->job_summary) as $paragraph)
        @include('partials.p-tag', [
            'text' => $paragraph,
            'pb' => $loop->last ? 'pb-4' : 'pb-0',
        ])
    @endforeach
@endif