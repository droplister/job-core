<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($routes as $route)
   <url>
      <loc>{{ route($route) }}</loc>
   </url>
@endforeach
@foreach($agencies as $agency)
   <url>
      <loc>{{ route('agencies.show', ['agency' => $agency->slug]) }}</loc>
   </url>
@endforeach
@foreach($locations as $location)
   <url>
      <loc>{{ route('locations.show', ['location' => $location->slug]) }}</loc>
   </url>
@endforeach
@foreach($careers as $career)
   <url>
      <loc>{{ route('careers.show', ['career' => $career->slug]) }}</loc>
   </url>
@endforeach
@foreach($listings as $listing)
   <url>
      <loc>{{ route('listings.show', ['listing' => $listing->slug]) }}</loc>
   </url>
@endforeach
</urlset> 