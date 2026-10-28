<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StockTransactionController extends Controller
{
    /**
     * Display current stock for all products.
     */
    public function index()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->orderBy('name')
            ->paginate(10);

        $stockTotals = StockTransaction::query()
            ->selectRaw("
                product_id,
                SUM(CASE WHEN type = 'in' THEN quantity ELSE 0 END) AS total_in,
                SUM(CASE WHEN type = 'out' THEN quantity ELSE 0 END) AS total_out
            ")
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        $products->getCollection()->transform(function ($product) use ($stockTotals) {
            $totals = $stockTotals->get($product->id);

            $totalIn = (int) ($totals->total_in ?? 0);
            $totalOut = (int) ($totals->total_out ?? 0);

            $product->current_stock = $totalIn - $totalOut;

            return $product;
        });

        $totalProducts = Product::count();

        $lowStockCount = Product::where('is_active', true)
            ->get()
            ->filter(function ($product) use ($stockTotals) {
                $totals = $stockTotals->get($product->id);

                $available = (int) ($totals->total_in ?? 0)
                    - (int) ($totals->total_out ?? 0);

                return $available <= $product->minimum_stock;
            })
            ->count();

        return view('stock.index', compact(
            'products',
            'totalProducts',
            'lowStockCount'
        ));
    }

    /**
     * Show the Stock In form.
     */
    public function createIn()
    {
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('stock.create-in', compact('products'));
    }

    /**
     * Show the Stock Out form.
     */
    public function createOut()
    {
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        $stockTotals = StockTransaction::query()
            ->selectRaw("
                product_id,
                SUM(CASE WHEN type = 'in' THEN quantity ELSE 0 END) AS total_in,
                SUM(CASE WHEN type = 'out' THEN quantity ELSE 0 END) AS total_out
            ")
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        $products->each(function ($product) use ($stockTotals) {
            $totals = $stockTotals->get($product->id);

            $product->current_stock =
                (int) ($totals->total_in ?? 0)
                - (int) ($totals->total_out ?? 0);
        });

        return view('stock.create-out', compact('products'));
    }

    /**
     * Save Stock In transaction.
     */
    public function storeIn(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where('is_active', true),
            ],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_cost' => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'transaction_date' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($validated) {
            StockTransaction::create([
                'product_id' => $validated['product_id'],
                'user_id' => Auth::id(),
                'type' => 'in',
                'quantity' => $validated['quantity'],
                'unit_cost' => $validated['unit_cost'] ?? null,
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'transaction_date' => $validated['transaction_date'],
            ]);
        });

        return redirect()->route('stock.index')
            ->with('success', 'Stock received successfully.');
    }

    /**
     * Save Stock Out transaction.
     */
    public function storeOut(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where('is_active', true),
            ],
            'quantity' => ['required', 'integer', 'min:1'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'transaction_date' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($validated) {
            $productId = (int) $validated['product_id'];

            // Lock the product row while checking and recording stock.
            Product::whereKey($productId)->lockForUpdate()->firstOrFail();

            $totals = StockTransaction::where('product_id', $productId)
                ->selectRaw("
                    COALESCE(SUM(CASE WHEN type = 'in' THEN quantity ELSE 0 END), 0) AS total_in,
                    COALESCE(SUM(CASE WHEN type = 'out' THEN quantity ELSE 0 END), 0) AS total_out
                ")
                ->first();

            $available = (int) $totals->total_in - (int) $totals->total_out;

            if ((int) $validated['quantity'] > $available) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'quantity' => "Insufficient stock. Available quantity: {$available}.",
                ]);
            }

            StockTransaction::create([
                'product_id' => $productId,
                'user_id' => Auth::id(),
                'type' => 'out',
                'quantity' => $validated['quantity'],
                'unit_cost' => null,
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'transaction_date' => $validated['transaction_date'],
            ]);
        });

        return redirect()->route('stock.index')
            ->with('success', 'Stock issued successfully.');
    }

    /**
     * Display stock transaction history.
     */
    public function history()
    {
        $transactions = StockTransaction::with(['product', 'user'])
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(15);

        return view('stock.history', compact('transactions'));
    }
}
