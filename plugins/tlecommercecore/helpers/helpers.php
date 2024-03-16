<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Plugin\TlcommerceCore\Models\Cities;
use Plugin\TlcommerceCore\Models\ProductHasTaxs;

if (!function_exists('getAllProductCategories')) {
    /**
     * return all product categories
     *
     * @return String
     */
    function getAllProductCategories()
    {
        $all_product_cat = DB::table('tl_com_categories')
            ->where([
                ['tl_com_categories.status', '=', config('settings.general_status.active')]
            ])
            ->orderBy('tl_com_categories.id', 'desc')
            ->select([
                'tl_com_categories.id',
                'tl_com_categories.name',
                'tl_com_categories.permalink',
            ])->get();

        for ($i = 0; $i < sizeof($all_product_cat); $i++) {
            $permalink = $all_product_cat[$i]->permalink;
            $all_product_cat[$i]->permalink = "/products/category/" . $permalink;
            $all_product_cat[$i]->preview_url = URL::to('/') . '/products/category/' . $permalink;
        }
        return $all_product_cat;
    }
}
if (!function_exists('getAllRecentProductCategories')) {
    /**
     * return all recent product categories
     * @return String
     */
    function getAllRecentProductCategories()
    {
        $all_recent_product_cat = DB::table('tl_com_categories')
            ->where([
                ['tl_com_categories.status', '=', config('settings.general_status.active')]
            ])
            ->orderBy('tl_com_categories.id', 'desc')
            ->select([
                'tl_com_categories.id',
                'tl_com_categories.name',
                'tl_com_categories.permalink',
            ])->take(3)->get();

        for ($i = 0; $i < sizeof($all_recent_product_cat); $i++) {
            $permalink = $all_recent_product_cat[$i]->permalink;
            $all_recent_product_cat[$i]->permalink = "/products/category/" . $permalink;
            $all_recent_product_cat[$i]->preview_url = URL::to('/') . '/products/category/' . $permalink;
        }
        return $all_recent_product_cat;
    }
}
if (!function_exists('getAllProductTags')) {
    /**
     * return all product tags
     *
     * @return String
     */
    function getAllProductTags()
    {
        $all_product_tag = DB::table('tl_com_product_tags')
            ->where([
                ['tl_com_product_tags.status', '=', config('settings.general_status.active')]
            ])
            ->orderByDesc('tl_com_product_tags.id')
            ->select([
                'tl_com_product_tags.id',
                'tl_com_product_tags.name',
                'tl_com_product_tags.permalink'
            ])->get();

        for ($i = 0; $i < sizeof($all_product_tag); $i++) {
            $permalink = $all_product_tag[$i]->permalink;
            $all_product_tag[$i]->permalink = "/tags/" . $permalink;
            $all_product_tag[$i]->preview_url = URL::to('/') . '/tags/' . $permalink;
        }
        return $all_product_tag;
    }
}
if (!function_exists('getAllRecentProductTags')) {
    /**
     * return all recent product tags
     *
     * @return String
     */
    function getAllRecentProductTags()
    {
        $all_recent_product_tag = DB::table('tl_com_product_tags')
            ->where([
                ['tl_com_product_tags.status', '=', config('settings.general_status.active')]
            ])
            ->orderByDesc('tl_com_product_tags.id')
            ->select([
                'tl_com_product_tags.id',
                'tl_com_product_tags.name',
                'tl_com_product_tags.permalink'
            ])->take(3)->get();

        for ($i = 0; $i < sizeof($all_recent_product_tag); $i++) {
            $permalink = $all_recent_product_tag[$i]->permalink;
            $all_recent_product_tag[$i]->permalink = "/tags/" . $permalink;
            $all_recent_product_tag[$i]->preview_url = URL::to('/') . '/tags/' . $permalink;
        }
        return $all_recent_product_tag;
    }
}
if (!function_exists('getAllProductBrands')) {
    /**
     * return all product brands
     *
     * @return String
     */
    function getAllProductBrands()
    {
        $all_product_brand = DB::table('tl_com_brands')
            ->where([
                ['tl_com_brands.status', '=', config('settings.general_status.active')]
            ])
            ->orderByDesc('tl_com_brands.id')
            ->select([
                'tl_com_brands.id',
                'tl_com_brands.name',
                'tl_com_brands.permalink',
            ])->get();

        for ($i = 0; $i < sizeof($all_product_brand); $i++) {
            $permalink = $all_product_brand[$i]->permalink;
            $all_product_brand[$i]->permalink = "/brand/" . $permalink;
            $all_product_brand[$i]->preview_url = URL::to('/') . '/brand/' . $permalink;
        }
        return $all_product_brand;
    }
}
if (!function_exists('getAllRecentProductBrands')) {
    /**
     * return all recent product brands
     *
     * @return String
     */
    function getAllRecentProductBrands()
    {
        $all_recent_product_brand = DB::table('tl_com_brands')
            ->where([
                ['tl_com_brands.status', '=', config('settings.general_status.active')]
            ])
            ->orderByDesc('tl_com_brands.id')
            ->select([
                'tl_com_brands.id',
                'tl_com_brands.name',
                'tl_com_brands.permalink',
            ])->take(3)->get();

        for ($i = 0; $i < sizeof($all_recent_product_brand); $i++) {
            $permalink = $all_recent_product_brand[$i]->permalink;
            $all_recent_product_brand[$i]->permalink = "/brand/" . $permalink;
            $all_recent_product_brand[$i]->preview_url = URL::to('/') . '/brand/' . $permalink;
        }
        return $all_recent_product_brand;
    }
}

