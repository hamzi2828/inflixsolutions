@php
    use Plugin\TlcommerceCore\Repositories\SettingsRepository;
@endphp

@extends('core::base.layouts.master')
@section('title')
    {{ translate('Ecommerce Settings') }}
@endsection
@section('custom_css')
@endsection
@section('main_content')
    <div class="theme-option-container">
        <form id="ecommerce-settings-form">
            <div class="theme-option-sticky d-flex align-items-center justify-content-between bg-white border-bottom2 p-3">
                <div class="theme-option-logo d-none d-sm-block">
                    <h4>{{ translate('Ecommerce Settings') }}</h4>
                </div>
            </div>
            <div class="theme-option-tab-wrap">
                <div class="nav flex-column border-right2 py-3" aria-orientation="vertical">
                    <a class="nav-link active" data-toggle="pill" href="#general"><i class="icofont-ui-settings"
                            title="{{ translate('General') }}"></i> <span>{{ translate('General') }}</span></a>
                    <a class="nav-link" data-toggle="pill" href="#products"><i class="icofont-bucket1"
                            title="{{ translate('Products') }}"></i> <span>{{ translate('Products') }}</span></a>
                    <a class="nav-link" data-toggle="pill" href="#checkout"><i class="icofont-cart"
                            title="{{ translate('Checkout') }}"></i>
                        <span>{{ translate('Checkout') }}</span></a>
                    <a class="nav-link" data-toggle="pill" href="#customers"><i class="icofont-people"
                            title="{{ translate('Customers') }}"></i>
                        <span>{{ translate('Customers') }}</span></a>
                    <a class="nav-link" data-toggle="pill" href="#orders"><i class="icofont-handshake-deal"
                            title="{{ translate('Orders') }}"></i>
                        <span>{{ translate('Orders') }}</span></a>
                    <a class="nav-link" data-toggle="pill" href="#payments"><i class="icofont-pay"
                            title="{{ translate('Payments') }}"></i>
                        <span>{{ translate('Payments') }}</span></a>
                    <a class="nav-link" data-toggle="pill" href="#wallet"><i class="icofont-wallet"
                            title="{{ translate('Wallet') }}"></i>
                        <span>{{ translate('Wallet') }}</span></a>
                    <a class="nav-link" data-toggle="pill" href="#invoice">
                        <i class="icofont-copy-invert" title="{{ translate('Invoice') }}"></i>
                        <span>{{ translate('Invoice') }}</span></a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="general">
                        <div class="card">
                            <div class="card-body">
                                @if (count($currencies) > 0)
                                    <div class="form-row mb-20">
                                        <div class="col-sm-4">
                                            <label class="font-14 bold black">{{ translate('Defalt currency') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="default_currency">
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}"
                                                        @if (SettingsRepository::getEcommerceSetting('default_currency') == $currency->id) selected @endif>
                                                        {{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <p class="mt-0 font-13">
                                        {{ translate('To create new currency or manage existing currencies') }} <a
                                            href="{{ route('plugin.tlcommercecore.ecommerce.all.currencies') }}"
                                            class="btn-link">{{ translate('click here') }}</a></p>
                                @else
                                    <p class="mt-0 font-13">
                                        {{ translate('To set default currency, plaese create a currency') }} <a
                                            href="{{ route('plugin.tlcommercecore.ecommerce.all.currencies') }}"
                                            class="btn-link">{{ translate('click here') }}</a></p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="products">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Enable product reviews') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_product_reviews"
                                                class="enable-product-review"
                                                @if (SettingsRepository::getEcommerceSetting('enable_product_reviews') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <div
                                    class="product-review-setting-group {{ SettingsRepository::getEcommerceSetting('enable_product_reviews') == config('settings.general_status.active') ? '' : 'd-none' }}">
                                    <div class="form-row mb-20">
                                        <div class="col-sm-6">
                                            <label
                                                class="font-14 bold black ">{{ translate('Enable star rating on product reviews') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="switch glow primary medium">
                                                <input type="checkbox" name="enable_product_star_rating"
                                                    @if (SettingsRepository::getEcommerceSetting('enable_product_star_rating') == config('settings.general_status.active')) checked @endif>
                                                <span class="control"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-row mb-20">
                                        <div class="col-sm-6">
                                            <label
                                                class="font-14 bold black ">{{ translate('Star rating should be required not optional') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="switch glow primary medium">
                                                <input type="checkbox" name="required_product_star_rating"
                                                    @if (SettingsRepository::getEcommerceSetting('required_product_star_rating') == config('settings.general_status.active')) checked @endif>
                                                <span class="control"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-row mb-20">
                                        <div class="col-sm-6">
                                            <label
                                                class="font-14 bold black ">{{ translate('Show Verified customer label on product reviews') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="switch glow primary medium">
                                                <input type="checkbox" name="verified_customer_on_product_review"
                                                    @if (SettingsRepository::getEcommerceSetting('verified_customer_on_product_review') ==
                                                            config('settings.general_status.active')) checked @endif>
                                                <span class="control"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-row mb-20">
                                        <div class="col-sm-6">
                                            <label
                                                class="font-14 bold black ">{{ translate('Reviews can only be left by verified customer') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="switch glow primary medium">
                                                <input type="checkbox" name="only_varified_customer_left_review"
                                                    @if (SettingsRepository::getEcommerceSetting('only_varified_customer_left_review') ==
                                                            config('settings.general_status.active')) checked @endif>
                                                <span class="control"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Enable product compare') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_product_compare"
                                                @if (SettingsRepository::getEcommerceSetting('enable_product_compare') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Enable Product Discount') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_product_discount"
                                                @if (SettingsRepository::getEcommerceSetting('enable_product_discount') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Display product perpage') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="product_per_page" class="theme-input-style"
                                            value="{{ SettingsRepository::getEcommerceSetting('product_per_page') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="checkout">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black">{{ translate('Enable billing address') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_billing_address"
                                                @if (SettingsRepository::getEcommerceSetting('enable_billing_address') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label
                                            class="font-14 bold black ">{{ translate('Use the shipping address as the billing address by default') }}
                                        </label>
                                    </div>
                                    <div class="cl-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="use_shipping_address_as_billing_address"
                                                @if (SettingsRepository::getEcommerceSetting('use_shipping_address_as_billing_address') ==
                                                        config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Enable guest checkout') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_guest_checkout"
                                                @if (SettingsRepository::getEcommerceSetting('enable_guest_checkout') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label
                                            class="font-14 bold black ">{{ translate('Create account in guest checkout') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="create_account_in_guest_checkout"
                                                @if (SettingsRepository::getEcommerceSetting('create_account_in_guest_checkout') ==
                                                        config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label
                                            class="font-14 bold black ">{{ translate('Send invoice to customer email') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="send_invoice_to_customer_mail"
                                                @if (SettingsRepository::getEcommerceSetting('send_invoice_to_customer_mail') ==
                                                        config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Enable tax in checkout') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_tax_in_checkout"
                                                @if (SettingsRepository::getEcommerceSetting('enable_tax_in_checkout') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-row mb-20 {{ isActivePluging('coupon') ? '' : 'area-disabled mb-0' }}">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Enable coupon in checkout') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_coupon_in_checkout"
                                                class="enable-coupon-in-checkout"
                                                @if (SettingsRepository::getEcommerceSetting('enable_coupon_in_checkout') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                    @if (isActivePluging('coupon'))
                                        <div class="col-12">
                                            <p class="mt-0 font-13">{{ translate('Create or manage your') }} <a
                                                    href="{{ route('plugin.tlcommercecore.marketing.coupon.list') }}"
                                                    class="btn-link">Coupons</a>
                                            </p>
                                        </div>
                                    @endif

                                </div>
                                @if (!isActivePluging('coupon'))
                                    <div class="form-row mb-20">
                                        <div class="col-12">
                                            <p class="mt-0 font-13">{{ translate('To enable coupon you need to active') }}
                                                <a href="{{ route('core.plugins.index') }}" class="btn-link">Coupon
                                                    Plugin</a>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                @if (isActivePluging('coupon'))
                                    <div
                                        class="form-row mb-20 multiple-coupon-checkout {{ SettingsRepository::getEcommerceSetting('enable_coupon_in_checkout') == config('settings.general_status.active') ? '' : 'd-none' }}">
                                        <div class="col-sm-6">
                                            <label
                                                class="font-14 bold black ">{{ translate('Enable multiple coupon in single order') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="switch glow primary medium">
                                                <input type="checkbox" name="enable_multiple_coupon_in_checkout"
                                                    @if (SettingsRepository::getEcommerceSetting('enable_multiple_coupon_in_checkout') ==
                                                            config('settings.general_status.active')) checked @endif>
                                                <span class="control"></span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <!--Min order amount-->
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Enable minimum order amount') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_minumun_order_amount"
                                                class="enable-minumun-order-amount"
                                                @if (SettingsRepository::getEcommerceSetting('enable_minumun_order_amount') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <div
                                    class="form-row mb-20 minimum-order-amount {{ SettingsRepository::getEcommerceSetting('enable_minumun_order_amount') == config('settings.general_status.active') ? '' : 'd-none' }}">
                                    <label class="font-14 bold black col-sm-6">{{ translate('Minimum order amount') }}
                                    </label>
                                    <div class="input-group addon col-sm-3">
                                        <input type="text" name="min_order_amount"
                                            value="{{ SettingsRepository::getEcommerceSetting('min_order_amount') }}"
                                            class="form-control style--two" placeholder="0.00">
                                        <div class="input-group-append">
                                            <div class="input-group-text px-3  bold">$</div>
                                        </div>
                                    </div>
                                </div>
                                <!--End mi order amount-->
                                <!--Wallet-->
                                <div class="form-row mb-20 {{ isActivePluging('wallet') ? '' : 'area-disabled mb-0' }}">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Enable wallet in checkout') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_wallet_in_checkout"
                                                @if (SettingsRepository::getEcommerceSetting('enable_wallet_in_checkout') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                @if (!isActivePluging('wallet'))
                                    <div class="form-row mb-20">
                                        <div class="col-12">
                                            <p class="mt-0 font-13">{{ translate('To enable wallet you need to active') }}
                                                <a href="{{ route('core.plugins.index') }}" class="btn-link">Wallet
                                                    Plugin</a>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                <!--End wallet-->
                                <!--Order note-->
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Enable order note') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_order_note_in_checkout"
                                                @if (SettingsRepository::getEcommerceSetting('enable_order_note_in_checkout') ==
                                                        config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <!--End order note-->
                                <!--Documents-->
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Enable document in checkout') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_document_in_checkout"
                                                @if (SettingsRepository::getEcommerceSetting('enable_document_in_checkout') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <!--End Documents-->
                                <!--Carriers-->
                                <div class="form-row mb-20 {{ isActivePluging('carrier') ? '' : 'area-disabled mb-0' }}">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black ">{{ translate('Enable carrier in checkout') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_carrier_in_checkout"
                                                @if (SettingsRepository::getEcommerceSetting('enable_carrier_in_checkout') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                    @if (isActivePluging('carrier'))
                                        <div class="col-12">
                                            <p class="mt-0 font-13">{{ translate('Manage your') }} <a
                                                    href="{{ route('plugin.carrier.list') }}" class="btn-link">3rd Party
                                                    Carriers</a></p>
                                        </div>
                                    @endif
                                </div>
                                @if (!isActivePluging('carrier'))
                                    <div class="form-row mb-20">
                                        <div class="col-12">
                                            <p class="mt-0 font-13">
                                                {{ translate('To enable carrier you need to active') }} <a
                                                    href="{{ route('core.plugins.index') }}" class="btn-link">3rd Party
                                                    Carrier Plugin</a></p>
                                        </div>
                                    </div>
                                @endif
                                <!--End carriers-->
                                <!--Pickup points-->
                                <div
                                    class="form-row mb-20 {{ isActivePluging('pickuppoint') ? '' : 'area-disabled mb-0' }}">
                                    <div class="col-sm-6">
                                        <label
                                            class="font-14 bold black ">{{ translate('Enable pickup point in checkout') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="enable_pickuppoint_in_checkout"
                                                @if (SettingsRepository::getEcommerceSetting('enable_pickuppoint_in_checkout') ==
                                                        config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                    @if (isActivePluging('pickuppoint'))
                                        <div class="col-12">
                                            <p class="mt-0 font-13">{{ translate('Manage your') }} <a
                                                    href="{{ route('plugin.carrier.list') }}" class="btn-link">Pickup
                                                    Points</a></p>
                                        </div>
                                    @endif
                                </div>
                                @if (!isActivePluging('pickuppoint'))
                                    <div class="form-row mb-20">
                                        <div class="col-12">
                                            <p class="mt-0 font-13">
                                                {{ translate('To enable pickup point you need to active') }} <a
                                                    href="{{ route('core.plugins.index') }}" class="btn-link">Pickup
                                                    Point Plugin</a></p>
                                        </div>
                                    </div>
                                @endif
                                <!--End Pickup points-->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="customers">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black">{{ translate('Customer auto approval') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="customer_auto_approved"
                                                @if (SettingsRepository::getEcommerceSetting('customer_auto_approved') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-6">
                                        <label class="font-14 bold black">{{ translate('Customer email verification') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="switch glow primary medium">
                                            <input type="checkbox" name="customer_email_varification"
                                                @if (SettingsRepository::getEcommerceSetting('customer_email_varification') == config('settings.general_status.active')) checked @endif>
                                            <span class="control"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="orders">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row mb-20">
                                    <label class="font-14 bold black col-sm-4">{{ translate('Order code prefix') }}
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" name="order_code_prefix"
                                            value="{{ SettingsRepository::getEcommerceSetting('order_code_prefix') }}"
                                            class="theme-input-style" placeholder="{{ translate('Enter prefix') }}">
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <label
                                        class="font-14 bold black col-sm-4">{{ translate('Order code prefix seperator') }}
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" name="order_code_prefix_seperator"
                                            value="{{ SettingsRepository::getEcommerceSetting('order_code_prefix_seperator') }}"
                                            class="theme-input-style"
                                            placeholder="{{ translate('Enter prefix seperator') }}">
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Can cancel order within') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group addon">
                                            <input type="text" name="cancel_order_time_limit"
                                                value="{{ SettingsRepository::getEcommerceSetting('cancel_order_time_limit') }}"
                                                placeholder="0" class="form-control style--two">
                                            <div class="input-group-append">
                                                <select class="form-control" name="cancel_order_time_limit_unit">
                                                    <option value="{{ config('tlecommercecore.time_unit.Days') }}"
                                                        @if (SettingsRepository::getEcommerceSetting('cancel_order_time_limit_unit') == config('tlecommercecore.time_unit.Days')) selected @endif>
                                                        {{ translate('Days') }}</option>
                                                    <option value="{{ config('tlecommercecore.time_unit.Hours') }}"
                                                        @if (SettingsRepository::getEcommerceSetting('cancel_order_time_limit_unit') ==
                                                                config('tlecommercecore.time_unit.Hours')) selected @endif>
                                                        {{ translate('Hours') }}</option>
                                                    <option value="{{ config('tlecommercecore.time_unit.Minutes') }}"
                                                        @if (SettingsRepository::getEcommerceSetting('cancel_order_time_limit_unit') ==
                                                                config('tlecommercecore.time_unit.Minutes')) selected @endif>
                                                        {{ translate('Minutes') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Can return order within') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group addon">
                                            <input type="text" name="return_order_time_limit"
                                                value="{{ SettingsRepository::getEcommerceSetting('return_order_time_limit') }}"
                                                placeholder="0" class="form-control style--two">
                                            <div class="input-group-append">
                                                <select class="form-control" name="return_order_time_limit_unit">
                                                    <option value="{{ config('tlecommercecore.time_unit.Days') }}"
                                                        @if (SettingsRepository::getEcommerceSetting('return_order_time_limit_unit') == config('tlecommercecore.time_unit.Days')) selected @endif>
                                                        {{ translate('Days') }}</option>
                                                    <option value="{{ config('tlecommercecore.time_unit.Hours') }}"
                                                        @if (SettingsRepository::getEcommerceSetting('return_order_time_limit_unit') ==
                                                                config('tlecommercecore.time_unit.Hours')) selected @endif>
                                                        {{ translate('Hours') }}</option>
                                                    <option value="{{ config('tlecommercecore.time_unit.Minutes') }}"
                                                        @if (SettingsRepository::getEcommerceSetting('return_order_time_limit_unit') ==
                                                                config('tlecommercecore.time_unit.Minutes')) selected @endif>
                                                        {{ translate('Minutes') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="payments">
                        <div class="card">
                            <div class="card-body">
                                <p class="mt-0 font-13">{{ translate('You can manage payment methods') }} <a
                                        href="{{ route('plugin.tlcommercecore.payments.methods') }}"
                                        class="btn-link">{{ translate('form here') }}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="wallet">
                        <div class="card">
                            <div class="card-body">
                                @if (!isActivePluging('wallet'))
                                    <p class="mt-0 font-13">{{ translate('You need to active or install') }} <a
                                            href="{{ route('core.plugins.index') }}" class="btn-link">Wallet Plugin</a>
                                        {{ translate('to manage wallets') }}</p>
                                @endif
                                <div class="{{ isActivePluging('wallet') ? '' : 'area-disabled mb-0' }}">
                                    <div class="form-row mb-20">
                                        <div class="col-sm-6">
                                            <label class="font-14 bold black">{{ translate('Enable online recharge') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="switch glow primary medium">
                                                <input type="checkbox" name="enable_wallet_online_recharge"
                                                    @if (SettingsRepository::getEcommerceSetting('enable_wallet_online_recharge') ==
                                                            config('settings.general_status.active')) checked @endif>
                                                <span class="control"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-row mb-20">
                                        <div class="col-sm-6">
                                            <label class="font-14 bold black">{{ translate('Enable offline recharge') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="switch glow primary medium">
                                                <input type="checkbox" name="enable_wallet_offline_recharge"
                                                    @if (SettingsRepository::getEcommerceSetting('enable_wallet_offline_recharge') ==
                                                            config('settings.general_status.active')) checked @endif>
                                                <span class="control"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-row mb-20">
                                        <div class="col-sm-6">
                                            <label class="font-14 bold black">{{ translate('Minimum recharge amount') }}
                                            </label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="theme-input-style"
                                                name="minimum_wallet_recharge_amount"
                                                value="{{ SettingsRepository::getEcommerceSetting('minimum_wallet_recharge_amount') }}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="invoice">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Business Email') }}</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="email" name="invoice_email" class="theme-input-style"
                                            value="{{ SettingsRepository::getEcommerceSetting('invoice_email') }}" />
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Business Phone') }}</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" name="invoice_phone" class="theme-input-style"
                                            value="{{ SettingsRepository::getEcommerceSetting('invoice_phone') }}" />
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('Business Address') }}</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <textarea name="invoice_address" class="theme-input-style"> {{ SettingsRepository::getEcommerceSetting('invoice_address') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="theme-option-sticky d-flex justify-content-end bg-white border-top2 p-3">
                <div class="theme-option-action_bar">
                    <button class="btn long ecommerce-settings-update-btn">
                        {{ translate('Save Changes') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('custom_scripts')
    <script>
        (function($) {
            "use strict";
            /**
             * Enable and disable product review settings
             * 
             **/
            $('.enable-product-review').on('change', function(e) {
                if ($('input[name="enable_product_reviews"]').is(':checked')) {
                    $('.product-review-setting-group').removeClass('d-none');
                } else {
                    $('.product-review-setting-group').addClass('d-none');
                }
            });
            /**
             *Enable and disable order amount
             *  
             **/
            $('.enable-minumun-order-amount').on('change', function(e) {
                if ($('input[name="enable_minumun_order_amount"]').is(":checked")) {
                    $('.minimum-order-amount').removeClass('d-none');
                } else {
                    $('.minimum-order-amount').addClass('d-none');
                }
            });
            /**
             * Enable and disable coupon
             * 
             **/
            $('.enable-coupon-in-checkout').on('change', function(e) {
                if ($('input[name="enable_coupon_in_checkout"]').is(':checked')) {
                    $('.multiple-coupon-checkout').removeClass('d-none')
                } else {
                    $('.multiple-coupon-checkout').addClass('d-none')
                }
            });
            /**
             * Save ecommmerce settings
             * 
             * 
             **/
            $('.ecommerce-settings-update-btn').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#ecommerce-settings-form").serialize(),
                    url: '{{ route('plugin.tlcommercecore.ecommerce.configuration.update') }}',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('{{ translate('Updated successfully') }}');
                        } else {
                            toastr.error('{{ translate('Update Failed') }}');
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').closest(
                                    '.input-option').after(
                                    '<div class="invalid-input">' + error + '</div>')
                            })
                        } else {
                            toastr.error('{{ translate('Update Failed') }}');
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
