<?php

namespace Plugin\TlcommerceCore\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Plugin\TlcommerceCore\Models\Currency;
use Plugin\TlcommerceCore\Models\EcommerceConfig;

class SettingsRepository
{
    /**
     * Will return ecommerce setting
     * 
     * 
     * @param String $key
     * @param mixed $default_value
     * @return String
     */
    public static function getEcommerceSetting($key, $fallback = NULL)
    {
        try {
            if (EcommerceConfig::where('key_name', $key)->exists()) {
                $config = EcommerceConfig::where('key_name', $key)->first();
            } else {
                $config = EcommerceConfig::firstOrCreate(['key_name' => $key]);
                $config->key_value = $fallback;
                $config->save();
            }
            return $config->key_value;
        } catch (\Exception $e) {
            return $fallback;
        } catch (\Error $e) {
            return $fallback;
        }
    }

    /**
     * Get default currency
     */
    public static function defaultCurrency()
    {
        return Currency::where('id', self::getEcommerceSetting('default_currency'))->select('id', 'name', 'code', 'symbol', 'conversion_rate', 'position', 'thousand_separator', 'decimal_separator', 'number_of_decimal')->first();
    }

    /**
     * Will update ecommerce settings
     * 
     * @param Object $request
     * @return bool
     */
    public function updateEcommerceSettings($request)
    {
        try {
            DB::beginTransaction();
            $settings = [
                'enable_product_reviews'                  => $request->has('enable_product_reviews') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_product_star_rating'              => $request->has('enable_product_star_rating') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'required_product_star_rating'            => $request->has('required_product_star_rating') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'verified_customer_on_product_review'     => $request->has('verified_customer_on_product_review') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'only_varified_customer_left_review'      => $request->has('only_varified_customer_left_review') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_product_compare'                  => $request->has('enable_product_compare') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'manage_product_stock'                    => $request->has('manage_product_stock') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_product_discount'                 => $request->has('enable_product_discount') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_billing_address'                  => $request->has('enable_billing_address') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'use_shipping_address_as_billing_address' => $request->has('use_shipping_address_as_billing_address') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_guest_checkout'                   => $request->has('enable_guest_checkout') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'create_account_in_guest_checkout'        => $request->has('create_account_in_guest_checkout') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'send_invoice_to_customer_mail'           => $request->has('send_invoice_to_customer_mail') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_tax_in_checkout'                  => $request->has('enable_tax_in_checkout') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_coupon_in_checkout'               => $request->has('enable_coupon_in_checkout') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_multiple_coupon_in_checkout'      => $request->has('enable_multiple_coupon_in_checkout') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_minumun_order_amount'             => $request->has('enable_minumun_order_amount') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_wallet_in_checkout'               => $request->has('enable_wallet_in_checkout') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_order_note_in_checkout'           => $request->has('enable_order_note_in_checkout') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_document_in_checkout'             => $request->has('enable_document_in_checkout') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'customer_auto_approved'                  => $request->has('customer_auto_approved') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'customer_email_varification'             => $request->has('customer_email_varification') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'customer_social_auth'                    => $request->has('customer_social_auth') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'min_order_amount'                        => $request->has('min_order_amount') ? $request['min_order_amount'] : 0,
                'cancel_order_time_limit'                 => $request->has('cancel_order_time_limit') ? $request['cancel_order_time_limit'] : 0,
                'cancel_order_time_limit_unit'            => $request->has('cancel_order_time_limit_unit') ? $request['cancel_order_time_limit_unit'] : 'Days',
                'return_order_time_limit'                 => $request->has('return_order_time_limit') ? $request['return_order_time_limit'] : 0,
                'return_order_time_limit_unit'            => $request->has('return_order_time_limit_unit') ? $request['return_order_time_limit_unit'] : 'Days',
                'product_per_page'                        => $request['product_per_page'] != null ? $request['product_per_page'] : 10,
                'enable_carrier_in_checkout'              => $request->has('enable_carrier_in_checkout') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'order_code_prefix'                       => $request->has('order_code_prefix') ? $request['order_code_prefix'] : null,
                'minimum_wallet_recharge_amount'          => $request->has('minimum_wallet_recharge_amount') ? $request['minimum_wallet_recharge_amount'] : 0,
                'maximum_wallet_used_in_single_order'     => $request->has('maximum_wallet_used_in_single_order') ? $request['maximum_wallet_used_in_single_order'] : 0,
                'enable_wallet_online_recharge'           => $request->has('enable_wallet_online_recharge') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_wallet_offline_recharge'          => $request->has('enable_wallet_offline_recharge') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'default_currency'                        => $request->has('default_currency') ? $request['default_currency'] : null,
                'enable_pickuppoint_in_checkout'          => $request->has('enable_pickuppoint_in_checkout') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'order_code_prefix_seperator'             => $request->has('order_code_prefix_seperator') ? $request['order_code_prefix_seperator'] : null,
                'invoice_email'                           => $request->has('invoice_email') ? $request['invoice_email'] : null,
                'invoice_phone'                           => $request->has('invoice_phone') ? $request['invoice_phone'] : null,
                'invoice_address'                         => $request->has('invoice_address') ? $request['invoice_address'] : null,
            ];
            $settings_keys = array_keys($settings);
            foreach ($settings_keys as $key) {
                $config = EcommerceConfig::firstOrCreate(['key_name' => $key]);
                $config->key_value = $settings[$key];
                $config->save();
            }
            Cache::forget('default-currency-details');
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        } catch (\Error $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Will return site properties
     */
    public static function SiteProperties()
    {
        try {
            $data = [
                'logo' => getFilePath(getGeneralSetting('white_background_logo'), false),
                'logo_dark' => getFilePath(getGeneralSetting('black_background_logo'), false),
                'mobile_logo' => getFilePath(getGeneralSetting('white_mobile_background_logo'), false),
                'mobile_dark_logo' => getFilePath(getGeneralSetting('black_mobile_background_logo'), false),
                'site_title' => getGeneralSetting('site_title') != null ? getGeneralSetting('site_title') : getGeneralSetting('system_name'),
                'site_name' => getGeneralSetting('system_name'),
                'favicon' => getFilePath(getGeneralSetting('favicon'), false),
                'sticky_black_logo' => getFilePath(getGeneralSetting('sticky_black_background_logo'), false),
                'sticky_logo' => getFilePath(getGeneralSetting('sticky_background_logo'), false),
                'sticky_black_mobile_logo' => getFilePath(getGeneralSetting('sticky_black_mobile_background_logo'), false),
                'sticky_mobile_logo' => getFilePath(getGeneralSetting('sticky_mobile_background_logo'), false),
                'copyright' => getGeneralSetting('copyright_text')
            ];

            return $data;
        } catch (\Exception $e) {
            return NULL;
        } catch (\Error $e) {
            return NULL;
        }
    }

    /**
     * Will return site settings
     * 
     * @return Array
     */
    public static function siteSettings()
    {
        try {
            $data = [
                'enable_product_reviews'              => self::getEcommerceSetting('enable_product_reviews'),
                'enable_product_star_rating'          => self::getEcommerceSetting('enable_product_star_rating'),
                'required_product_star_rating'        => self::getEcommerceSetting('required_product_star_rating'),
                'verified_customer_on_product_review' => self::getEcommerceSetting('verified_customer_on_product_review'),
                'only_varified_customer_left_review'  => self::getEcommerceSetting('only_varified_customer_left_review'),
                'enable_product_compare'              => self::getEcommerceSetting('enable_product_compare'),
                'enable_product_discount'             => self::getEcommerceSetting('enable_product_discount'),
                'product_per_page'                    => self::getEcommerceSetting('product_per_page'),
                'enable_wallet'                       => isActivePluging('wallet') ? config('settings.general_status.active') : config('settings.general_status.in_active'),
                'enable_online_recharge'              => self::getEcommerceSetting('enable_wallet_online_recharge'),
                'enable_offline_recharge'             => self::getEcommerceSetting('enable_wallet_offline_recharge'),
                'minimum_recharge_amount'             => self::getEcommerceSetting('minimum_wallet_recharge_amount'),
                'enable_guest_checkout'               => self::getEcommerceSetting('enable_guest_checkout'),
            ];

            return $data;
        } catch (\Exception $e) {
            return NULL;
        } catch (\Error $e) {
            return NULL;
        }
    }
}
