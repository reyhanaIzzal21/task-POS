<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
        });

        if ($request->has('search') && $request->search) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%");
            });
        }
        $user = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pages.customers.index', compact('user'));
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
    public function show(User $user)
    {
        // Ambil data sales customer dengan relasi product details
        $sales = $user->sales()->with('saleDetails.product')->latest()->get();

        // Hitung total pembelian
        $totalPurchases = $sales->count();

        // Hitung total amount
        $totalAmount = $sales->sum('total_price');

        // Hitung total items yang dibeli
        $totalItems = $sales->flatMap(function ($sale) {
            return $sale->saleDetails;
        })->sum('product_quantity');

        return view('admin.pages.customers.show', compact('user', 'sales', 'totalPurchases', 'totalAmount', 'totalItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
