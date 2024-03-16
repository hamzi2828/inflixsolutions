<?php

namespace Plugin\TlcommerceCore\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Plugin\TlcommerceCore\Repositories\CurrencyRepository;
use Plugin\TlcommerceCore\Repositories\SettingsRepository;

class SettingsController extends Controller
{
    protected $settings_repository;
    protected $currency_repository;

    public function __construct(SettingsRepository $settings_repository, CurrencyRepository $currency_repository)
    {
        $this->settings_repository = $settings_repository;
        $this->currency_repository = $currency_repository;
    }
    /**
     * Will return ecommerce settings
     * 
     * @return mixed
     */
    public function ecommerceConfig()
    {
        $currencies = $this->currency_repository->currencies(config('settings.general_status.active'));
        return view('plugin/tlecommercecore::ecommerce-settings.settings')->with(
            [
                'currencies' => $currencies,
            ]
        );
    }
    /**
     * Will update ecommerce settings
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEcommerceSettings(Request $request)
    {
        $res = $this->settings_repository->updateEcommerceSettings($request);

        if ($res) {
            cache_clear();
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
}
