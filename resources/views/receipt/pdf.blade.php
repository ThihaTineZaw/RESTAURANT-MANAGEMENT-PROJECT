<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .receipt-container {
            max-width: 380px;
            margin: auto;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #999;
            padding-bottom: 12px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
        }

        .section {
            margin-top: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 6px 0;
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            font-size: 15px;
        }

        .footer {
            text-align: center;
            margin-top: 18px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
<div class="receipt-container">

    <!-- Header -->
    <div class="header">
        <div class="title mb-2 font-semibold">{{ config('app.name') }}</div>
        <div class="subtitle">Official Receipt</div>
    </div>

    <!-- Order Info -->
    <div class="section">
        <p><b>Order ID:</b> #{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</p>
        <p><b>Date:</b> {{ $order->created_at }}</p>
        <p><b>Seller:</b> {{ $order->seller }}</p>
        <p><b>Table:</b> {{ $order->table_number }}</p>
    </div>

    <!-- Items -->
    <div class="section">
        <table>
            <tr>
                <th>Item</th>
                <th class="right">Qty</th>
                <th class="right">Price</th>
            </tr>

            @foreach ($orderDetails as $orderDetail)
            <tr>
                <td>{{ $orderDetail->menu->name ?? 'Unknown Item' }}</td>
                <td class="right">{{ (int)$orderDetail->quantity }}</td>
                <td class="right">
                    {{ number_format((float)($orderDetail->menu->price ?? 0) * (int)$orderDetail->quantity, 0) }} Ks
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- Payment -->
    @if($payment)
    <div class="section">
        <p class="total"><b>Total:</b> {{ number_format((float)$payment->total_price, 0) }} Ks</p>
        <p><b>Received:</b> {{ number_format((float)$payment->received_price, 0) }} Ks</p>
        <p><b>Change:</b> {{ number_format((float)$payment->change_price, 0) }} Ks</p>
        <p><b>Payment Method:</b> {{ $payment->payment_method }}</p>
    </div>
    @else
    <div class="section">
        <p class="total"><b>Total:</b> {{ number_format((float)$order->total_price, 0) }} Ks</p>
        <p><b>Status:</b> {{ $order->status }}</p>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        Thank you! Please come again!
    </div>

</div>
</body>
</html>
