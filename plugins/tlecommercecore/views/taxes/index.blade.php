@extends('core::base.layouts.master')
@section('title')
    {{ translate('Taxes') }}
@endsection
@section('custom_css')
    @include('core::base.includes.data_table.css')
@endsection
@section('main_content')
    <div class="align-items-center border-bottom2 d-flex flex-wrap gap-10 justify-content-between mb-4 pb-3">
        <h4><i class="icofont-money"></i> {{ translate('Taxes') }}</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-30">
                <div class="card-header bg-white border-bottom2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="font-20">{{ translate('Taxes') }}</h4>
                        <div class="d-flex flex-wrap">
                            <a href="{{ route('plugin.tlcommercecore.shipping.configuration') }}"
                                class="btn long">{{ translate('Create or manage zone') }}</a>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (count($zones) > 0)
                            <table id="taxTable" class="hoverable text-nowrap border-top2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ translate('Tax Zone') }}/ {{ translate('Shipping Zone') }}</th>
                                        <th>{{ translate('Shipping Profile') }}</th>
                                        <th>{{ translate('Base Tax') }}</th>
                                        <th>{{ translate('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($zones as $key => $zone)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $zone->name }}</td>
                                            <td>
                                                @if ($zone->shippingProfile != null)
                                                    <a
                                                        href="{{ route('plugin.tlcommercecore.shipping.profile.manage', ['id' => $zone->shippingProfile->id]) }}">
                                                        {{ $zone->shippingProfile->name }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $zone->base_tax }}%</td>
                                            <td>
                                                <a href="{{ route('plugin.tlcommercecore.ecommerce.settings.zone.taxes', $zone->id) }}"
                                                    class="btn-link">{{ translate('Manage Taxes') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @else
                            <p class="text text-danger">{{ translate('No shipping zone found') }}</p>
                            <a href="{{ route('plugin.tlcommercecore.shipping.configuration') }}"
                                class="btn-link">{{ translate('Add or manage shipping zone') }}</a>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
@section('custom_scripts')
    @include('core::base.includes.data_table.script')
    <script>
        /**
         * Vat and tax table
         */
        (function($) {
            "use strict";
            $("#taxTable").DataTable({
                "responsive": false,
                "scrolX": true,
                "lengthChange": true,
                "autoWidth": false,
            }).buttons().container().appendTo('#taxTable_wrapper .col-md-6:eq(0)');
        })(jQuery);
    </script>
@endsection