if (!function_exists('ProductTaxValue')) {
    /**
     * return product tax value 
     *
     * @param Int $product_id
     * @param Int $tax_id
     * @return String
     */

    function ProductTaxValue($product_id, $tax_id)
    {
        return ProductHasTaxs::Where('product_id', $product_id)->where('tax_id', $tax_id)->value('amount');
    }
}
if (!function_exists('currencyExchange')) {
    /**
     * Exchange currency
     *
     * 
     */
    function currencyExchange($value, $formatting = true, $target_currency_id = NULL)
    {
        //Get system currency
        $default_currency_details = Cache::rememberForever('default-currency-details', function () {
            $default_currency_id = Plugin\TlcommerceCore\Repositories\SettingsRepository::getEcommerceSetting('default_currency');
            return Plugin\TlcommerceCore\Models\Currency::find($default_currency_id);
        });

        //Convert to target currency
        if ($target_currency_id != null) {
            $target_currency = Plugin\TlcommerceCore\Models\Currency::where('id', $target_currency_id)->select('conversion_rate')->first();
            $converted_amount = ($value / $target_currency->conversion_rate) * $default_currency_details->conversion_rate;
            $value = $converted_amount;
        }

        //Formatting Currency 
        if ($default_currency_details != null) {
            if ($formatting) {
                $formatting_value = number_format($value, $default_currency_details->number_of_decimal, $default_currency_details->decimal_separator, $default_currency_details->thousand_separator);
                $position = $default_currency_details->position;

                switch ($position) {
                    case "1":
                        return $default_currency_details->symbol . '' . $formatting_value;
                        break;
                    case "2":
                        return $formatting_value . '' . $default_currency_details->symbol;
                        break;
                    case "3":
                        return $default_currency_details->symbol . ' ' . $formatting_value;
                        break;
                    case "4":
                        return $formatting_value . ' ' . $default_currency_details->symbol;
                        break;
                    default:
                        return $formatting_value;
                }
            } else {
                return $value;
            }
        } else {
            return $value;
        }
    }
}

if (!function_exists('currencySymbol')) {
    /**
     * Get currency symbol
     *
     * 
     */
    function currencySymbol()
    {
        $default_currency_id = Plugin\TlcommerceCore\Repositories\SettingsRepository::getEcommerceSetting('default_currency');
        $default_currency_details = Plugin\TlcommerceCore\Models\Currency::find($default_currency_id);
        if ($default_currency_details != null) {
            return $default_currency_details->symbol;
        } else {
            return '$';
        }
    }
}

if (!function_exists('getAllCities')) {
    /**
     * return all city 
     * 
     * @return String
     */

    function getAllCities()
    {
        return Cities::all();
    }
}
