<?php

namespace Plugin\TlcommerceCore\Repositories;

use Illuminate\Support\Facades\DB;
use Plugin\TlcommerceCore\Models\ShippingZoneHasTaxes;

class VatTaxRepository
{

    /**
     * Will store shipping zone custom tax 
     * 
     * @param Object $request
     * @return bool
     */
    public function storeShippingZoneCustomTax($request)
    {
        try {
            if ($request['tax_type'] === 'product_tax') {
                $state = $request['state'] != 'null' ? $request['state'] : NULL;
                $collection = $request['collection'] != null ? $request['collection'] : NULL;
            } else {
                $state = $request['state'] != null ? $request['state'] : NULL;
                $collection = NULL;
            }
            $tax = ShippingZoneHasTaxes::firstOrCreate(
                [
                    'state_id' => $state,
                    'product_collection_id' => $collection,
                    'zone_id' => $request['zone_id']
                ]
            );
            $tax->tax = $request['tax'];
            $tax->save();
            return true;
        } catch (\Exception $e) {
            return false;
        } catch (\Error $e) {
            return false;
        }
    }
    /**
     * Will delete zone custom tax
     * 
     * @param Int $tax_id
     * @return bool
     */
    public function deleteCustomTax($tax_id)
    {
        try {
            DB::beginTransaction();
            $tax = ShippingZoneHasTaxes::findOrFail($tax_id);
            $tax->delete();
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
     * Will delete zone custom tax
     * 
     * @param Object $request
     * @return bool
     */
    public function bulkDeleteCustomTax($request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('data')) {
                foreach ($request['data'] as $item_id) {
                    $tax = ShippingZoneHasTaxes::findOrFail($item_id);
                    $tax->delete();
                }
            }
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
     * Will update zone tax rate
     * 
     * @param Object $request
     * @return bool
     */
    public function updateZoneTaxRate($request)
    {
        try {
            DB::beginTransaction();
            $tax_rate = $request['tax_rate'] != null ? $request['tax_rate'] : 0;
            $tax = ShippingZoneHasTaxes::findOrFail($request['id']);
            $tax->tax = $tax_rate;
            $tax->save();
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
}
