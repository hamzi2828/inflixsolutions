<?php

use Core\Models\Plugings;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getActivePlugins')) {
    /**
     * get active plugins list
     *
     * @return Collections
     */
    function getActivePlugins()
    {
        return Plugings::where('is_activated', config('settings.general_status.active'))->get();
    }
}

if (!function_exists('getActivePluginDashboard')) {
    /**
     * get active plugin dashboard content
     *
     * @return Array
     */
    function getActivePluginDashboard()
    {
        $plugins = getActivePlugins();

        $items = [];
        foreach ($plugins as $plugin) {
            $item = 'plugin/' . $plugin->location . '::includes.dashboard';
            if (View::exists($item)) {
                array_push($items, $item);
            }
        }
        return $items;
    }
}

if (!function_exists('plugingsNavbar')) {
    /**
     * get admin dashboard navbar
     *
     * @return Array
     */
    function plugingsNavbar()
    {
        $active_plugins = getActivePlugins();
        $items = [];
        foreach ($active_plugins as $plugin) {
            $new_item = 'plugin/' . $plugin->location . '::includes.navbar';
            array_push($items, $new_item);
        }
        return $items;
    }

    if (!function_exists('isActivePluging')) {
        /**
         * will return plugin is activate or not
         *
         * @return Collection
         */
        function isActivePluging($plugin_name)
        {
            $plugin = Cache::remember("is-active-{$plugin_name}", 100 * 60, function () use ($plugin_name) {
                return Plugings::where('location', $plugin_name)->where('is_activated', config('settings.general_status.active'))->first();
            });
            if ($plugin != null) {
                return true;
            } else {
                return false;
            }
        }
    }

    if (!function_exists('isActiveParentPlugin')) {
        /**
         * will return parent plugin is activate or not
         *
         * @return Collections
         */
        function isActiveParentPlugin($plugin_name)
        {
            $plugin = Cache::remember("is-active-{$plugin_name}", 100, function () use ($plugin_name) {
                return Plugings::where('location', $plugin_name)->where('is_activated', config('settings.general_status.active'))->first();
            });
            if ($plugin != null) {
                return true;
            } else {
                throw new \Core\Exceptions\PluginException('You need to activate ' . ucfirst($plugin_name) . ' Plugin');
            }
        }
    }
}
