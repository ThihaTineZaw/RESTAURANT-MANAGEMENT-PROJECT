<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\Table;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $tables = Table::all();
        return view('cashier.index', compact('categories', 'tables'));
    }

    /**
     * Show the specified resource.
     */
    public function showMenuByCategory(int $id)
    {
        $category = Category::find($id);
        $menus = Menu::where('category_id', $id)->get();
        $html = '';
        foreach ($menus as $menu) {

            $html .= '<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-200 cursor-pointer menu-item" category_id="' . $id . '" category_name="' . ($category ? $category->name : '') . '" menu_id="' . $menu->id . '">
                        <img menu_img="' . $menu->image . '" src="' . url('/storage/menus/' . $menu->image) . '" alt="' . $menu->name . '" class="w-full h-32 bg-gray-100 dark:bg-gray-700 rounded-lg mb-3 menu-image">
                        <h3 menu_name="' . $menu->name . '" class="text-md text-start font-semibold text-gray-900 dark:text-white menu-name">' . $menu->name . '</h3>
                        <p menu_description="' . $menu->description . '" class="text-xs text-start text-gray-500 dark:text-gray-400 mb-2 menu-description">' . substr($menu->description, 0, 30) . ' ...' . '</p>
                        <span menu_price="' . number_format($menu->price, 0) . '" class="text-sm text-start font-bold text-gray-900 dark:text-white menu-price">' . number_format($menu->price, 0) . ' ' . 'Kyats' .  '</span>
                    </div>';
        }
        return $html;
    }
    
    public function order(Request $request)
    {   
        $order = $request->order;
        $orderDetail = $request->orderDetails;

        $user = Auth::user();
        $order = Order::create([
            'table_number' => $order['table_number'],
            'total_price' => $order['total_price'],
            'status' => $order['status'],
            'seller' => $user->email,
        ]);

        $table = Table::find($order['table_number']);
        $table->status = 'unavailable';
        $table->save();

        foreach ($orderDetail as $detail) {
            $orderDetail = OrderDetail::create([
                'order_id' => $order->id,
                'menu_id' => $detail['menu_id'],
                'quantity' => $detail['qty'],
            ]);
        }

        return response()->json('Order placed successfully');
   
    }
   
     public function orderCheck(int $id)

    {
        

          $order = Order::where('table_number', $id)->where('status', 'Unpaid')->first();
       
            
            if(!$order){
                $html = '';
                return response()->json($html);
            }

        
        
        $total_price = Order::where('table_number', $id)->where('status', 'Unpaid')->first()->total_price;
   
        $orderId = $order->id;

  
        $orderItems = $order->orderItems()->get();

        $orderItemList = [];
      
        foreach ($orderItems as $item) {
           
            $menu = Menu::find($item->menu_id);

            $orderItemList[] = [
                'menu_id' => $item->menu_id,
                'menu_name' => $menu->name,
                'menu_price' => $menu->price,
                'menu_image' => $menu->image,
                'menu_quantity' => $item->quantity,
                'menu_total_price' => $menu->price * $item->quantity,
                'total_price' => $total_price,
            ];
        }
        
      
         $html = '';


         
        foreach($orderItemList as $orderItem){
        $html .= '
        <tr name="' . $orderItem['menu_name'] . '" menu_id="' . $orderItem['menu_id'] . '" class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">

            <!-- Image -->
            <td class="px-1 py-1 flex items-center justify-center">
                <img src="/storage/menus/' . $orderItem['menu_image'] . '" 
                    alt="' . $orderItem['menu_name'] . '" 
                    class="w-8 h-8 rounded-md object-cover">
            </td>

            <!-- Name -->
            <td class="px-2 py-1">
                <p class="text-xs font-medium text-gray-900 dark:text-white">
                    ' . $orderItem['menu_name'] . '
                </p>
            </td>

            <!-- Quantity -->
        <td class="px-1 py-1">
                <div class="flex items-center" >

                    <button
                        class="qty-decrease w-5 h-5 rounded-l bg-red-500 hover:bg-red-600 text-white text-xs font-bold">
                        -
                    </button>

                    <span
                        class="qty-value w-8 h-5 flex items-center justify-center border-y border-gray-300  dark:border-gray-600 bg-white dark:text-white dark:bg-gray-800 text-xs font-medium">
                        ' . $orderItem['menu_quantity'] . '
                    </span>

                    <button
                        class="qty-increase w-5 h-5 rounded-r bg-green-500 hover:bg-green-600 text-white text-xs font-bold">
                        +
                    </button>

                </div>
            </td>

            <td class="px-2 py-1">
                <span class="text-xs font-medium text-green-600 dark:text-green-400 price-value" original-price="' . $orderItem['menu_price'] . '">
                    ' . number_format($orderItem['menu_price'] * $orderItem['menu_quantity']) . ' Ks
                </span>
            </td>

            <!-- Delete -->
            <td class="px-1 py-1 text-center">
                <button disabled class="delete-order-menu w-5 h-5 rounded bg-red-100 text-red-500 text-xs opacity-50 cursor-not-allowed">
                    ✕
                </button>
            </td>

        </tr>';
        }
       
        
        return response()->json([
            'html' => $html,
            'total_price' => $total_price,
            'order_id' => $orderId,
        ]);
        
    }
    
    public function orderAgain(Request $request, int $id)
    {
        $order = Order::find($id);
        
        $table_number = $order->table_number;
     
        $orderRequest = $request->order;
        
        if($orderRequest['total_price'] != $order->total_price){
            $order->update([
                'table_number' => $orderRequest['table_number'],
                'total_price' => $orderRequest['total_price'],
                'status' => $orderRequest['status'],
            ]);
        }

        $orderId = $order->id;
        $orderDetailRequest = $request->orderDetails;

        foreach ($orderDetailRequest as $detail) {
            
           $orderDetail = OrderDetail::where('order_id', $orderId)->where('menu_id', $detail['menu_id'])->first();
           if($orderDetail){
               $orderDetail->update([
                   'quantity' => $detail['qty'],
               ]);
           }else{
               OrderDetail::create([
                   'order_id' => $orderId,
                   'menu_id' => $detail['menu_id'],
                   'quantity' => $detail['qty'],
               ]);
           }
           
        }

        return response()->json([
            'message' => 'Order again placed successfully',
            'table_number' => $table_number,
        ]);

        
        

    }

    public function orderPayment(Request $request){

        $orderId = $request->order_id;

        $order = Order::where('id', $orderId)->where('status', 'Unpaid')->first();  


        Table::where('id', $order->table_number)->update([
            'status' => 'available',
        ]);

        $order->update([
            'status' => 'Paid',
        ]);

        return response()->json('Order payment placed successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cashier $cashier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cashier $cashier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cashier $cashier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cashier $cashier)
    {
        //
    }
}
