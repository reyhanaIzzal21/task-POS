<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sale::with('customer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('customer_name', 'like', '%' . $search . '%');
            })->orWhere('id', 'like', '%' . $search . '%'); // Cari juga berdasarkan ID transaksi
        }

        // Filter berdasarkan tanggal mulai
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        // Filter berdasarkan tanggal akhir
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter berdasarkan harga minimum
        if ($request->filled('price_from')) {
            $query->where('total_price', '>=', $request->price_from);
        }

        // Filter berdasarkan harga maksimum
        if ($request->filled('price_to')) {
            $query->where('total_price', '<=', $request->price_to);
        }

        $sales = $query->latest()->paginate(10);

        return view('admin.pages.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mengambil data sale beserta relasi customer, detail penjualan, dan produk
        $sale = Sale::with(['customer', 'saleDetails.product'])->findOrFail($id);

        return view('admin.pages.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
