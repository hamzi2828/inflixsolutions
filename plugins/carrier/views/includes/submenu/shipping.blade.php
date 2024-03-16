@php
$isactivateCarrier = isActivePluging('carrier');
@endphp
@if ($isactivateCarrier)
    <li class="{{ Request::routeIs(['plugin.carrier.list']) ? 'active ' : '' }}">
        <a href="{{ route('plugin.carrier.list') }}">{{ translate('Carriers') }}<span
                class="badge badge-danger ml-2">{{ translate('Adoon') }}</span></a>
    </li>
@endif
