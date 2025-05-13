<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori dan produk terbaru
        $categories = Category::all();
        $products = Product::latest()->paginate(4);

        // Mengecek apakah user sudah login
        $cartCount = 0;
        if (Auth::check()) {
            $user = Auth::user();
            $cartCount = $user->cart ? $user->cart->cartItems->sum('quantity') : 0;

            session(['cart_count' => $cartCount]);
        }

        // Mengirim data cartCount ke view
        return view('welcome', compact('products', 'categories', 'cartCount'));
    }

    public function show($slug)
    {

        $product = Product::where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $products = Product::with('category')
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');

            })
            ->paginate(4)
            ->appends(['q' => $query]);



        return view('welcome', [
            'products' => $products,
            'searchQuery' => $query,
        ]);
    }


}
