<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMapRequest;
use App\Models\Category;
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
        return view('dashboard.map.create', ['category' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMapRequest $request)
    {
        $data = $request->validated();

        // store map
        $map = Map::create([
            "latitude" => $data["latitude"],
            "longitude" => $data["longitude"],
            "name" => $data["name"],
            "category_id" => $data["category"]
        ]);

        // convert array to str
        $data["daily"] = implode(',', $data["daily"]);

        // store detail about map
        $map->detail()->create([
            "description" => $data["description"],
            "open" => $data["open"],
            "close" => $data["close"],
            "daily" => $data["daily"],
        ]);

        // store image
        $filename = [];
        $images = $request->file('image');
        foreach ($images as $image) {
            // get file name
            $path = $image->store("public/images");
            $path = str_replace("public/images/", "", $path);
            array_push($filename, ["name" => $path]);
        }

        $map->image()->createMany($filename);

        return back()->with('msg', 'Success Create New Map');
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
