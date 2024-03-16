<?php

namespace Core\Http\Controllers;

use App\Http\Controllers\Controller;

class SystemController extends Controller
{

    /**
     * Will clear system  cache
     */
    public function clearSystemCache()
    {
        try {
            cache_clear();
            toastNotification('success', translate('Cache clear successfully'));
            return redirect()->back();
        } catch (\Exception $e) {
            toastNotification('error', translate('Cache clear failed'));
        }
    }
}
