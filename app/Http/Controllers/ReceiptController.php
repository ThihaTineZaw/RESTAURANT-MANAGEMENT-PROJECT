<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    //
    public function index()
    {
        $orders = Order::with('payment')->where('status', 'PAID')->orderBy('id', 'desc')->paginate(10);
        return view('receipt.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = Order::with('orderItems.menu', 'payment')->findOrFail($id);
        $payment = $order->payment;
        $orderDetails = $order->orderItems;

        return view('receipt.show', compact('order', 'orderDetails', 'payment'));
    }

    public function download(int $id)
    {
        $order = Order::with('orderItems.menu', 'payment')->findOrFail($id);
        $payment = $order->payment;
        $orderDetails = $order->orderItems;
        
        $pdf = Pdf::loadView('receipt.pdf', compact('order', 'orderDetails', 'payment'));
        
        return $pdf->download('receipt-'.str_pad($order->id, 8, '0', STR_PAD_LEFT).'.pdf');
    }
}
