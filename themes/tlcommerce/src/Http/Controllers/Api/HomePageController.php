<?php

namespace Theme\TLCommerce\Http\Controllers\Api;

use Core\Models\TlBlog;
use Illuminate\Http\Request;
use Core\Models\TlBlogsCategory;
use App\Http\Controllers\Controller;
use Plugin\TlcommerceCore\Models\Product;
use Theme\TLCommerce\Models\HomePageSection;

use Theme\TLCommerce\Http\Resources\BlogsResource;

use Theme\TLCommerce\Http\Resources\DealResource;;

use Theme\TLCommerce\Http\Resources\CollectionResource;
use Theme\TLCommerce\Http\Resources\HomePageSectionResource;

class HomePageController extends Controller
{
    /**
     * Will return active home page sections
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function homePageSections()
    {
        $sections = HomePageSection::where('status', config('settings.general_status.active'))
            ->orderBy('ordering', 'ASC')
            ->get();
        return (new HomePageSectionResource($sections));
    }
    /**
     * Will return deals Details
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dealsDetails(Request $request)
    {
        try {
            $data = \Plugin\Flashdeal\Models\FlashDeal::with('products')->where('id', $request['id'])->first();
            $dealsDetails = new DealResource($data);
            $products = new \Plugin\TlcommerceCore\Http\Resources\ProductCollection($data->products()->take(6)->get());
            return response()->json(
                [
                    'success' => true,
                    'dealsDetails' => $dealsDetails,
                    'products' => $products
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        } catch (\Error $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
    /**
     * Will return deal products
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dealProducts(Request $request)
    {
        $product_ids = \Plugin\Flashdeal\Models\FlashDealProducts::where('deal_id', $request['id'])->pluck('product_id');
        $products = Product::whereIn('id', $product_ids)->where('status', config('settings.general_status.active'))->get()->take(6);
        return new \Plugin\TlcommerceCore\Http\Resources\ProductCollection($products);
    }
    /**
     * Will return collection details
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function collectionDetails(Request $request)
    {
        try {
            $data = \Plugin\TlcommerceCore\Models\ProductCollection::findOrFail($request['id']);
            $details = new CollectionResource($data);
            $product_ids = \Plugin\TlcommerceCore\Models\CollectionHasProducts::where('collection_id', $request['id'])->pluck('product_id');
            $products = Product::whereIn('id', $product_ids)->where('status', config('settings.general_status.active'))->get()->take(6);
            $collection_products = new \Plugin\TlcommerceCore\Http\Resources\ProductCollection($products);
            return response()->json(
                [
                    'success' => true,
                    'details' => $details,
                    'collection_products' => $collection_products
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        } catch (\Error $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
    /**
     * Will return collections all products
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function collectionAllProducts(Request $request)
    {
        $product_ids = \Plugin\TlcommerceCore\Models\CollectionHasProducts::where('collection_id', $request['id'])->pluck('product_id');
        $products = Product::whereIn('id', $product_ids)->where('status', config('settings.general_status.active'))->paginate($request['perPage']);
        return new \Plugin\TlcommerceCore\Http\Resources\ProductCollection($products);
    }

    /**
     * Will return home page blogs
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function homePageBlogs(Request $request)
    {

        try {
            $blogs = [];
            if ($request->has('content')) {
                if ($request['content'] == 'latest') {
                    $blogs = TlBlog::where([
                            ['publish_at', '<', currentDateTime()],
                            ['is_publish', '=', config('settings.blog_status.publish')],
                        ])
                        ->orderBy('id', 'DESC')
                        ->take($request['quantity'])
                        ->get();
                }
                if ($request['content'] == 'featured') {
                    $blogs = TlBlog::where([
                            ['publish_at', '<', currentDateTime()],
                            ['is_publish', '=', config('settings.blog_status.publish')],
                        ])
                        ->where('is_featured', config('settings.general_status.active'))
                        ->orderBy('id', 'DESC')
                        ->take($request['quantity'])
                        ->get();
                }

                if ($request['content'] == 'category' && $request->has('category')) {
                    $blogs = TlBlog::where('is_publish', config('settings.general_status.active'))
                        ->whereIn('id', TlBlogsCategory::where('category_id', $request['category'])->pluck('blog_id'))
                        ->orderBy('id', 'DESC')
                        ->take($request['quantity'])
                        ->get();
                }
            }

            return new BlogsResource($blogs);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }
}
