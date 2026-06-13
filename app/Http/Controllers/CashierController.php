<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('cashier.index', compact('categories'));
    }

    /**
     * Show the specified resource.
     */
    public function showMenuByCategory(int $id)
    {
        $menus = Menu::where('category_id', $id)->get();
        $html = '';
        foreach ($menus as $menu) {

            $html .= '<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-200 cursor-pointer">
                        <img src="' . url('/storage/menus/' . $menu->image) . '" alt="' . $menu->name . '" class="w-full h-32 bg-gray-100 dark:bg-gray-700 rounded-lg mb-3">
                        <h3 class="text-md text-start font-semibold text-gray-900 dark:text-white">' . $menu->name . '</h3>
                        <p class="text-xs text-start text-gray-500 dark:text-gray-400 mb-2">' . substr($menu->description, 0, 30) . ' ...' . '</p>
                        <p class="text-sm text-start font-bold text-gray-900 dark:text-white">' . number_format($menu->price, 0) . ' ' . 'Kyats' .  '</p>
                    </div>';
        }
        return $html;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
