<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">


    <style>
        @media print {
    @page {
        margin: 0;
    }

    body {
        margin: 0;
    }
}
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 380px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 15px;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #999;
            padding-bottom: 10px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .section {
            margin-top: 10px;
            padding-bottom: 10px;
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
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- Header -->
    <div class="header">
        <div class="title mb-2 font-semibold">{{ config('app.name') }}</div>
        <div >Official Receipt</div>
    </div>

    <!-- Order Info -->
    <div class="section">
        <p><b>Order ID:</b> #{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</p>
        <p><b>Date:</b> {{ $order->created_at }}</p>
        <p><b>Seller:</b> {{ $order->seller }}</p>
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
                <td>{{ $orderDetail->menu->name }}</td>
                <td class="right">{{ $orderDetail->quantity }}</td>
                <td class="right">
                    {{ number_format(($orderDetail->menu->price ?? 0) * $orderDetail->quantity, 2) }}
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- Payment -->
    <div class="section">
        <p><b>Total:</b> {{ number_format($payment->total_price, 2) }}</p>
        <p><b>Received:</b> {{ number_format($payment->received_price, 2) }}</p>
        <p><b>Change:</b> {{ number_format($payment->change_price, 2) }}</p>
        <p><b>Payment:</b> {{ $payment->payment_method }}</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        Thank you! Please come again !
    </div>

</div>

</body>
</html>

<script>
window.onload = function () {
    window.print();
      window.onafterprint = function () {
        window.location.href = '/cashier';
    };
    
};


</script>