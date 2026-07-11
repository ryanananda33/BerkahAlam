<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Galeri;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $heroes = Hero::all();
        $categories = Kategori::all();
        $products = Produk::with('kategori')->orderBy('created_at', 'desc')->take(6)->get();
        $galleries = Galeri::orderBy('created_at', 'desc')->take(8)->get();
        $testimonials = Testimoni::orderBy('created_at', 'desc')->take(6)->get();

        return view('welcome', compact('heroes', 'categories', 'products', 'galleries', 'testimonials'));
    }
}
