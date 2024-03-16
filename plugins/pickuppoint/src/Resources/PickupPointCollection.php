<?php

namespace Plugin\PickupPoint\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PickupPointCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id' => (int) $data->id,
                    'name' => $data->name,
                    'location' => $data->location,
                    'phone' => $data->phone,
                    'zone_id' => $data->zoneInfo != null ? $data->zoneInfo->id : null,
                    'zone_name' => $data->zoneInfo != null ? $data->zoneInfo->name : null
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
