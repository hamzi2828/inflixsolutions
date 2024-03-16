<?php

namespace Plugin\TlcommerceCore\Http\Resources;

use Session;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id' => (int) $data->id,
                    'product_id' => (int) $data->product_id,
                    'name' => $data->product_details->translation('name', Session::get('api_locale')),
                    'permalink' => $data->product_details->permalink,
                    'variant' => $data->variant_id != null ? $this->decodeVariant($data->variant_id) : null,
                    'unit_price' => $data->unit_price,
                    'quantity' => $data->quantity,
                    'shipping_cost	' => $data->delivery_cost,
                    'tax' => $data->tax,
                    'image' => $data->image,
                    'return_status' => $data->returnStatus(),
                    'delivered_date' => $data->delivery_time != null ? $data->delivery_time : null,
                    'delivery_status' => $data->delivery_status,
                    'can_cancel' => $data->canCancel(),
                    'tracking_list' => $this->trackingList($data),
                    'shipping' => $data->shipping_rate_info != null ? $this->shippingRate($data->shipping_rate_info) : null,
                    'can_return' => $data->canReturn(),
                    'attachment' => $data->attachment != null ? getFilePath($data->attachment) : null,
                    'estimate_delivery_time' => $data->estimateDeliveryTime()
                ];
            })
        ];
    }

    public function trackingList($data)
    {
        return $data->product_tracking;
    }

    public function shippingRate($data)
    {
        if ($data->name != null) {
            $info = [];
            $info['name'] = $data->name;
            return $info;
        } else {
            $info = [];
            $info['name'] = $data->carrier->name;
            $info['via'] = $data->shippied_by();
            return $info;
        }
    }

    public function decodeVariant($variant)
    {
        return $variant;
    }
}
