<?php

namespace Theme\TLCommerce\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Theme\TLCommerce\Models\Sliders;
use Theme\TLCommerce\Http\Requests\SliderRequest;

class SliderController extends Controller
{
    /**
     *Will return all sliders
     *
     *@return mixed
     */
    public function sliders()
    {
        $sliders = Sliders::orderBy('id', 'DESC')->get();
        return view('theme/tlcommerce::backend.sliders.index')->with(
            [
                'sliders' => $sliders
            ]
        );
    }
    /**
     * Will store new slider
     * 
     * @param SliderRequest $request
     * @return mixed
     */
    public function storeNewSlider(SliderRequest $request)
    {
        try {
            $slider = new Sliders;
            $slider->title = $request['title'];
            $slider->desktop = $request['desktop'];
            $slider->mobile = $request['mobile'];
            $slider->url = $request['url'];
            $slider->save();
            cache_clear();
            toastNotification('success', translate('Slider added successfully'));
            return redirect()->route('theme.tlcommerce.sliders');
        } catch (\Exception $e) {
            toastNotification('error', translate('Action failed'));
            return redirect()->back();
        }
    }
    /**
     * Will delete a slider
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function deleteSlider(Request $request)
    {
        try {
            DB::beginTransaction();
            $slider = Sliders::findOrFail($request['id']);
            $slider->delete();
            DB::commit();
            toastNotification('success', translate('Slider deleted successfully'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Action failed'));
            return redirect()->back();
        }
    }
    /**
     * Will update status of slider
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function updateSliderStatus(Request $request)
    {
        try {
            $slider = Sliders::findOrFail($request['id']);
            $status = config('settings.general_status.active');
            if ($slider->status === config('settings.general_status.active')) {
                $status = config('settings.general_status.in_active');
            }
            $slider->status = $status;
            $slider->save();
            toastNotification('success', translate('Status update successfully'));
        } catch (\Exception $e) {
            toastNotification('error', translate('Status update failed'));
        }
    }
    /**
     * Will delete bulk amount of slider
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function deleteBulkSlider(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request['data'] as $id) {
                $slider = Sliders::find($id);
                if ($slider != null) {
                    $slider->delete();
                }
            }
            toastNotification('success', translate('Delete selected items'));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Action Failed'));
        } catch (\Error $e) {
            DB::rollBack();
            toastNotification('error', translate('Action Failed'));
        }
    }
    /**
     * Will redirect to edit slider page
     * 
     * @param Int $id
     * @return mixed
     */
    public function editSlider($id)
    {
        $slider_details = Sliders::findOrFail($id);
        return view('theme/tlcommerce::backend.sliders.edit')->with(
            [
                'slider_details' => $slider_details
            ]
        );
    }
    /**
     * Will update slider info
     * 
     * @param SliderRequest $request
     * @return mixed
     */
    public function updateSlider(SliderRequest $request)
    {
        try {
            $slider = Sliders::findOrFail($request['id']);
            $slider->title = $request['title'];
            $slider->desktop = $request['desktop'];
            $slider->mobile = $request['mobile'];
            $slider->url = $request['url'];
            $slider->save();
            toastNotification('success', translate('Slider updated successfully'));
            return redirect()->route('theme.tlcommerce.sliders.edit', ['id' => $request['id']]);
        } catch (\Exception $e) {
            toastNotification('error', translate('Action failed'));
            return redirect()->back();
        }
    }
}
