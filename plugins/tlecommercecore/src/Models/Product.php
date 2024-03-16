<?php

namespace Plugin\TlcommerceCore\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Plugin\TlcommerceCore\Models\Units;
use Plugin\TlcommerceCore\Models\ProductSeo;
use Plugin\TlcommerceCore\Models\ProductReview;
use Plugin\TlcommerceCore\Models\ProductHasTags;
use Plugin\TlcommerceCore\Models\ProductCodState;
use Plugin\TlcommerceCore\Models\OrderHasProducts;
use Plugin\TlcommerceCore\Models\ProductCodCities;
use Plugin\TlcommerceCore\Models\ProductCondition;
use Plugin\TlcommerceCore\Models\ProductHasColors;
use Plugin\TlcommerceCore\Models\ProductHasChoices;
use Plugin\TlcommerceCore\Models\ProductTranslation;
use Plugin\TlcommerceCore\Models\SingleProductPrice;
use Plugin\TlcommerceCore\Models\ProductCodCountries;
use Plugin\TlcommerceCore\Models\ProductShippingInfo;
use Plugin\TlcommerceCore\Models\VariantProductPrice;
use Plugin\TlcommerceCore\Models\ProductGalleryImages;
use Plugin\TlcommerceCore\Models\ProductHasCategories;
use Plugin\TlcommerceCore\Models\ProductHasChoiceOption;
use Plugin\TlcommerceCore\Repositories\SettingsRepository;
use Plugin\TlcommerceCore\Models\ProductColorVariantImages;
use Plugin\TlcommerceCore\Models\ProductVariationCombination;

class Product extends Model
{
    protected $table = "tl_com_products";
    protected $fillable = ['slug'];

    public function translation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $product_translations = $this->product_translations->where('lang', $lang)->first();
        return $product_translations != null ? $product_translations->$field : $this->$field;
    }

    public function product_translations()
    {
        return $this->hasMany(ProductTranslation::class, 'product_id');
    }
    public function product_categories()
    {
        return $this->hasMany(ProductHasCategories::class, 'product_id');
    }
    public function brand_info()
    {
        return $this->belongsTo(ProductBrand::class, 'brand');
    }
    public function single_price()
    {
        return $this->belongsTo(SingleProductPrice::class, 'id', 'product_id');
    }

    public function variations()
    {
        return $this->hasMany(VariantProductPrice::class, 'product_id');
    }

    public function choices()
    {
        return $this->hasMany(ProductHasChoices::class, 'product_id');
    }

    public function choice_options()
    {
        return $this->hasMany(ProductHasChoiceOption::class, 'product_id');
    }
    public function color_choices()
    {
        return $this->hasMany(ProductHasColors::class, 'product_id');
    }

    public function variant_combination()
    {
        return $this->hasMany(ProductVariationCombination::class, 'product_id');
    }

    public function shipping_info()
    {
        return $this->belongsTo(ProductShippingInfo::class, 'id', 'product_id');
    }
    public function gallery_images()
    {
        return $this->hasMany(ProductGalleryImages::class, 'product_id');
    }

    public function tags()
    {
        return $this->hasMany(ProductHasTags::class, 'product_id');
    }

    public function color_images()
    {
        return $this->hasMany(ProductColorVariantImages::class, 'product_id');
    }

    public function cod_countries()
    {
        return $this->hasMany(ProductCodCountries::class, 'product_id');
    }

    public function cod_states()
    {
        return $this->hasMany(ProductCodState::class, 'product_id');
    }

    public function cod_cities()
    {
        return $this->hasMany(ProductCodCities::class, 'product_id');
    }

    public function product_seo()
    {
        return $this->belongsTo(ProductSeo::class, 'id', 'product_id');
    }

    public function unit_info()
    {
        return $this->hasOne(Units::class, 'id', 'unit');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }
    public function product_condition()
    {
        return $this->belongsTo(ProductCondition::class, 'conditions');
    }

    public function getTotalSaleAttribute()
    {

        return $this->hasMany(OrderHasProducts::class, 'product_id', 'id')->sum('quantity');
    }

    public function orders()
    {
        return $this->hasMany(OrderHasProducts::class, 'product_id', 'id');
    }

    public function getAvgRatingAttribute()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id')->avg('rating');
    }

    public function shippingProfile()
    {
        return $this->belongsTo(ShippingProfileProducts::class, 'id', 'product_id');
    }

    public function applicableDiscount()
    {
        $discount = [];
        $is_discount_applicable = Cache::remember('is-product-discount-applicable', 60 * 60, function () {
            return SettingsRepository::getEcommerceSetting('enable_product_discount') == config('settings.general_status.active');
        });
        if ($is_discount_applicable) {
            $has_deal = $this->hasFlashDeal();
            if ($has_deal != null) {
                $discount['discount_amount'] = $has_deal['amount'];
                $discount['discountType'] = $has_deal['discount_type'];
            } else {
                $discount['discount_amount'] = $this->discount_amount;
                $discount['discountType'] = $this->discount_type;
            }
        }

        return $discount;
    }

    public function hasFlashDeal()
    {
        if (isActivePluging('flashdeal')) {
            $deal_discount = \Plugin\Flashdeal\Models\FlashDealProducts::with(['deal.deal_translations'])
                ->where('product_id', $this->id)
                ->first();

            if ($deal_discount != null && $deal_discount->isExpired() == config('settings.general_status.in_active')) {
                $discount['amount'] = $deal_discount->discount;
                $discount['discount_type'] = $deal_discount->discount_type;
                $discount['deal_title'] = $deal_discount->deal->translation('title', session()->get('api_locale'));
                $discount['end_date'] = $deal_discount->deal->end_date;
                return $discount;
            }
        }

        return null;
    }
}
