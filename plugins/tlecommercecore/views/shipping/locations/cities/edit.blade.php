@extends('core::base.layouts.master')
@section('title')
    {{ translate('Edit City') }}
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/select2/select2.min.css') }}">
@endsection
@section('main_content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="form-element py-30 mb-30">
                <h4 class="font-20 mb-30">{{ translate('Edit City') }}</h4>
                <form action="{{ route('plugin.tlcommercecore.shipping.locations.cities.update') }}" method="POST">
                    @csrf
                    <div class="form-row mb-20">
                        <div class="col-sm-4">
                            <label class="font-14 bold black">{{ translate('Name') }} </label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="theme-input-style" value="{{ $city_details->name }}"
                                placeholder="{{ translate('Type Name') }}">
                            <input type="hidden" name="id" value="{{ $city_details->id }}">
                            @if ($errors->has('name'))
                                <div class="invalid-input">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row mb-20">
                        <div class="col-sm-4">
                            <label class="font-14 bold black">{{ translate('State') }}</label>
                        </div>
                        <div class="col-sm-8">
                            <select class="stateSelect form-control" name="state"
                                placeholder="{{ translate('Select a State') }}">
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                        {{ $city_details->state_id == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('state'))
                                <div class="invalid-input">{{ $errors->first('state') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn long">{{ translate('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
    <script src="{{ asset('/public/backend/assets/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                $('.stateSelect').select2({
                    theme: "classic",
                });
            });
        })(jQuery);
    </script>
@endsection
