<?php

namespace Theme\TLCommerce\Http\Resources;

use Core\Models\ThemeTranslations;
use Illuminate\Support\Facades\DB;
use Plugin\TlcommerceCore\Models\Product;
use Plugin\TlcommerceCore\Models\ProductCategory;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Plugin\TlcommerceCore\Http\Resources\TopCategoryCollection;

class HomePageSectionResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id' => $data->id,
                    'layout' => getHomePageSectionProperties($data->id, 'layout'),
                    'content' => getHomePageSectionProperties($data->id, 'content'),
                    'properties' => $this->getProperties($data->section_properties)
                ];
            })
        ];
    }
    public function getProperties($data)
    {
        $modified_data = $data->map(
            function ($item) {
                if ($item->key_name == 'bg_image' || $item->key_name == 'cta_image') {
                    return [
                        $item->key_name => getFilePath($item->key_value, false),
                    ];
                }
                if ($item->key_name == 'product_id') {
                    $product = Product::where('id', $item->key_value)->select('permalink')->first();
                    return [
                        'product_details' => $product,
                    ];
                }
                //Translate
                if ($item->key_name == 'meta_title' || $item->key_name == 'title' || $item->key_name == 'btn_title' || $item->key_name == 'featured_title') {
                    return [
                        $item->key_name => $this->themeTranslations($item->key_value),
                    ];
                }

                if ($item->key_name == 'layout' && $item->key_value == 'category_slider') {
                    $categories = ProductCategory::where('parent', NULL)->where('status', config('settings.general_status.active'))->orderBy('id', 'ASC')->get();
                    return [
                        'categories' => new TopCategoryCollection($categories),
                    ];
                }

                if ($item->key_name == 'layout' && $item->key_value == 'custom_product_section') {
                    $category_info = ProductCategory::where('id', getHomePageSectionProperties($item->section_id, 'category'))->first();
                    $products = $this->customSectionProducts($item);
                    $data['category_info'] = $category_info != null ? new \Plugin\TlcommerceCore\Http\Resources\SingleCategoryCollection($category_info) : null;
                    $data['products'] =  new \Plugin\TlcommerceCore\Http\Resources\ProductCollection($products);
                    return [
                        $data
                    ];
                }
                if ($item->key_name == 'layout' && $item->key_value == 'ads') {
                    $ads = $this->AdsSectionContent($item);
                    return [
                        'ads' =>  $ads,
                    ];
                }

                return [
                    $item->key_name => $item->key_value,
                ];
            }
        );
        $newArr = array_reduce($modified_data->toArray(), function ($carry, $item) {
            $carry[key($item)] = reset($item);
            return $carry;
        });
        return $newArr;
    }

    public function AdsSectionContent($item)
    {
        $ads = [];
        $content = getHomePageSectionProperties($item->section_id, 'content');
        $options = explode('_', $content);
        foreach ($options as $key => $option) {
            $image_key = $key + 1 . '_' . $option . '_image';
            $url_key = $key + 1 . '_' . $option . '_url';
            $data['image'] = getFilePath(getHomePageSectionProperties($item->section_id, $image_key), false);
            $data['url'] = getHomePageSectionProperties($item->section_id, $url_key);
            $data['column'] = $option;
            array_push($ads, $data);
        }
        return $ads;
    }

    public function customSectionProducts($item)
    {
        $products = [];
        $content = getHomePageSectionProperties($item->section_id, 'content');
        if ($content == 'new_arrival') {
            $products = Product::where('status', config('settings.general_status.active'))->orderBy('id', 'DESC')->take(6)->get();
        }
        if ($content == 'featured') {
            $products = Product::where('status', config('settings.general_status.active'))
                ->where('is_featured', config('settings.general_status.active'))
                ->orderBy('id', 'DESC')
                ->take(6)->get();
        }
        if ($content == 'top_selling') {
            $products = Product::withCount(['orders as total_sales' => function ($query) {
                $query->select(DB::raw('coalesce(sum(quantity),0)'));
            }])->orderByDesc('total_sales')
                ->where('status', config('settings.general_status.active'))
                ->take(6)
                ->get();
        }
        if ($content == 'top_reviewed') {
            $products = Product::withCount(['reviews as average_rating' => function ($query) {
                $query->select(DB::raw('coalesce(avg(rating),0)'));
            }])->orderByDesc('average_rating')
                ->where('status', config('settings.general_status.active'))
                ->take(6)
                ->get();
        }
        if ($content == 'category') {
            $category_id = getHomePageSectionProperties($item->section_id, 'category');
            $products = Product::whereHas('product_categories', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            })
                ->where('status', config('settings.general_status.active'))
                ->take(6)
                ->get();
        }
        return $products;
    }

    public function themeTranslations($lang_key)
    {
        $active_theme = getActiveTheme();
        $lang_value = ThemeTranslations::where('lang', session()->get('api_locale'))
            ->where('theme', $active_theme->location)
            ->where('lang_key', $lang_key)
            ->select('lang_value')
            ->first();
        if ($lang_value != null) {
            return $lang_value->lang_value;
        }

        return $lang_key;
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
