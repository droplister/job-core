<div class="row">
    <div class="col-6 col-md-3">
        @include('listings.partials.attribute', [
            'title' => 'Pay Range',
            'text' => $listing->pay_range
        ])
    </div>
    <div class="col-6 col-md-3">
         @include('listings.partials.attribute', [
            'title' => 'Clearance',
            'text' => isset($listing->clearances[0]) ? $listing->clearances[0]->value : 'Unknown'
        ])
    </div>
    <div class="col-3 d-none d-md-inline-block">
         @include('listings.partials.attribute', [
            'title' => 'Travel %',
            'text' => $listing->travel->value
        ])
    </div>
    <div class="col-3 d-none d-md-inline-block">
        @include('listings.partials.apply-button', [
            'extra' => true
        ])
    </div>
</div>
<div class="row">
    <div class="col-6 col-md-3">
          @include('listings.partials.attribute', [
            'title' => 'Job Grade',
            'text' => $listing->job_grade
        ])
    </div>
    <div class="col-6 col-md-3">
           @include('listings.partials.attribute', [
            'title' => 'Schedule',
            'text' => $listing->position_schedule
        ])
    </div>
    <div class="col-6 col-md-3">
           @include('listings.partials.attribute', [
            'title' => 'Offering',
            'text' => $listing->position_offering_type
        ])
    </div>
    <div class="col-6 d-md-none">
           @include('listings.partials.attribute', [
            'title' => 'Published',
            'text' => $listing->publication_start_date->diffForHumans()
        ])
    </div>
</div>