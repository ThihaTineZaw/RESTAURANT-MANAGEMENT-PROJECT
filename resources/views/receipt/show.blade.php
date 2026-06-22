<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</title>


    <style>
        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 0;
            }
            
            .no-print {
                display: none !important;
            }
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            color: #333;
            background-color: #f3f4f6;
            padding: 20px;
        }

        .receipt-container {
            max-width: 380px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
        
        .no-print {
            max-width: 380px;
            margin: 20px auto;
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        
        .btn-print {
            padding: 12px 24px;
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .btn-print:hover {
            background-color: #4338ca;
        }
        
        .btn-back {
            padding: 12px 24px;
            background-color: #e5e7eb;
            color: #374151;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        
        .btn-back:hover {
            background-color: #d1d5db;
        }
        
    
       
      
    </style>
</head>

<body>

<!-- Action Buttons -->
<div class="no-print">
    <a href="{{ route('receipts.index') }}" class="btn-back text">← Back to Receipts</a>
    <button class="btn-print" onclick="window.print()">
        <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
        </svg>
        Print
    </button>
  
</div>

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
