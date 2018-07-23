<?php

namespace Droplister\JobCore\App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class GoogleMapResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'title' => $this->title,
            'url' => route('locations.show', ['listing' => $this->slug]),
            'position' => [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude,
            ],
            'listings_count' => $this->listings_count,
        ];
    }
}
