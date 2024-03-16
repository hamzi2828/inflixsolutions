<?php

namespace Plugin\TlcommerceCore\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Plugin\TlcommerceCore\Repositories\VatTaxRepository;
use Plugin\TlcommerceCore\Repositories\ProductRepository;
use Plugin\TlcommerceCore\Repositories\ShippingRepository;
use Plugin\TlcommerceCore\Http\Requests\ShippingZoneTaxRequest;

class TaxController extends Controller
{
    protected $tax_repository;
    protected $shipping_repository;
    protected $product_repository;

    public function __construct(VatTaxRepository $tax_repository, ShippingRepository $shipping_repository, ProductRepository $product_repository)
    {
        $this->tax_repository = $tax_repository;
        $this->shipping_repository = $shipping_repository;
        $this->product_repository = $product_repository;
    }
    /**
     * Will redirect vat and taxes page
     * 
     * @return mixed
     */
    public function taxes()
    {
        return view('plugin/tlecommercecore::taxes.index')->with(
            [
                'zones' => $this->shipping_repository->shippingZones()
            ]
        );
    }
    /**
     * Will return zone taxes list
     * 
     * @param Int $id
     * @return mixed
     */
    public function zoneTaxes($id)
    {
        return view('plugin/tlecommercecore::taxes.zone_taxes')->with(
            [
                'zone_info' => $this->shipping_repository->shippingZoneDetails($id),
                'states' => $this->shipping_repository->zonesStates($id)
            ]
        );
    }
    /**
     * Will update shipping zone base tax
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function updateBaseTax(Request $request)
    {
        $res = $this->shipping_repository->updateZoneBaseTax($request);
        if ($res) {
            toastNotification('success', translate('Zone base tax updated'));
            return redirect()->route('plugin.tlcommercecore.ecommerce.settings.zone.taxes', $request['zone_id']);
        } else {
            toastNotification('error', translate('Action failed'));
            return redirect()->back();
        }
    }
    /**
     * Will store shipping zone tax
     * 
     * @param ShippingZoneTaxRequest $request
     * @return mixed
     **/
    public function storeZoneTax(ShippingZoneTaxRequest $request)
    {
        $res = $this->tax_repository->storeShippingZoneCustomTax($request);
        if ($res) {
            toastNotification('success', translate('New tax rate added successfully'));
        } else {
            toastNotification('error', translate('Action failed'));
        }
    }
    /**
     * Will delete shipping zone tax
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function deleteZoneTax(Request $request)
    {
        $res = $this->tax_repository->deleteCustomTax($request['id']);
        if ($res) {
            toastNotification('success', translate('Tax deleted successfully'));
            return redirect()->route('plugin.tlcommercecore.ecommerce.settings.zone.taxes', $request['zone_id']);
        } else {
            toastNotification('error', translate('Unable to delete tax'));
            return redirect()->back();
        }
    }
    /**
     * Will delete bulk amount of zone tax
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function bulkDeleteZoneTax(Request $request)
    {
        $res = $this->tax_repository->bulkDeleteCustomTax($request);
        if ($res) {
            toastNotification('success', translate('Selected items deleted successfully'));
        } else {
            toastNotification('error', translate('Action failed'));
        }
    }
    /**
     * Will update zone tax rate
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function updateZoneTax(Request $request)
    {
        $res = $this->tax_repository->updateZoneTaxRate($request);
        if ($res) {
            toastNotification('success', translate('Tax rate updated successfully'));
        } else {
            toastNotification('error', translate('Action failed'));
        }
    }
}
