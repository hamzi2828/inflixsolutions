<?php

namespace Plugin\TlcommerceCore\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Plugin\Coupon\Models\CouponProducts;
use Plugin\TlcommerceCore\Models\Cities;
use Plugin\TlcommerceCore\Models\States;
use Illuminate\Support\Facades\Validator;
use Plugin\TlcommerceCore\Models\Country;
use Plugin\TlcommerceCore\Models\Product;
use Plugin\TlcommerceCore\Models\ShippingRate;
use Plugin\Coupon\Models\CouponExcludeProducts;
use Plugin\TlcommerceCore\Models\ShippingZoneCities;
use Plugin\TlcommerceCore\Models\ProductHasCategories;
use Plugin\TlcommerceCore\Repositories\OrderRepository;
use Plugin\TlcommerceCore\Http\Resources\OrderCollection;
use Plugin\TlcommerceCore\Http\Requests\GuestCheckoutRequest;
use Plugin\TlcommerceCore\Http\Requests\ProductReturnRequest;
use Plugin\TlcommerceCore\Http\Resources\SingleOrderCollection;
use Plugin\TlcommerceCore\Repositories\PaymentMethodRepository;
use Plugin\TlcommerceCore\Http\Requests\AttachmentUploadRequest;
use Plugin\TlcommerceCore\Http\Resources\PaymentMethodCollection;
use Plugin\TlcommerceCore\Http\Resources\RefundRequestCollection;

class OrderController extends Controller
{
    protected $order_repository;
    protected $payment_method_repository;

