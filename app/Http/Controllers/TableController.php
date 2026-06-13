<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::paginate(10);
        return view('table.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('table.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'table_number' => 'required|string|unique:tables,table_number',
            'status' => 'required|string',
        ]);

        Table::create($data);
        return redirect()->route('tables.index')->with('success', 'Table created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {

        return view('table.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Table $table)
    {
        $data = $request->validate([
            'table_number' => 'required|string|unique:tables,table_number',
            'status' => 'required|string',
        ]);

        $table->update($data);
        return redirect()->route('tables.index')->with('success', 'Table updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('tables.index')->with('success', 'Table deleted successfully');
    }
}
