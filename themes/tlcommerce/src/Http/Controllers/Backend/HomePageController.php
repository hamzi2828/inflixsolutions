<?php

namespace Theme\TLCommerce\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Core\Models\ThemeTranslations;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Theme\TLCommerce\Models\HomePageSection;
use Theme\TLCommerce\Models\HomeSectionProperties;
use Theme\TLCommerce\Http\Requests\HomePageSectionRequest;

class HomePageController extends Controller
{
    /**
     * Will return home page sections
     * 
     * @return mixed
     */
    public function homePageSections()
    {
        $sections = HomePageSection::orderBy('ordering')->get();
        return view('theme/tlcommerce::backend.homepage.sections')->with(
            [
                'sections' => $sections
            ]
        );
    }
    /**
     * Redirect to new section page
     * 
     * @return mixed
     */
    public function newHomePageSection()
    {
        return view('theme/tlcommerce::backend.homepage.new_section');
    }
    /**
     * Will sorting home page sections
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function sortingHomePageSection(Request $request)
    {
        try {
            $position = 0;
            foreach ($request['item'] as $item_id) {
                $position++;
                $section = HomePageSection::find($item_id);
                $section->ordering = $position;
                $section->save();
            }
            toastNotification('success', translate('Successfully rearranging'));
        } catch (\Exception $e) {
            toastNotification('error', translate('Action Failed'));
        }
    }
    /**
     * Will remove home page section
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function removeHomePageSection(Request $request)
    {
        try {
            DB::beginTransaction();
            $section = HomePageSection::findOrFail($request['id']);
            $section->section_properties()->delete();
            $section->delete();
            DB::commit();
            toastNotification('success', translate('Section deleted successfully'));
            return redirect()->route('theme.tlcommerce.home.page.sections');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Action Failed'));
            return redirect()->back();
        }
    }
    /**
     * Will update home section status
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function updateHomePageSectionStatus(Request $request)
    {
        try {
            DB::beginTransaction();
            $section = HomePageSection::findOrFail($request['id']);
            $status = config('settings.general_status.active');
            if ($section->status == config('settings.general_status.active')) {
                $status = config('settings.general_status.in_active');
            }
            $section->status = $status;
            $section->save();
            DB::commit();
            toastNotification('success', translate('Status updated successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Action Failed'));
        }
    }
    /**
     * Will return layout options
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function layoutOptions(Request $request)
    {
        if ($request['layout'] == 'flashdeal') {
            $deals = [];
            if (isActivePluging('flashdeal')) {
                $deals = \Plugin\Flashdeal\Models\FlashDeal::where('status', config('settings.general_status.active'))->get();
            }
            return view('theme/tlcommerce::backend.homepage.deal_options')->with(
                [
                    'deals' => $deals
                ]
            );
        } elseif ($request['layout'] == 'product_collection') {
            $collections = [];
            if (isActivePluging('tlecommercecore')) {
                $collections = \Plugin\TlcommerceCore\Models\ProductCollection::where('status', config('settings.general_status.active'))->get();
            }
            return view('theme/tlcommerce::backend.homepage.collection_options')->with(
                [
                    'collections' => $collections
                ]
            );
        } elseif ($request['layout'] == 'ads') {
            return view('theme/tlcommerce::backend.homepage.ads_options');
        } elseif ($request['layout'] == 'blogs') {
            return view('theme/tlcommerce::backend.homepage.blogs_options');
        } elseif ($request['layout'] == 'featured_product') {
            return view('theme/tlcommerce::backend.homepage.featured_product_options');
        } elseif ($request['layout'] == 'category_slider') {
            return view('theme/tlcommerce::backend.homepage.category_slider_options');
        } elseif ($request['layout'] == 'custom_product_section') {
            return view('theme/tlcommerce::backend.homepage.custom_product_section_options');
        }
    }
    /**
     * Will return ads layout options
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function adsLayoutOptions(Request $request)
    {
        return view('theme/tlcommerce::backend.homepage.ads_layout_options')->with(
            [
                'layout' => $request['layout'],
            ]
        );
    }
    /**
     * Will store new home page section
     * 
     * @param HomePageSectionRequest $request
     * @return mixed
     */
    public function storeNewHomePageSection(Request $request)
    {
        try {
            DB::beginTransaction();
            $section = new HomePageSection;
            $section->save();
            foreach ($request->except('_token') as $key => $value) {
                $section_properties = new HomeSectionProperties;
                $section_properties->section_id = $section->id;
                $section_properties->key_name = $key;
                $section_properties->key_value = $value;
                $section_properties->save();
            }
            if ($request->has('title') && $request['title'] != null) {
                $this->storeFrontendTranslation($request['title']);
            }
            if ($request->has('meta_title') && $request['meta_title'] != null) {
                $this->storeFrontendTranslation($request['meta_title']);
            }
            if ($request->has('btn_title') && $request['btn_title'] != null) {
                $this->storeFrontendTranslation($request['btn_title']);
            }
            if ($request->has('featured_title') && $request['featured_title'] != null) {
                $this->storeFrontendTranslation($request['featured_title']);
            }
            DB::commit();
            toastNotification('success', translate('New Section added successfully'));
            return redirect()->route('theme.tlcommerce.home.page.sections');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Save failed'));
            return redirect()->back();
        }
    }

