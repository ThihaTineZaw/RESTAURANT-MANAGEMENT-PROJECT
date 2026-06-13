<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\Category;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $menus = Menu::with('category')->paginate(10);
        // dd($menus);

        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('menu.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:menus,name',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'description' => 'required|string|max:255',
        ]);
        $manager = new ImageManager(new Driver());

        $image = $request->file('image');
        $img = $manager->read($image)->resize(600, 600);
        $filename = time() . '.' . $image->getClientOriginalExtension();

        Storage::disk('public')->put('menus/' . $filename, $img->encode());

        
        

        $data['image'] = $filename;


        Menu::create($data);


        return redirect()->route('menu.index');
       }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('menu.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:menus,name,' . $menu->id,
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'description' => 'required|string|max:255',
        ]);

        if($request->hasFile('image')){

            Storage::disk('public')->delete('menus/' . $menu->image);

            $manager = new ImageManager(new Driver());

            $image = $request->file('image');
            $img = $manager->read($image)->resize(600, 600);
            $filename = time() . '.' . $image->getClientOriginalExtension();

            Storage::disk('public')->put('menus/' . $filename, $img->encode());

            $data['image'] = $filename;


        }

        $menu->update($data);
        return redirect()->route('menu.index');
       }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        Storage::disk('public')->delete('menus/' . $menu->image);
        $menu->delete();
        return redirect()->route('menu.index');
    }
}
