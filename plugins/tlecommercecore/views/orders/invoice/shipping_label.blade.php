<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/bootstrap/css/bootstrap.min.css') }}">
    <style>
        .big-barcode {
            height: 190px;
        }

        .small-barcode {
            height: 100px;
        }

        .qr-code {
            min-height: 200px;
        }

        .border-bottom-1 {
            border-bottom: 1px solid #dee2e6 !important;
        }

        .border-right-1 {
            border-right: 1px solid #dee2e6 !important;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>
                            @if ($order_info['system_properties']['logo'] != null)
                                <img src="{{ asset('/') }}{{ $order_info['system_properties']['logo'] }}"
                                    alt={{ $order_info['system_properties']['title'] }}>
                            @else
                                <h2>{{ $order_info['system_properties']['title'] }}</h2>
                            @endif
                        </td>
                        <td>
                            <p class="mb-0 font-weight-bold">Order Number</p>
                            <p class="mb-0">{{ $order_info['order_code'] }}</p>
                        </td>
                        <td>{{ $order_info['date'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <img src="data:image/png;base64, {!! $tracking_id_bar_code !!}" class="w-100 small-barcode">
                            <p class="mb-0 text-center">Tracking Number {{ $order_info['tracking_id'] }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <img src="data:image/png;base64, {!! $order_code_bar_code !!}" class="w-100 big-barcode">
                            <p class="mb-0 text-center">Order Number {{ $order_info['order_code'] }}</p>
                        </td>
                        <td class="p-0">
                            <table class="w-100">
                                <tr>
                                    <td class="border-0 border-bottom-1">
                                        {{ $order_info['shipping_zone'] != null ? $order_info['shipping_zone'] : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0 border-bottom-1">
                                        {{ $order_info['shipping_type'] != null ? $order_info['shipping_type'] : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0 border-bottom-1">
                                        {{ $order_info['shipping_method'] != null ? $order_info['shipping_method'] : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0 border-bottom-1">{{ $order_info['payment_method'] }}</td>
                                </tr>
                                <tr>
                                    <td class="border-0">{{ currencyExchange($order_info['total_payable_amount']) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="data:image/png;base64, {!! $qr_code !!}" class="w-100 qr-code">
                        </td>

                        <td class="p-0" colspan="2">
                            <table class="w-100">
                                <tr>
                                    <td class="border-0 border-bottom-1" colspan="2">
                                        @if ($order_info['shipping_info'] != null)
                                            <p>
                                                Recipient: {{ $order_info['shipping_info']['name'] }}
                                                (Tel:{{ $order_info['shipping_info']['phone'] }})-
                                                {{ $order_info['shipping_info']['address'] }},
                                                {{ $order_info['shipping_info']['city'] }},
                                                {{ $order_info['shipping_info']['state'] }},
                                                {{ $order_info['shipping_info']['country'] }}
                                            </p>
                                        @else
                                            Recipient: {{ $order_info['customer_name'] }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0 border-bottom-1" colspan="2">
                                        <p>
                                            Seller:{{ $order_info['system_properties']['title'] }}
                                            (Tel:{{ $order_info['system_properties']['phone'] }})-
                                            {{ $order_info['system_properties']['address'] }},
                                            {{ $order_info['system_properties']['email'] }},
                                        </p>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0 border-bottom-1" colspan="2">Total Weight
                                        {{ $order_info['total_product_weight'] }} kg</td>
                                </tr>
                                <tr>
                                    <td class="border-0" colspan="2">
                                        Number of Products {{ $order_info['num_of_products'] }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