    /**
     * Will redirect edit section page
     * 
     * @param Int $id
     * @return mixed
     */
    public function editHomePageSection($id)
    {
        $section_details = HomePageSection::find($id);
        return view('theme/tlcommerce::backend.homepage.edit_section')->with(
            [
                'section_details' => $section_details,
            ]
        );
    }

    /**
     * Will update home section
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function updateHomePageSection(Request $request)
    {
        try {
            DB::beginTransaction();
            $section = HomePageSection::find($request['id']);
            $section->section_properties()->delete();
            $section->save();
            foreach ($request->except('_token', 'id') as $key => $value) {
                $section_properties = new HomeSectionProperties;
                $section_properties->section_id = $section->id;
                $section_properties->key_name = $key;
                $section_properties->key_value = $value;
                $section_properties->save();
            }

            if ($request->has('title') && $request['title'] != null) {
                $this->storeFrontendTranslation($request['title']);
            }
            if ($request->has('btn_title') && $request['btn_title'] != null) {
                $this->storeFrontendTranslation($request['btn_title']);
            }
            if ($request->has('meta_title') && $request['meta_title'] != null) {
                $this->storeFrontendTranslation($request['meta_title']);
            }
            if ($request->has('featured_title') && $request['featured_title'] != null) {
                $this->storeFrontendTranslation($request['featured_title']);
            }
            DB::commit();
            toastNotification('success', translate('Section updated successfully'));
            return redirect()->route('theme.tlcommerce.home.page.sections.edit', ['id' => $request['id']]);
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Update failed'));
            return redirect()->back();
        }
    }

    /**
     * will store section title and button translation
     * 
     * @param String $key
     * @return void
     */
    public function storeFrontendTranslation($key)
    {
        $active_theme = getActiveTheme();
        $translation = ThemeTranslations::where('lang', 'en')->where('theme', $active_theme->location)->where('lang_key', $key)->first();
        if ($translation == null) {
            $new_translation = new ThemeTranslations;
            $new_translation->lang = 'en';
            $new_translation->theme = $active_theme->location;
            $new_translation->lang_key = $key;
            $new_translation->lang_value = $key;
            $new_translation->save();
        }
    }
    /**
     * 
     * Builder
     */
    public function setSectionLayout(Request $request)
    {
        return view('theme/tlcommerce::backend.homepage.builder.layouts')->with(
            [
                'layout' => $request['layout'],
            ]
        );
    }

    public function loadElements(Request $request)
    {
        return view('theme/tlcommerce::backend.homepage.builder.elements')->with(
            [
                'target' => $request->div_id
            ]
        );
    }
}
