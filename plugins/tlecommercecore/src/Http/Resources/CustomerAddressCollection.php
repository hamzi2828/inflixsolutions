<?php

namespace Plugin\TlcommerceCore\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerAddressCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id'          => (int) $data->id,
                    'name'        => $data->name,
                    'address'     => $data->address,
                    'phone_code'  => '',
                    'phone'       => $data->phone,
                    'status'      => $data->status == config('settings.general_status.active') ? 'Active' : 'Inactive',
                    'country'     => $data->country,
                    'state'       => $data->state,
                    'city'        => $data->city,
                    'postal_code' => $data->postal_code,
                    'default_shipping' => $data->default_shipping,
                    'default_billing' => $data->default_billing
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
