<?php

namespace Plugin\TlcommerceCore\Repositories;

use Illuminate\Support\Facades\DB;
use Plugin\TlcommerceCore\Models\Cities;
use Plugin\TlcommerceCore\Models\Country;
use Plugin\TlcommerceCore\Models\States;

class LocationRepository
{
    /**
     * will return country list
     * 
     * @return Collections
     */
    public function countries($status = [1, 2])
    {
        return Country::withCount('states')->orderBy('id', 'ASC')->whereIn('status', $status)->get();
    }

    /**
     * Wll return countries 
     */
    public function countryList($request, $status = [1, 2])
    {
        $query = Country::query();
        if ($request->has('search_key')) {
            $query = $query->where('name', "like", '%' . $request['search_key'] . '%');
        }
        return $query->orderBy('id', 'ASC')->whereIn('status', $status)->paginate(15)->withQueryString();
    }
    /**
     * Store new country
     * 
     * @param Array $request
     * @return bool
     */
    public function storeCountry($request)
    {
        try {
            DB::beginTransaction();
            $country = new Country;
            $country->name = $request['name'];
            $country->code = $request['code'];
            $country->phone_code = null;
            $country->status = config('settings.general_status.active');
            $country->save();
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
     * Will delete country
     * 
     * @param Int $id
     * @return bool
     */
    public function deleteCountry($id)
    {
        try {
            DB::beginTransaction();
            $country = Country::findOrFail($id);
            $country->delete();
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
     * Change country status
     * 
     * @param Int $id
     * @return bool
     */
    public function changeCountryStatus($id)
    {
        try {
            DB::beginTransaction();
            $country = Country::findOrFail($id);
            $status = $country->status == config('settings.general_status.active') ? config('settings.general_status.in_active') : config('settings.general_status.active');
            $country->status = $status;
            $country->save();
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
     * will return country details
     * 
     * @param Int $id
     * @return Collection
     */
    public function countryDetails($id)
    {
        return Country::findOrFail($id);
    }
    /**
     * will update country
     * 
     * @param Array $request
     * @return bool
     */
    public function updateCountry($request)
    {
        try {
            DB::beginTransaction();
            $country = Country::findOrFail($request['id']);
            $country->name = $request['name'];
            $country->code = $request['code'];
            $country->save();
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
     * Will return state list
     * 
     * @return collections
     */
    public function states($status = [1, 2])
    {
        return States::with('country')->whereIn('status', $status)->orderBy('id', 'DESC')->get();
    }
    /**
     * Will return state list
     * 
     * @return collections
     */
    public function statesList($request, $status = [1, 2])
    {
        $query = States::with('country');

        if ($request->has('search_key')) {
            $query = $query->where('name', 'like', '%' . $request['search_key'] . '%');
        }
        return $query->orderBy('id', 'DESC')->whereIn('status', $status)->paginate(15)->withQueryString();
    }
    /**
     * Store new State
     * 
     * @param Array $request
     * @return bool
     */
    public function storeState($request)
    {
        try {
            DB::beginTransaction();
            $state = new States;
            $state->name = $request['name'];
            $state->country_id = $request['country'];
            $state->code = $request['code'];
            $state->status = config('settings.general_status.active');
            $state->save();
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
     * Will delete state
     * 
     * @param Int $id
     * @return bool
     */
    public function deleteState($id)
    {
        try {
            DB::beginTransaction();
            $state = States::findOrFail($id);
            $state->delete();
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
     * Change state status
     * 
     * @param Int $id
     * @return bool
     */
    public function changeStateStatus($id)
    {
        try {
            DB::beginTransaction();
            $state = States::findOrFail($id);
            $status = $state->status == config('settings.general_status.active') ? config('settings.general_status.in_active') : config('settings.general_status.active');
            $state->status = $status;
            $state->save();
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
     * will return state details
     * 
     * @param Int $id
     * @return Collection
     */
    public function stateDetails($id)
    {
        return States::findOrFail($id);
    }
    /**
     * will update state
     * 
     * @param Array $request
     * @return bool
     */
    public function updateState($request)
    {
        try {
            DB::beginTransaction();
            $state = States::findOrFail($request['id']);
            $state->name = $request['name'];
            $state->code = $request['code'];
            $state->country_id = $request['country'];
            $state->save();
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
     * Will return cities
     * 
     * @return Collections
     */
    public function cities()
    {
        return Cities::with('state')->orderBy('id', 'DESC')->get();
    }
    /**
     * Will return cities
     * 
     * @return Collections
     */
    public function citiesList($request, $status = [1, 2])
    {
        $query = Cities::with('state');
        if ($request->has('search_key')) {
            $query = $query->where('name', 'like', '%' . $request['search_key'] . '%');
        }

        return $query->orderBy('id', 'DESC')->whereIn('status', $status)->paginate(16)->withQueryString();
    }
    /**
     * Store new city
     * 
     * @param Array $request
     * @return bool
     */
    public function storeCity($request)
    {
        try {
            DB::beginTransaction();
            $city = new Cities;
            $city->name = $request['name'];
            $city->state_id = $request['state'];
            $city->status = config('settings.general_status.active');
            $city->save();
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
     * will delete city
     * 
     * @param Int $id
     * @return bool
     */
    public function deleteCity($id)
    {
        try {
            DB::beginTransaction();
            $city = Cities::findOrFail($id);
            $city->delete();
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
     * Change city's status
     * 
     * @param Int $id
     * @return bool
     */
    public function changeCityStatus($id)
    {
        try {
            DB::beginTransaction();
            $city = Cities::findOrFail($id);
            $status = $city->status == config('settings.general_status.active') ? config('settings.general_status.in_active') : config('settings.general_status.active');
            $city->status = $status;
            $city->save();
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
     * Will return city details
     * 
     * @param Int $id
     * @return Collection
     */
    public function cityDetails($id)
    {
        return Cities::findOrFail($id);
    }
    /**
     * will update city
     * 
     * @param Array $request
     * @return bool
     */
    public function updateCity($request)
    {
        try {
            DB::beginTransaction();
            $city = Cities::findOrFail($request['id']);
            $city->name = $request['name'];
            $city->state_id = $request['state'];
            $city->save();
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
