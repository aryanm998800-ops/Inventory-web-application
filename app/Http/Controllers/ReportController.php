<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    /**
     * Reports dashboard.
     */
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        $stockTotals = $this->getStockTotals();

        $totalProducts = $products->count();
        $lowStockCount = 0;
        $totalStockValue = 0;

        foreach ($products as $product) {
            $totals = $stockTotals->get($product->id);

            $currentStock = (int) ($totals->total_in ?? 0)
                - (int) ($totals->total_out ?? 0);

            if ($currentStock <= $product->minimum_stock) {
                $lowStockCount++;
            }

            $totalStockValue += $currentStock
                * (float) $product->purchase_price;
        }

        $totalTransactions = StockTransaction::count();

        return view('reports.index', compact(
            'totalProducts',
            'lowStockCount',
            'totalStockValue',
            'totalTransactions'
        ));
    }

    /**
     * Current stock report.
     */
    public function stock()
    {
        $products = Product::with('category')
            ->orderBy('name')
            ->paginate(15);

        $stockTotals = $this->getStockTotals();

        $products->getCollection()->transform(
            function ($product) use ($stockTotals) {
                $totals = $stockTotals->get($product->id);

                $product->current_stock =
                    (int) ($totals->total_in ?? 0)
                    - (int) ($totals->total_out ?? 0);

                return $product;
            }
        );

        return view('reports.stock', compact('products'));
    }

    /**
     * Stock transaction report with filters.
     */
    public function transactions(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'nullable',
                'integer',
                Rule::exists('products', 'id'),
            ],
            'type' => ['nullable', Rule::in(['in', 'out'])],
            'date_from' => ['nullable', 'date'],
            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],
        ]);

        $query = StockTransaction::with(['product', 'user'])
            ->when(
                !empty($validated['product_id']),
                fn ($q) => $q->where(
                    'product_id',
                    $validated['product_id']
                )
            )
            ->when(
                !empty($validated['type']),
                fn ($q) => $q->where('type', $validated['type'])
            )
            ->when(
                !empty($validated['date_from']),
                fn ($q) => $q->whereDate(
                    'transaction_date',
                    '>=',
                    $validated['date_from']
                )
            )
            ->when(
                !empty($validated['date_to']),
                fn ($q) => $q->whereDate(
                    'transaction_date',
                    '<=',
                    $validated['date_to']
                )
            );

        $transactions = $query
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $products = Product::orderBy('name')->get();

        return view('reports.transactions', compact(
            'transactions',
            'products'
        ));
    }

    /**
     * Current inventory valuation.
     */
    public function valuation()
    {
        $products = Product::with('category')
            ->orderBy('name')
            ->paginate(15);

        $stockTotals = $this->getStockTotals();

        $products->getCollection()->transform(
            function ($product) use ($stockTotals) {
                $totals = $stockTotals->get($product->id);

                $product->current_stock =
                    (int) ($totals->total_in ?? 0)
                    - (int) ($totals->total_out ?? 0);

                $product->stock_value = $product->current_stock
                    * (float) $product->purchase_price;

                return $product;
            }
        );

        return view('reports.valuation', compact('products'));
    }

    /**
     * Products at or below their minimum stock level.
     */
    public function lowStock()
    {
        $stockTotals = $this->getStockTotals();

        $products = Product::with('category')
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function ($product) use ($stockTotals) {
                $totals = $stockTotals->get($product->id);

                $product->current_stock =
                    (int) ($totals->total_in ?? 0)
                    - (int) ($totals->total_out ?? 0);

                return $product;
            })
            ->filter(function ($product) {
                return $product->current_stock
                    <= $product->minimum_stock;
            })
            ->values();

        return view('reports.low-stock', compact('products'));
    }

    /**
     * Calculate stock totals from existing transactions.
     */
    private function getStockTotals()
    {
        return StockTransaction::query()
            ->selectRaw("
                product_id,
                COALESCE(
                    SUM(CASE WHEN type = 'in' THEN quantity ELSE 0 END),
                    0
                ) AS total_in,
                COALESCE(
                    SUM(CASE WHEN type = 'out' THEN quantity ELSE 0 END),
                    0
                ) AS total_out
            ")
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');
    }
}
