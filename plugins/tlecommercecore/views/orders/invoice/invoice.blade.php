<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ======= MAIN STYLES ======= -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/fonts/roboto/roboto.css') }}">
    <!-- ======= END MAIN STYLES ======= -->
    <style>
        html {
            margin: 0px;
            background: white;
        }

        body {
            font-family: 'Roboto';
        }

        .qr-code {
            max-height: 120px;
        }

        .invoice-top {
            background: #EBEBEB;
        }

        .invoice-p {
            margin-bottom: 0px;
            font-size: 12px;
            font-weight: 500;
            color: black;
            padding-block: 5px !important;
        }

        .payment-image {
            max-height: 150px;
        }

        .invoice-product-table {
            width: calc(100% - 40px);
            margin-inline: 20px;
        }

        .p5 {
            padding: 5px;
        }

        .invoice-product-table .thead-light th {
            color: black;
        }
    </style>
</head>

<body>
    <table class="table table-borderless invoice-top">
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
                <td class="text-right">
                    <h3>INVOICE</h3>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="invoice-p">{{ $order_info['system_properties']['title'] }}</p>
                    @if ($order_info['system_properties']['address'] != null)
                        <p class="invoice-p">{{ $order_info['system_properties']['address'] }}</p>
                    @endif
                    @if ($order_info['system_properties']['email'] != null)
                        <p class="invoice-p">Email: {{ $order_info['system_properties']['email'] }}</p>
                    @endif
                    @if ($order_info['system_properties']['phone'] != null)
                        <p class="invoice-p">Phone: {{ $order_info['system_properties']['phone'] }}</p>
                    @endif
                </td>
                <td class="text-right">
                    <p class="invoice-p">Order ID: {{ $order_info['order_code'] }}</p>
                    <p class="invoice-p">Order date: {{ $order_info['date'] }}</p>
                    <p class="invoice-p">Payment method: {{ $order_info['payment_method'] }}</p>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-borderless">
        <tbody>
            <tr>
                <td>
                    <p class="invoice-p">Bill to:</p>
                    <p class="invoice-p">{{ $order_info['billing_info']['name'] }}</p>
                    <p class="invoice-p">
                        @if ($order_info['billing_info']['address'] != null)
                            <span>
                                {{ $order_info['billing_info']['address'] }},
                            </span>
                        @endif
                        @if ($order_info['billing_info']['city'] != null)
                            <span>
                                {{ $order_info['billing_info']['city'] }},
                            </span>
                        @endif
                        @if ($order_info['billing_info']['state'] != null)
                            <span>
                                {{ $order_info['billing_info']['state'] }},
                            </span>
                        @endif
                        @if ($order_info['billing_info']['country'] != null)
                            <span>
                                {{ $order_info['billing_info']['country'] }}.
                            </span>
                        @endif
                    </p>
                    <p class="invoice-p"> Email: {{ $order_info['billing_info']['email'] }}</p>
                    @if ($order_info['billing_info']['phone'] != null)
                        <p class="invoice-p">Phone: {{ $order_info['billing_info']['phone'] }}</p>
                    @endif
                </td>
                <td class="text-right">
                    <img src="data:image/png;base64, {!! $qr_code !!}" class="qr-code">
                </td>
            </tr>
        </tbody>
    </table>
    @php
        $total_amount = 0;
        $sub_total = 0;
        $total_tax = 0;
        $total_discount = 0;
        $total_shipping_cost = 0;
        $total_paid = 0;
    @endphp
    <table class="table invoice-product-table p5">
        <thead class="thead-light">
            <tr>
                <th scope="col" class="invoice-p">Name</th>
                <th scope="col" class="invoice-p">Quantity</th>
                <th scope="col" class="invoice-p">Unit Price</th>
                <th scope="col" class="invoice-p">Tax</th>
                <th scope="col" class="text-right invoice-p">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order_info['products'] as $item)
                @php
                    $sub_total += $item->unit_price * $item->quantity;
                    $total_tax += $item->tax;
                    $total_shipping_cost += $item->delivery_cost;
                    $total_discount += $item->order_discount;
                    $total_amount += $item->unit_price * $item->quantity + $item->tax + $item->delivery_cost;
                    $total_paid += $item->total_paid;
                    
                @endphp
                <tr>
                    <td class="invoice-p">
                        <p class="invoice-p">{{ $item->product_details->name }}</p>
                        @if ($item->variant != null)
                            <p class="invoice-p">{{ $item->variant }}</p>
                        @endif
                    </td>
                    <td class="invoice-p">{{ $item->quantity }}</td>
                    <td class="invoice-p">{{ currencyExchange($item->unit_price) }}</td>
                    <td class="invoice-p">{{ currencyExchange($item->tax) }}</td>
                    <td class="text-right invoice-p">
                        {{ currencyExchange($item->unit_price * $item->quantity) }}
                    </td>
                </tr>
            @endforeach


            <tr>
                <td colspan="3">
                    <div class="payment-image-container mt-4">
                        @php
                            $total_payable = $total_amount - $total_discount;
                        @endphp
                        @if ($total_payable == $total_paid)
                            <img src="{{ asset('/public/backend/assets/img/invoice/paid.png') }}"
                                class="payment-image">
                        @else
                            <img src="{{ asset('/public/backend/assets/img/invoice/unpaid.jpg') }}"
                                class="payment-image">
                        @endif
                    </div>
                </td>
                <td colspan="2">
                    <table class="table table-borderless w-100 invoice-summary-table">
                        <tr>
                            <td class="border-top-0 invoice-p p-0">Subtotal</td>
                            <td class="border-top-0 text-right invoice-p p-0">{{ currencyExchange($sub_total) }}</td>
                        </tr>
                        <tr>
                            <td class="border-top-0 invoice-p p-0">Tax</td>
                            <td class="border-top-0 text-right invoice-p p-0">{{ currencyExchange($total_tax) }}</td>
                        </tr>
                        <tr>
                            <td class="border-top-0 invoice-p p-0">Shipping</td>
                            <td class="border-top-0 text-right invoice-p p-0">
                                {{ currencyExchange($total_shipping_cost) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border-top-0 invoice-p p-0">Discount</td>
                            <td class="border-top-0 invoice-p text-right p-0">{{ currencyExchange($total_discount) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border-top-0 invoice-p p-0">Grand Total</td>
                            <td class="border-top-0 invoice-p text-right p-0">
                                {{ currencyExchange($total_amount - $total_discount) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border-top-0 invoice-p p-0">Paid</td>
                            <td class="border-top-0 invoice-p text-right p-0">
                                {{ currencyExchange($total_paid) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border-top-0 invoice-p p-0">Total Due</td>
                            <td class="border-top-0 invoice-p text-right p-0">
                                {{ currencyExchange($total_amount - $total_discount - $total_paid) }}
                            </td>
                        </tr>

                    </table>
                </td>
            <tr>

        </tbody>
    </table>
</body>

</html>
