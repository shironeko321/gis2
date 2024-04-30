<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.map.index', ['collection' => Map::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.map.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);

        Map::create($data);
        return back()->with('msg', 'Success Create New Category');
    }

    /**
     * Display the specified resource.
     */
    public function show(Map $map)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Map $map)
    {
        return view('dashboard.category.edit', ['item' => $map]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Map $map)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);

        $name = $data['name'];

        $map->update($data);
        return redirect()->route('category.index')->with('msg', "Success Update Category($name)");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Map $map)
    {
        $map->delete();

        return redirect()->route('category.index')->with('msg', 'Success Create Delete Category');
    }
}
