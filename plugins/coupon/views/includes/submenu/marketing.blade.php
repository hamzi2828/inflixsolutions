@php
    $isactivateCoupon = isActivePluging('coupon');
@endphp
@if ($isactivateCoupon)
    @if (auth()->user()->can('Manage Coupons'))
        <li class="{{ Request::routeIs(['plugin.tlcommercecore.marketing.coupon.list']) ? 'active ' : '' }}">
            <a href="{{ route('plugin.tlcommercecore.marketing.coupon.list') }}">{{ translate('Coupons') }}<span
                    class="badge badge-danger ml-2">{{ translate('Addon') }}</span></a>
        </li>
    @endif
@endif
