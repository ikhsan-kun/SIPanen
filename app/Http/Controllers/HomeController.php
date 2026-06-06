<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->orderBy('stock', 'desc')
            ->take(6)
            ->get();

        $totalProducts = Product::where('is_active', true)->count();

        return view('home', compact('featuredProducts', 'totalProducts'));
    }

    public function catalog(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_asc'  => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest'     => $query->orderBy('created_at', 'desc'),
                default      => $query->orderBy('name', 'asc'),
            };
        } else {
            $query->orderBy('name', 'asc');
        }

        $products = $query->paginate(9);
        $categories = ['egrek' => 'Egrek', 'dodos' => 'Dodos', 'telescopic_pole' => 'Gagang Teleskopik'];

        return view('catalog', compact('products', 'categories'));
    }

    public function productDetail($slug)
    {
        $product  = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $related  = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return view('product-detail', compact('product', 'related'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
