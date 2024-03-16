<?php

namespace Plugin\PickupPoint\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Plugin\PickupPoint\Models\PickupPoint;

class PickupPointRepository
{
    /**
     * get pickup point list query builder
     *
     * @param  mixed $data
     * @param  mixed $match_case
     * @return mixed
     */
    public function getPickupPointList($data, $match_case)
    {
        return DB::table('tl_pick_up_points')
            ->join('tl_com_shipping_zones', 'tl_com_shipping_zones.id', '=', 'tl_pick_up_points.zone')
            ->where($match_case)
            ->select($data);
    }

    /**
     * Will get active pickup point list
     * 
     * @param Object $request
     * @return Collections
     */
    public function getActivePickupPoint($request)
    {
        return PickupPoint::with(['zoneInfo:id,name'])
            ->where('status', config('settings.general_status.active'))
            ->select('name', 'location', 'phone', 'zone', 'id')
            ->get();
    }
}
