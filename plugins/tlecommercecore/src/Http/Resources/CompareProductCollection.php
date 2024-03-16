<?php

namespace Plugin\TlcommerceCore\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Plugin\TlcommerceCore\Models\ProductCategory;
use Session;

class CompareProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id' => (int) $data->id,
                    'has_variant' => (int) $data->has_variant,
                    'name' => $data->translation('name', Session::get('api_locale')),
                    'slug' => $data->permalink,
                    'thumbnail_image' => getFilePath($data->thumbnail_image),
                    'base_price' => (float) $this->base_price($data),
                    'price' => $data->discount_amount != null && $data->discount_amount > 0 ? (float) $this->price($data) : (float)$this->base_price($data),
                    'discount' => (float) $data->discount_amount,
                    'discount_amount_type' => $data->discount_type,
                    'quantity' => (float) $this->stock($data),
                    'unit' => $data->unit_info != null ? $data->unit_info->translation('name', Session::get('api_locale')) : null,
                    'min_qty' => $data->min_item_on_purchase != null ? $data->min_item_on_purchase : 0,
                    'max_qty' => $data->max_item_on_purchase != null ? $data->max_item_on_purchase : 0,
                    'avg_rating' => $this->avgRating($data),
                    'summary' => $data->translation('summary', Session::get('api_locale')),
                    'is_authentic' => $data->is_authentic === config('settings.general_status.active') ? translate('100% Authentic', Session::get('api_locale')) : translate('Not authentic', session::get('api_locale')),
                    'is_active_cod' => $data->is_active_cod === config('settings.general_status.active') ? translate('Available', Session::get('api_locale')) : translate('Not available', session::get('api_locale')),
                    'is_refundable' => $data->is_refundable === config('settings.general_status.active') ? translate('Available', Session::get('api_locale')) : translate('Not available', session::get('api_locale')),
                    'has_warranty' => $data->has_warranty === config('settings.general_status.active') ? translate('Available', Session::get('api_locale')) : translate('Not available', session::get('api_locale')),
                    'category' => $data->product_categories != null ? $this->categories($data->product_categories) : null,
                    'brand' => $data->brand_info != null ? $data->brand_info->translation('name', Session::get('api_locale')) : null
                ];
            })
        ];
    }

    public function categories($data)
    {
        $items = [];
        foreach ($data as $item) {
            $cat_info = ProductCategory::find($item['category_id']);
            if ($cat_info != null) {
                $name = $cat_info->translation('name', Session::get('api_locale'));
                array_push($items, $name);
            }
        }
        return implode(', ', $items);
    }

    public function avgRating($data)
    {
        $avg = $data->reviews->count() > 0 ? $data->reviews->avg('rating') : .000001;
        return $avg;
    }
    public function base_price($data)
    {
        if ($data->has_variant == config('tlecommercecore.product_variant.single')) {
            return $data->single_price != null ? $data->single_price->unit_price : 0;
        } else {
            return $data->variations != null ? $data->variations[0]->unit_price : 0;
        }
    }


    public function price($data)
    {
        $applicable_discount = $data->applicableDiscount();
        $base_price = 0;
        $discount = 0;
        //Base price
        if ($data->has_variant == config('tlecommercecore.product_variant.single')) {
            $base_price = $data->single_price != null ? $data->single_price->unit_price : 0;
        } else {
            $base_price = $data->variations != null ? $data->variations[0]->unit_price : 0;
        }
        //Calculate discount
        if ($applicable_discount != null && $applicable_discount['discount_amount'] > 0) {
            if ($applicable_discount['discountType'] == config('tlecommercecore.amount_type.flat')) {
                $discount = $applicable_discount['discount_amount'];
            } else {
                $discount = ($base_price * $applicable_discount['discount_amount']) / 100;
            }
        }
        return $base_price - $discount;
    }


    public function stock($data)
    {
        if ($data->has_variant == config('tlecommercecore.product_variant.single')) {
            return $data->single_price != null ? $data->single_price->quantity : 0;
        } else {
            return $data->variations != null ? array_reduce($data->variations->toArray(), function ($qty, $item) {
                $qty += $item['quantity'];
                return $qty;
            }) : 0;
        }
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
