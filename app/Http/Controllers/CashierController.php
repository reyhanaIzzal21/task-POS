<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();
        $members = \App\Models\User::whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
        })->orderBy('name')->get();
        return view('admin.pages.cashier.index', compact('products', 'members'));
    }

    public function checkout(Request $request)
    {
        // Set expected JSON response
        $request->headers->set('Accept', 'application/json');

        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:15',
            'user_id' => 'nullable|exists:users,id',
            'use_point_discount' => 'nullable|boolean',
            'point_to_use' => 'nullable|numeric|min:0',
            'cart' => 'required|array',
            'cart.*.product_id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Get or create customer
            $user = null;
            if ($request->user_id) {
                $user = \App\Models\User::findOrFail($request->user_id);
                $customer = Customer::firstOrCreate(
                    ['customer_name' => $user->name],
                    [
                        'address' => $user->address,
                        'phone_number' => $user->phone_number,
                    ]
                );
            } else {
                $customer = Customer::firstOrCreate(
                    ['customer_name' => $request->customer_name],
                    [
                        'address' => $request->address,
                        'phone_number' => $request->phone_number,
                    ]
                );
            }

            // Calculate subtotal
            $subtotal = 0;
            foreach ($request->cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            // Calculate tax (PPN 11%)
            $taxRate = 0.11;
            $taxAmount = $subtotal * $taxRate;

            // Calculate total (subtotal + tax)
            $totalPrice = $subtotal + $taxAmount;

            // Handle point discount if member
            $pointDiscount = 0;
            if ($user && $request->use_point_discount && $request->point_to_use) {
                $pointDiscount = (int)$request->point_to_use;

                // Validate user has enough points
                if ($user->point < $pointDiscount) {
                    throw new \Exception("Member tidak memiliki poin yang cukup!");
                }

                $totalPrice -= $pointDiscount;
            }

            // Calculate change
            $paidAmount = $request->paid_amount;
            $change = $paidAmount - $totalPrice;

            // Validate payment
            if ($change < 0) {
                throw new \Exception("Uang pembayaran tidak mencukupi! Kurang: Rp " . number_format(abs($change), 0, ',', '.'));
            }

            // Create sale
            $sale = Sale::create([
                'sale_date' => now(),
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_price' => $totalPrice,
                'paid_amount' => $paidAmount,
                'change_amount' => $change,
                'customer_id' => $customer->id,
                'user_id' => Auth::id(),
            ]);

            // Calculate points earned (10 poin per Rp 1000)
            $pointsEarned = (int)($subtotal / 1000) * 10;

            // Create sale details and update stock
            foreach ($request->cart as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Check stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->product_name} tidak mencukupi!");
                }

                // Create sale detail
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'product_quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Update stock
                $product->decrement('stock', $item['quantity']);
            }

            // Update user points if member
            if ($user) {
                if ($request->use_point_discount && $request->point_to_use) {
                    // Subtract used points and add earned points
                    $newPoint = $user->point - $pointDiscount + $pointsEarned;
                } else {
                    // Just add earned points
                    $newPoint = $user->point + $pointsEarned;
                }
                $user->update(['point' => $newPoint]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'sale_id' => $sale->id,
                'redirect_url' => route('cashier.receipt', $sale->id),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function receipt($id)
    {
        $sale = Sale::with(['customer', 'saleDetails.product'])->findOrFail($id);
        return view('admin.pages.cashier.struk.receipt', compact('sale'));
    }
}
