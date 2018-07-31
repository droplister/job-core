@if(count($children) > 0)
    @include('job-core::partials.h-tag', [
        'tag' => 'h6',
        'title' => 'Narrow by ' . title_case($parameter),
    ])
    @foreach($children as $child)
        @if($request->has($parameter) && $child->slug === $request->{$parameter})
            @include('job-core::partials.p-tag', [
                'text' => isset($child->title) ? $child->title : $child->value,
                'pt' => $loop->first ? 'pt-3' : 'pt-2',
                'pb' => $loop->last ? 'pb-4' : '',
            ])
        @else
            @include('job-core::partials.p-tag', [
                'text' => isset($child->title) ? $child->title : $child->value,
                'link' => route($route, [$parameter => $child->slug] + $request->except($parameter)),
                'pt' => $loop->first ? 'pt-3' : 'pt-2',
                'pb' => $loop->last ? 'pb-4' : '',
            ])
        @endif
    @endforeach
@endif