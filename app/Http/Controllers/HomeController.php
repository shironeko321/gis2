<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Map;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $images = Image::inRandomOrder()->limit(7)->get();
        return view('home.index', [
            'images' => $images
        ]);
    }

    public function map()
    {
        $marker = Map::with(['image', 'detail', 'operationaltime', 'category'])->get();
        $category = Category::all();

        return view('home.map', [
            'markers' => $marker,
            'category' => $category
        ]);
    }

    public function about()
    {
        return view('home.about', []);
    }

    public function contact()
    {
        return view('home.contact', []);
    }
}
