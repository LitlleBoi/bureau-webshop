<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('available', true)->take(4)->get();
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('pages.home', compact('featuredProducts', 'categories'));
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category') && $request->category !== 'Alle') {
            $query->where('category', $request->category);
        }

        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name_nl', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('category', 'like', "%{$searchTerm}%");
            });
        }

        $products = $query->latest()->get();
        $categories = Product::select('category')->distinct()->pluck('category');
        $selectedCategory = $request->get('category', 'Alle');

        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
