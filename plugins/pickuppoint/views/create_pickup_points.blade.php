@php
    $shippingZones = Plugin\TlcommerceCore\Models\ShippingZone::get();
@endphp
@extends('core::base.layouts.master')
@section('title')
    {{ translate('Create Pickup Points') }}
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/select2/select2.min.css') }}">
@endsection
@section('main_content')
    <div class="row">
        <div class="col-md-7 mb-30 mx-auto">
            <!-- Create pick up points -->
            <div class="card">
                <div class="card-body">
                    <div class="post-head d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="content">
                                <h4 class="mb-1">{{ translate('Add Pickup Points') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div>
                        <form action="{{ route('plugin.pickuppoint.store.pickup.point') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Pickup Point Name') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name" class="theme-input-style"
                                        value="{{ old('name') }}" placeholder="{{ translate('Give Pickup Point Name') }}">
                                    @if ($errors->has('name'))
                                        <div class="invalid-input">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Pickup Point Phone') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="phone" class="theme-input-style"
                                        value="{{ old('phone') }}"
                                        placeholder="{{ translate('Give Pickup Point Phone') }}">
                                    @if ($errors->has('phone'))
                                        <div class="invalid-input">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Location') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <textarea type="text" name="location" class="theme-input-style"
                                        placeholder="{{ translate('Give pickup point location') }}">{{ old('location') }}</textarea>
                                    @if ($errors->has('location'))
                                        <div class="invalid-input">{{ $errors->first('location') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Shipping Zone') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <select id='selectZone' name="zone" class="theme-input-style">
                                        <option value="-1" class="text-uppercase">{{ translate('Select Zone') }}
                                        </option>
                                        @foreach ($shippingZones as $zone)
                                            <option value="{{ $zone->id }}" class="text-uppercase">{{ $zone->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('zone'))
                                        <div class="invalid-input">{{ $errors->first('zone') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Status') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <label class="switch success">
                                        <input type="checkbox" checked="checked" name="status">
                                        <span class="control"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn long">{{ translate('Submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Create pick up points-->
        </div>
        @include('core::base.media.partial.media_modal')
    </div>
@endsection
@section('custom_scripts')
    <script src="{{ asset('/public/backend/assets/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                $('#selectZone').select2({
                    theme: "classic",
                    placeholder: "{{ translate('Select a Shipping Zone') }}"
                });
            });
        })(jQuery);
    </script>
@endsection
