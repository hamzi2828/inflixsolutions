<?php

namespace Plugin\TlcommerceCore\Http\Controllers\Api;

use Core\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Plugin\TlcommerceCore\Models\Country;
use Plugin\TlcommerceCore\Models\Currency;
use Plugin\TlcommerceCore\Repositories\SettingsRepository;

class SettingsController extends Controller
{

    /**
     * Will return all  active languages
     * Will return active currencies
     * Will return active countries
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function siteProperties(Request $request)
    {
        try {
            $languages = Language::where('status', config('settings.general_status.active'))->select('id', 'native_name as title', 'code')->get();
            $currencies = Currency::where('status', config('settings.general_status.active'))->select('id', 'name', 'code', 'symbol', 'conversion_rate', 'position', 'thousand_separator', 'decimal_separator', 'number_of_decimal')->get();
            $siteProperties = Cache::rememberForever('site-properties', function () {
                return SettingsRepository::SiteProperties();
            });
            $site_Settings = Cache::rememberForever('site-settings', function () {
                return  SettingsRepository::siteSettings();
            });


            return response()->json(
                [
                    'success' => true,
                    'languages' => $languages,
                    'currencies' => $currencies,
                    'siteProperties' => $siteProperties,
                    'site_settings' => $site_Settings
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
     * Will return countries phone code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function phoneCodes()
    {
        try {
            $phone_codes = Country::where('status', config('settings.general_status.active'))->pluck('phone_code');
            return response()->json(
                [
                    'success' => true,
                    'phone_codes' => $phone_codes
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
}
