<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #2a9d8f;
            padding: 20px;
            text-align: center;
            color: #fff;
        }

        .header img {
            max-height: 60px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f4f4f4;
        }

        th.price-column {
            width: 50px;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

        .footer {
            background: #f9fafb;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ getSetting()->site_name }}</h1>
        </div>

        <p>Dear {{ $user->full_name }},</p>
        <p>Thank you for your purchase. Below are your order details:</p>

        <p><strong>Transaction ID:</strong> {{ $order->tnx_id }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Variants</th>
                    <th class="price-column">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->getOrderProduct as $orderProduct)
                    @foreach ($orderProduct->getProduct as $product)
                        <tr>
                            <td>{{ $product->name ?? 'Unknown' }}</td>
                            <td>
                                @if (!empty($orderProduct->variants))
                                    @php $variants = unserialize($orderProduct->variants); @endphp
                                    @foreach ($variants as $variant)
                                        {{ $variant['option_name'] }} ({{ $variant['price'] }}
                                        {{ getSetting()->default_symbol }})<br>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if (!empty($orderProduct->variants))
                                    @php
                                        $totalVariantPrice = collect(unserialize($orderProduct->variants))->sum(
                                            'price',
                                        );
                                    @endphp
                                    {{ $totalVariantPrice }} {{ getSetting()->default_symbol }}
                                @else
                                    {{ $product->price ?? 0 }} {{ getSetting()->default_symbol }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tr>
                <td></td>
                <th>Discount</th>
                <td>{{ $order->billing_discount ?? 0 }} {{ getSetting()->default_symbol }}</td>
            </tr>
            <tr>
                <td></td>
                <th>Total</th>
                <td>{{ $order->billing_total }} {{ getSetting()->default_symbol }}</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Best regards, <a href="{{ url('/') }}">{{ getSetting()->site_name }}</a></p>
            © {{ date('Y') }} {{ getSetting()->site_name }}. All rights reserved.
        </div>
    </div>
</body>

</html>
