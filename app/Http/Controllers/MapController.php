<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMapRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            "description" => $data["description"] ?? "",
            "open" => $data["open"] ?? "",
            "close" => $data["close"] ?? "",
            "daily" => $data["daily"] ?? "",
        ]);

        if (isset($data['image'])) {
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
        }

        return back()->with('msg', 'Success Create New Map');
    }

    /**
     * Display the specified resource.
     */
    public function show(Map $map)
    {
        return view('dashboard.map.show', [
            'item' => $map->with(['detail', 'image'])->first(),
            'category' => Category::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Map $map)
    {
        return view('dashboard.map.edit', [
            'item' => $map->with(['detail', 'image'])->first(),
            'category' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMapRequest $request, Map $map)
    {
        // dd($request->all());
        $data = $request->validated();

        // store map
        $map->update([
            "latitude" => $data["latitude"],
            "longitude" => $data["longitude"],
            "name" => $data["name"],
            "category_id" => $data["category"]
        ]);

        // convert array to str
        $data["daily"] = implode(',', $data["daily"]);

        // store detail about map
        $map->detail()->update([
            "description" => $data["description"],
            "open" => $data["open"],
            "close" => $data["close"],
            "daily" => $data["daily"],
        ]);

        if (isset($data['image'])) {
            # code...
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
        }

        $name = $data['name'];
        return redirect()->route('map.index')->with('msg', "Success Update Map($name)");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Map $map)
    {
        $map->delete();

        return redirect()->route('map.index')->with('msg', 'Success Delete Map');
    }

    public function deleteImage(Image $id)
    {
        Storage::delete("public/images/$id->name");
        $id->delete();

        return back();
    }
}
