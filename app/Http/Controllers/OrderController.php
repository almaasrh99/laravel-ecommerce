<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil semua order untuk user yang sedang login
        $orders = Order::with('orderItems.product') // Ambil order beserta order items dan produk
                       ->where('user_id', Auth::id()) // Filter berdasarkan user yang login
                       ->latest() // Urutkan berdasarkan tanggal terbaru
                       ->get();


        // Kirim data pesanan ke view
        return view('order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);
        return view('order.show', compact('order'));
    }



}