    public function __construct(OrderRepository $order_repository, PaymentMethodRepository $payment_method_repository)
    {
        $this->order_repository = $order_repository;
        $this->payment_method_repository = $payment_method_repository;
    }
    /**
     * Will return checkout configuration
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkoutConfiguration()
    {
        $data = $this->order_repository->checkoutConfiguration();
        if ($data != NULL) {
            return response()->json(
                [
                    'success' => true,
                    'config' => $data
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }

    /**
     * Will uploads order attatchment
     * 
     * @param AttachmentUploadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadOrderAttachment(AttachmentUploadRequest $request)
    {
        $res = $this->order_repository->uploadAttachment($request);
        if ($res != null) {
            return response()->json(
                [
                    'success' => true,
                    'attatchment' => $res
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
    /**
     * Will remove order attachment
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeOrderAttachment(Request $request)
    {
        $res = removeMediaById($request['file_id']);
        if ($res) {
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json(
                [
                    'success' > false
                ]
            );
        }
    }
    /**
     * Will return active payment methods
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function activePaymentMethods()
    {
        try {
            return new PaymentMethodCollection($this->payment_method_repository->paymentMethods(config('settings.general_status.active')));
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }
    /**
     * Will return country list
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function countryList()
    {
        try {
            $countries = Country::where('status', config('settings.general_status.active'))->select('id', 'name', 'code')->get();
            return response()->json(
                [
                    'success' => true,
                    'countries' => $countries
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
    /**
     * Will return states of a country
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function countryStates(Request $request)
    {
        try {
            $states = States::where('country_id', $request['country_id'])
                ->select('name', 'id', 'code')
                ->where('status', config('settings.general_status.active'))
                ->get();
            return response()->json(
                [
                    'success' => true,
                    'states' => $states
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
    /**
     * Will return cities of a state
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stateCities(Request $request)
    {
        try {
            $cities = Cities::where('state_id', $request['state_id'])
                ->where('status', config('settings.general_status.active'))
                ->select('id', 'name')
                ->get();
            return response()->json(
                [
                    'success' => true,
                    'cities' => $cities
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }
    /**
     * Will get shipping options
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function shippingOptions(Request $request)
    {
        try {
            return response()->json($this->order_repository->shippingOptions($request));
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }
    /**
     * Will calculate Delivery Cost
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function shippingAvaiblityDeliveryCost(Request $request)
    {
        try {
            $shipping_zone = ShippingZoneCities::where('city_id', $request['location'])->first();

            return $shipping_zone;
            //return if selected location has no shipping zone
            if ($shipping_zone == null) {
                return response()->json(
                    [
                        'success' => true,
                        'shipiing_avaible' => false
                    ]
                );
            }

            $shipping_rates = ShippingRate::where('zone_id', $shipping_zone->zone_id)->get();
            //return if zone has no shipping rate
            if (count($shipping_rates) < 1) {
                return response()->json(
                    [
                        'success' => true,
                        'shipiing_avaible' => false
                    ]
                );
            }
            //return if zone has single shhipping rate and rate has no condition
            if (count($shipping_rates) == 1 && $shipping_rates[0]->has_condition == config('settings.general_status.in_active')) {
                return response()->json(
                    [
                        'success' => true,
                        'shipiing_avaible' => true,
                        'standard_delivery_cost' => 10,
                        'express_delivery_cost' => $shipping_rates[0]->express_cost
                    ]
                );
            }

            $express_delivery_cost = 0;
            $standard_delivery_cost = 0;
            if ($request->has('location')) {
                $product_list = json_decode($request->products, true);
                foreach ($product_list as $product) {
                    $shippingAvailability = $this->order_repository->productShippingAvailability($product['id'], $request['location']);
                    if ($shippingAvailability) {
                        //calculate delivery cost
                        $standard_delivery_cost += $this->order_repository->productDeliveryCost($product['id'], $request['location']);
                        $express_delivery_cost += $this->order_repository->productDeliveryCost($product['id'], $request['location']);
                    } else {
                        //return if any product of cart is not available in selected location
                        return response()->json(
                            [
                                'success' => true,
                                'shipiing_avaible' => false
                            ]
                        );
                    }
                }

                return response()->json(
                    [
                        'success' => true,
                        'shipiing_avaible' => true,
                        'standard_delivery_cost' => 10,
                        'express_delivery_cost' => $express_delivery_cost
                    ]
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Invalid Location'
                    ]
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Invalid Location'
                ]
            );
        }
    }
    /**
     * Will apply coupon code
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->couponError('Enter a valid coupon');
        }
        try {
            //Plugin not activated
            if (!isActivePluging('coupon')) {
                return $this->couponError('Coupon not applicable right now');
            }

            //Coupon details
            $coupon_details = \Plugin\Coupon\Models\Coupons::where('code', $request['coupon_code'])->first();
            if ($coupon_details == null) {
                return $this->couponError('Coupon Not Found');
            }
            //check expire data
            $today = Carbon::now()->toDateString();
            if ($coupon_details->expire_date != null && $coupon_details->expire_date < $today) {
                return $this->couponError('Coupon is Expired');
            }

            //Check usage limit per coupon
            $per_coupon_usage = $coupon_details->usage_limit_per_coupon;
            if ($per_coupon_usage != null) {
                $previous_usage = \Plugin\Coupon\Models\CouponUsage::where('coupon_id', $coupon_details->id)->count();
                if ($previous_usage >= $per_coupon_usage) {
                    return $this->couponError('Crossed the limit of usage');
                }
            }
            //Check usage limit per user
            $coupon_usage_per_user = $coupon_details->usage_limit_per_user;
            if ($coupon_usage_per_user != null && $request['customer_id'] != null) {
                $previous_user_usage = \Plugin\Coupon\Models\CouponUsage::where('coupon_id', $coupon_details->id)
                    ->where('customer_id', $request['customer_id'])
                    ->count();
                if ($previous_user_usage >= $coupon_usage_per_user) {
                    return $this->couponError('You have crossed the limit of usage');
                }
            }

            $products = json_decode($request['products'], true);
            $total_cart_price = array_reduce($products, function ($sum, $item) {
                $sum += $item['unitPrice'] * $item['quantity'];
                return $sum;
            }, 0);

            //Minimum spend validation
            if ($coupon_details->minimum_spend_amount != null && $coupon_details->minimum_spend_amount > $total_cart_price) {
                return $this->couponError('You have to need more shopping to apply this coupon');
            }

            //Maximum spend validation
            if ($coupon_details->maximum_spend_mount != null && $coupon_details->maximum_spend_mount < $total_cart_price) {
                return $this->couponError('Coupon is not applicable');
            }


            $cart_items = array_map(function ($product) {
                return $product['id'];
            }, $products);

            $applicable_product_id = $cart_items;

            //Filter selected product
            $selected_products = CouponProducts::where('coupon_id', $coupon_details->id)->pluck('product_id')->toArray();
            if (count($selected_products) > 0) {
                $applicable_product_id = array_intersect($applicable_product_id, $selected_products);
                $applicable_product_id = array_values($applicable_product_id);
            }

            //Selected categories 
            $selected_categories = $coupon_details->categories->pluck('category_id');
            if (count($selected_categories) > 0) {
                $applicable_product_id = ProductHasCategories::whereIn('product_id', $cart_items)->whereIn('category_id', $selected_categories)->pluck('product_id');
            }

            //Selected Brand 
            $selected_brands = $coupon_details->brands->pluck('brand_id');
            if (count($selected_brands) > 0) {
                $applicable_product_id = Product::whereIn('id', $cart_items)->whereIn('brand', $selected_brands)->pluck('id');
            }


            //Filter exclude products
            $exclude_products = CouponExcludeProducts::where('coupon_id', $coupon_details->id)->pluck('product_id')->toArray();
            if (count($exclude_products) > 0) {
                $applicable_product_id = array_diff($cart_items, $exclude_products);
            }

            $discounted_amount = 0;
            //Flat Discount
            if ($coupon_details->discount_type == config('tlecommercecore.amount_type.flat')) {
                $discounted_amount = $coupon_details->discount_amount;
            }
            //Percent Discount
            if ($coupon_details->discount_type != config('tlecommercecore.amount_type.flat')) {
                $total_price = 0;
                foreach ($products as $item) {
                    foreach ($applicable_product_id as $productId) {
                        if ($productId == $item['id']) {
                            $temp = $item['unitPrice'] * $item['quantity'];
                            $total_price += $temp;
                        }
                    }
                }
                $discounted_amount = ($total_price * $coupon_details->discount_amount) / 100;
            }

            return response()->json(
                [
                    'success' => true,
                    'discount' => $discounted_amount,
                    'coupon_code' => $coupon_details->code,
                    'coupon_id' => $coupon_details->id,
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }
    /**
     * Will return apply coupon error response
     * 
     * @param String $message
     */
    public function couponError($message = null)
    {
        return response()->json(
            [
                'success' => false,
                'message' => translate($message, session()->get('api_locale'))
            ]
        );
    }

