<?php

// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    { $user = Auth::user();
        $cart = Cart::with('cartItems.product')->where('user_id', $user->id)->first();

        session(['cart_count' => CartItem::whereHas('cart', function ($query) {
            $query->where('user_id', Auth::id());
        })->sum('quantity')]);

        return view('cart.index', [
            'cart' => $cart
        ]);
    }


    public function add(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'user') {
            return redirect()->route('login');
        }

        // Pastikan user punya cart
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

        $product = Product::findOrFail($id);

        // Cek apakah item sudah ada di cart
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }



        // Hitung ulang total item di keranjang
        $cartCount = CartItem::where('cart_id', $cart->id)->sum('quantity');
        session(['cart_count' => $cartCount]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }



public function update(Request $request, $id)
{
    $cart = Cart::where('user_id', Auth::id())->firstOrFail();
    $cartItem = CartItem::where('id', $id)
        ->where('cart_id', $cart->id)
        ->firstOrFail();

    $quantity = max(1, (int) $request->input('quantity'));
    $cartItem->quantity = $quantity;
    $cartItem->save();

    // Update jumlah total item di keranjang (untuk ikon, jika diperlukan)
    $cartCount = CartItem::whereHas('cart', function($query) {
        $query->where('user_id', Auth::id());
    })->sum('quantity');

    // Jika request via AJAX, kirimkan subtotal & cartCount sebagai JSON
    if ($request->ajax()) {
        $subtotal = $cartItem->product->price * $quantity;

        return response()->json([
            'subtotal' => $subtotal,
            'cart_count' => $cartCount
        ]);
    }

    // Untuk permintaan biasa, tetap redirect
    return redirect()->back()->with('success', 'Jumlah produk diperbarui.');
}

public function remove($id)
{
    $cartItem = CartItem::where('id', $id)
        ->whereHas('cart', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->firstOrFail();

    $cartItem->delete();

    session(['cart_count' => CartItem::whereHas('cart', function ($query) {
        $query->where('user_id', Auth::id());
    })->sum('quantity')]);

    return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
}

public function checkout()
{
    $user = Auth::user();
    $cart = Cart::with('cartItems.product')->where('user_id', $user->id)->first();

    // Pastikan user memiliki keranjang
    if (!$cart || $cart->cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
    }

    return view('checkout.index', [
        'cart' => $cart,
        'user' => $user,
    ]);
}

public function processCheckout(Request $request)
{
    $user = Auth::user();
    $cart = Cart::where('user_id', $user->id)->firstOrFail();

    // Pastikan cart tidak kosong
    if ($cart->cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
    }

    // Buat Order atau Transaksi
    $order = Order::create([
        'user_id' => $user->id,
        'total' => $cart->cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        }),
        'status' => 'pending', // Status order bisa 'pending', 'completed', dll.
    ]);

    // Simpan item cart ke dalam order_items (relasi dengan tabel order_items)
    foreach ($cart->cartItems as $cartItem) {
        $order->orderItems()->create([
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
            'price' => $cartItem->product->price,

        ]);
    }

    // Hapus cart setelah checkout
    $cart->cartItems()->delete();
    session(['cart_count' => 0]);

    return redirect()->route('order.index', $order->id)->with('success', 'Checkout berhasil! Transaksi sedang diproses.');
}



}
