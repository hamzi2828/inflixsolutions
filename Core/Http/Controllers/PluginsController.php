<?php

namespace Core\Http\Controllers;

use Core\Models\Plugings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PluginsController extends Controller
{
    /**
     * Get plugins list
     * 
     * @return mixed
     */
    public function index()
    {
        $plugins = Plugings::all();
        return view('core::base.plugins.index', compact('plugins'));
    }

    /**
     * Deactivate plugin
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function inactive(Request $request)
    {
        try {
            DB::beginTransaction();
            $plugin = Plugings::findOrFail($request->id);
            $plugin->is_activated = config('settings.general_status.in_active');
            $plugin->update();
            DB::commit();
            Cache::forget("is-active-{$plugin->location}");
            toastNotification('success', translate('Plugin inactive successfully'), 'Success');
            return redirect()->route('core.plugins.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Plugin deactivation failed'), 'Failed');
            return redirect()->route('core.plugins.index');
        }
    }
    /**
     * Activate plugin
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function activate(Request $request)
    {
        try {
            DB::beginTransaction();
            $plugin = Plugings::findOrFail($request->id);
            $plugin->is_activated = config('settings.general_status.active');
            $plugin->update();
            DB::commit();
            Cache::forget("is-active-{$plugin->location}");
            toastNotification('success', translate('Plugin activate successfully'), 'Success');
            return redirect()->route('core.plugins.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Plugin activation failed'), 'Failed');
            return redirect()->route('core.plugins.index');
        }
    }
}
