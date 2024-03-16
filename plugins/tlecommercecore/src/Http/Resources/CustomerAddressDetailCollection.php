<?php

namespace Plugin\TlcommerceCore\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerAddressDetailCollection extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'address'    => $this->address,
            'phone'      => $this->phone,
            'phone_code' => '',
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'status' => $this->status,
            'default_shipping' => $this->default_shipping,
            'default_billing' => $this->default_billing,
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
