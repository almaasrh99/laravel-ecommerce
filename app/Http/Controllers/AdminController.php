<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
   public function index()
{

    $totalProducts = Product::count();
    $totalCategories = Category::count();
    $totalUsers = User::count();

    return view('dashboard', compact('totalProducts', 'totalCategories', 'totalUsers'));
}

 public function productList() {

    $products = Product::with('category')->latest()->paginate(5);
    return view('dashboard.products.index', compact('products'));


}

public function productAdd() {
    $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));

}

 public function storeProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:10024',
        ]);

        $image = $request->file('image');
        $image->storeAs('products', $image->hashName(), 'public');

        Product::create([
            'name'        => $request->name,
            'category_id' => $request->category_id,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'price'       => $request->price,
            'image'       => $image->hashName()
        ]);

        return redirect()->route('dashboard.products')->with('success', 'Produk berhasil ditambahkan');
    }

    public function deleteProduct ($id): RedirectResponse {
        $product = Product::findOrFail($id);
        Storage::delete('products/'.$product->image);
        $product->delete();
        return redirect()->route('dashboard.products')->with('success', 'Produk berhasil dihapus');
    }

    public function editProduct ($id) {
        $categories = Category::all();
      $product = Product::findOrFail($id);
        return view('dashboard.products.edit', compact('product','categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|min:1',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|min:10',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:10024',
        ]);
    
        $product = Product::findOrFail($id);
    
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists('products/' . $product->image)) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
    
            // Simpan gambar baru
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->storeAs('products', $imageName, 'public');
    
            $product->image = $imageName;
        }
    
        // Update field lainnya
        $product->name = $request->name;
        $product->category_id = $request->category_id; // Kamu sebelumnya salah, pakai yang dari request
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();
    
        return redirect()->route('dashboard.products')->with('success', 'Produk berhasil diperbarui.');
    }
    

    public function listOrder() {
        
        $orders = Order::orderBy('id','desc')->paginate(10);
        return view('dashboard.orders.index', compact('orders'));
    }

    public function showOrder($id) {
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);
        return view('dashboard.orders.show', compact('order'));
    }

   
}