    /**
     * Will create customer address
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\JsonResponse
     */
    public function createCustomerOrder(Request $request)
    {
        $response_url = $this->order_repository->customerCheckout($request);
        if ($response_url != NULL) {
            return response()->json(
                [
                    'success' => true,
                    'response_url' => $response_url
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }
    /**
     * Will create guest order
     * 
     * @param GuestCheckoutRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function guestCheckout(GuestCheckoutRequest $request)
    {
        $response_url = $this->order_repository->guestCheckout($request);
        if ($response_url != NULL) {
            return response()->json(
                [
                    'success' => true,
                    'response_url' => $response_url
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }
    /**
     * Will cancel a order
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder(Request $request)
    {
        if ($request->has('item_id') && $request['item_id'] != null) {
            $res = $this->order_repository->changeOrderItemStatus($request['item_id'], $request['order_id'], config('tlecommercecore.order_delivery_status.cancelled'));
        } else {
            $res = $this->order_repository->cancelOrder($request['order_id']);
        }


        if ($res) {
            return response()->json(
                [
                    'success' => true,
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }
    /**
     * Will return customer orders
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerOrders(Request $request)
    {
        return new OrderCollection($this->order_repository->customerOrders($request, auth('jwt-customer')->user()->id));
    }
    /**
     * Generate order payment link 
     */
    public function makeOrderPayment(Request $request)
    {
        $link = $this->order_repository->makeOrderPaymentLink($request['order_id']);
        if ($link != null) {
            return response()->json(
                [
                    'success' => true,
                    'link' => $link
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }
    /**
     * Will return customer order details
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerOrderDetails(Request $request)
    {
        if ($request->has('order_id')) {
            return new SingleOrderCollection($this->order_repository->customerOrderDetails(auth('jwt-customer')->user()->id, $request['order_id']));
        } else {
            return new SingleOrderCollection($this->order_repository->OrderDetailsByOrderId($request->order_code));
        }
    }
    /**
     * Will store customer return product details
     * 
     * @param ProductReturnRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerOrderReturn(ProductReturnRequest $request)
    {
        if ($request['return_images'] != null) {
            $imageRules = array(
                'return_images' => 'nullable|image|mimes:jpg,jpeg,png|max:2000'
            );
            foreach ($request['return_images'] as $image) {
                $image = array('return_images' => $image);
                $imageValidator = Validator::make($image, $imageRules);
                if ($imageValidator->fails()) {
                    return response()->json(['errors' => $imageValidator->errors()], 422);
                }
            }
        }
        $res = $this->order_repository->returnOrder($request);
        if ($res) {
            return response()->json(
                [
                    'success' => true,
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }
    /**
     * Will return customer refunds requests
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerReturnRequests(Request $request)
    {
        return new RefundRequestCollection($this->order_repository->customerReturnRequests($request, auth('jwt-customer')->user()->id));
    }
    /**
     * Will return guest customer order details
     */
    public function guestCustomerOrderDetails(Request $request)
    {
        return new SingleOrderCollection($this->order_repository->OrderDetailsByOrderId($request['order_code']));
    }
    /**
     * Will store a product review
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reviewProduct(Request $request)
    {
        if ($request['review_images'] != null) {
            $imageRules = array(
                'review_images' => 'nullable|image|mimes:jpg,jpeg,png|max:2000'
            );
            foreach ($request['review_images'] as $image) {
                $image = array('review_images' => $image);
                $imageValidator = Validator::make($image, $imageRules);
                if ($imageValidator->fails()) {
                    return response()->json(['errors' => $imageValidator->errors()], 422);
                }
            }
        }
        $res = $this->order_repository->storeCustomerProductReview($request, auth('jwt-customer')->user()->id);

        if ($res) {
            return response()->json(
                [
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
}
