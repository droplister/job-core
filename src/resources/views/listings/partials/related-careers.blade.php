@if($listing->relatedCareers()->exists())
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Career',
    ])
    @foreach($listing->relatedCareers()->get() as $career)
        @include('job-core::partials.p-tag', [
            'text' => $career->value,
            'link' => route('careers.show', ['career' => $career->slug]),
            'pt' => $loop->first ? 'pt-3' : 'pt-2',
            'pb' => $loop->last ? 'pb-4' : ''
        ])
    @endforeach
@endif