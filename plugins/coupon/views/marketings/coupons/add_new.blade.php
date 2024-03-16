@extends('core::base.layouts.master')
@section('title')
    {{ translate('New Coupon') }}
@endsection
@section('custom_css')
    <!--Select2-->
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/select2/select2.min.css') }}">
    <!--End select2-->
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('main_content')
    <div class="theme-option-container">
        <form method="POST" action="{{ route('plugin.tlcommercecore.marketing.coupon.store.new') }}">
            @csrf
            <div class="theme-option-sticky d-flex align-items-center justify-content-between bg-white border-bottom2 p-3">
                <div class="theme-option-logo d-none d-sm-block">
                    <h4>{{ translate('Coupon') }}</h4>
                </div>
            </div>
            <div class="theme-option-tab-wrap">
                <div class="nav flex-column border-right2 py-3" aria-orientation="vertical">
                    <a class="nav-link active" data-toggle="pill" href="#coupon_general"><i class="icofont-ui-home"
                            title="{{ translate('General') }}"></i> <span>{{ translate('General') }}</span></a>
                    <a class="nav-link" data-toggle="pill" href="#coupon_usage_restriction"><i class="icofont-ban"
                            title="{{ translate('Usage Restriction') }}"></i>
                        <span>{{ translate('Usage Restriction') }}</span></a>
                    <a class="nav-link" data-toggle="pill" href="#coupon_usage_limits"><i class="icofont-expand-alt"
                            title="{{ translate('Usage Limits') }}"></i>
                        <span>{{ translate('Usage Limits') }}</span></a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="coupon_general">
                        <div class="card">
                            <div class="card-body col-lg-9">
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Coupon Code') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" name="coupon_code" value="{{ old('coupon_code') }}"
                                            class="theme-input-style category_name" value="{{ old('coupon_code') }}"
                                            placeholder="{{ translate('Type here') }}">
                                        @if ($errors->has('coupon_code'))
                                            <div class="invalid-input">{{ $errors->first('coupon_code') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Description') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <textarea class="theme-input-style" name="description" placeholder="{{ translate('Description') }}">{{ old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <div class="invalid-input">{{ $errors->first('description') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Discount Amount Type') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="theme-input-style" name="discount_amount_type"
                                            value="{{ old('discount_amount_type') }}">
                                            <option value="{{ config('tlecommercecore.amount_type.flat') }}">
                                                {{ translate('Flat') }}</option>
                                            <option value="{{ config('tlecommercecore.amount_type.percent') }}">
                                                {{ translate('Percentage') }}</option>
                                        </select>
                                        @if ($errors->has('discount_amount_type'))
                                            <div class="invalid-input">{{ $errors->first('discount_amount_type') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Discount Amount') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input placeholder="0.00" name="discount_amount"
                                            value="{{ old('discount_amount') }}" type="text"
                                            class="theme-input-style" />
                                        @if ($errors->has('discount_amount'))
                                            <div class="invalid-input">{{ $errors->first('discount_amount') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Allow Free Shipping') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="allow_free_shipping">
                                            <span class="control"></span>
                                        </label>
                                        @if ($errors->has('allow_free_shipping'))
                                            <div class="invalid-input">{{ $errors->first('allow_free_shipping') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Coupon Expiry Date') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="date" name="coupon_expire_date"
                                            value="{{ old('coupon_expire_date') }}" class="theme-input-style" />
                                        @if ($errors->has('coupon_expire_date'))
                                            <div class="invalid-input">{{ $errors->first('coupon_expire_date') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="coupon_usage_restriction">
                        <div class="card">
                            <div class="card-body col-lg-9">
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Minimum Spend') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input placeholder="{{ translate('No Minimum') }}" name="minimum_spend"
                                            value="{{ old('minimum_spend') }}" type="text" class="theme-input-style" />
                                        @if ($errors->has('minimum_spend'))
                                            <div class="invalid-input">{{ $errors->first('minimum_spend') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Maximum Spend') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input placeholder="{{ translate('No Maximum') }}" name="maximum_spend"
                                            value="{{ old('maximum_spend') }}" type="text"
                                            class="theme-input-style" />
                                        @if ($errors->has('maximum_spend'))
                                            <div class="invalid-input">{{ $errors->first('maximum_spend') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Individual Use Only') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="individual_use">
                                            <span class="control"></span>
                                        </label>
                                        @if ($errors->has('individual_use'))
                                            <div class="invalid-input">{{ $errors->first('individual_use') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Exclude Sales Items') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="exclude_sale_items">
                                            <span class="control"></span>
                                        </label>
                                        @if ($errors->has('exclude_sale_items'))
                                            <div class="invalid-input">{{ $errors->first('exclude_sale_items') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Select Products') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="product-select w-100" name="products[]" multiple>
                                            @foreach ($products as $product)
                                                <option data-image="{{ asset(getFilePath($product->thumbnail_image)) }}"
                                                    value="{{ $product->id }}">
                                                    {{ $product->translation('name', getLocale()) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('products'))
                                            <div class="invalid-input">{{ $errors->first('products') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Exclude product') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="product-select w-100" name="exclude_products[]" multiple>
                                            @foreach ($products as $product)
                                                <option data-image="{{ asset(getFilePath($product->thumbnail_image)) }}"
                                                    value="{{ $product->id }}">
                                                    {{ $product->translation('name', getLocale()) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('exclude_products'))
                                            <div class="invalid-input">{{ $errors->first('exclude_products') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Brands') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="brand-select w-100" name="brands[]" multiple>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">
                                                    {{ $brand->translation('name', getLocale()) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('brands'))
                                            <div class="invalid-input">{{ $errors->first('brands') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Exclude Brands') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="brand-select w-100" name="exclude_brands[]" multiple>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">
                                                    {{ $brand->translation('name', getLocale()) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('exclude_brands'))
                                            <div class="invalid-input">{{ $errors->first('exclude_brands') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Categories') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="category-select w-100" name="categories[]" multiple>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->translation('name', getLocale()) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('categories'))
                                            <div class="invalid-input">{{ $errors->first('categories') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Exclude Categories') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="category-select w-100" name="exclude_categories[]" multiple>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->translation('name', getLocale()) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('exclude_categories'))
                                            <div class="invalid-input">{{ $errors->first('exclude_categories') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Allowed Email') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input placeholder="{{ translate('Allowed Email') }}"
                                            value="{{ old('alowed_email') }}" name="alowed_email" type="email"
                                            class="theme-input-style" />
                                        @if ($errors->has('alowed_email'))
                                            <div class="invalid-input">{{ $errors->first('alowed_email') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="coupon_usage_limits">
                        <div class="card">
                            <div class="card-body col-lg-9">
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Usage limit per coupon') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input placeholder="{{ translate('Unlimited Usage') }}" type="text"
                                            name="use_limit_per_coupon" class="theme-input-style" />
                                        @if ($errors->has('use_limit_per_coupon'))
                                            <div class="invalid-input">{{ $errors->first('use_limit_per_coupon') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Usage limit per user') }} </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input placeholder="{{ translate('Unlimited Usage') }}" name="use_limit_per_user"
                                            type="text" class="theme-input-style" />
                                        @if ($errors->has('use_limit_per_user'))
                                            <div class="invalid-input">{{ $errors->first('use_limit_per_user') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="theme-option-sticky d-flex justify-content-end bg-white border-top2 p-3">
                <div class="theme-option-action_bar">
                    <button type="submit" class="btn long">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('custom_scripts')
    <!--Select2-->
    <script src="{{ asset('/public/backend/assets/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                $('.product-select').select2({
                    theme: "classic",
                    placeholder: '{{ translate('No Product Selected') }}',
                    closeOnSelect: false,
                });
                $('.brand-select').select2({
                    theme: "classic",
                    closeOnSelect: false,
                    placeholder: '{{ translate('No Brand Selected') }}',
                });
                $('.category-select').select2({
                    theme: "classic",
                    closeOnSelect: false,
                    placeholder: '{{ translate('No Category Selected') }}',
                });
            });
        })(jQuery);
    </script>
@endsection
