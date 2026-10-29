<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\Supplier;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private const PRICE_CANDIDATES = [
        'cost_price',
        'purchase_price',
        'unit_price',
        'price',
        'selling_price',
        'unit_cost',
        'cost',
        'purchase_cost',
        'product_price',
        'rate',
    ];

    private bool $priceResolved = false;
    private ?string $priceCol = null;

    private function priceColumn(): ?string
    {
        if (! $this->priceResolved) {
            if (Schema::hasTable('products')) {
                foreach (self::PRICE_CANDIDATES as $column) {
                    if (Schema::hasColumn('products', $column)) {
                        $this->priceCol = $column;
                        break;
                    }
                }
            }

            $this->priceResolved = true;
        }

        return $this->priceCol;
    }

    private function priceSql(): string
    {
        $column = $this->priceColumn();

        return $column ? 'products.' . $column : '0';
    }

    public function index(): View
    {
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        $totalProducts = Product::count();

        $activeProducts = Schema::hasColumn('products', 'is_active')
            ? Product::where('is_active', true)->count()
            : $totalProducts;

        $inactiveProducts = $totalProducts - $activeProducts;

        $products = Product::query()
            ->where(function ($query) {
                if (Schema::hasColumn('products', 'is_active')) {
                    $query->where('is_active', true);
                }
            })
            ->withSum([
                'stockTransactions as stock_in_quantity' =>
                    fn ($query) => $query->where('type', 'in'),
            ], 'quantity')
            ->withSum([
                'stockTransactions as stock_out_quantity' =>
                    fn ($query) => $query->where('type', 'out'),
            ], 'quantity')
            ->get()
            ->each(function ($product) {
                $product->available_stock =
                    (int) ($product->stock_in_quantity ?? 0)
                    - (int) ($product->stock_out_quantity ?? 0);
            });

        $outOfStock = $products->filter(
            fn ($product) => $product->available_stock <= 0
        );

        $lowStock = $products->filter(
            fn ($product) =>
                $product->available_stock > 0
                && $product->available_stock <= (int) $product->minimum_stock
        );

        $inStock = $products->filter(
            fn ($product) =>
                $product->available_stock > (int) $product->minimum_stock
        );

        $lowStockProducts = $lowStock->count() + $outOfStock->count();

        /*
         * Total Inventory Value:
         * Available stock multiplied by the product's unit price.
         */
        $priceColumn = $this->priceColumn();

        $totalValue = 0;

        if ($priceColumn) {
            $totalValue = $products->sum(
                fn ($product) =>
                    max((int) $product->available_stock, 0)
                    * (float) ($product->{$priceColumn} ?? 0)
            );
        }

        $thisMonthStart = now()->startOfMonth();
        $thisMonthEnd = now()->endOfMonth();

        $lastMonthStart = now()->subMonthNoOverflow()->startOfMonth();
        $lastMonthEnd = now()->subMonthNoOverflow()->endOfMonth();

        $stockInThis = (int) StockTransaction::where('type', 'in')
            ->whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])
            ->sum('quantity');

        $stockInLast = (int) StockTransaction::where('type', 'in')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->sum('quantity');

        $newThis = Product::whereBetween(
            'created_at',
            [$thisMonthStart, $thisMonthEnd]
        )->count();

        $newLast = Product::whereBetween(
            'created_at',
            [$lastMonthStart, $lastMonthEnd]
        )->count();

        $stats = [
            'total_products' => [
                'value' => $totalProducts,
            ] + $this->change($newThis, $newLast),

            'low_stock' => [
                'value' => $lowStock->count(),
                'note' => $this->share(
                    $lowStock->count(),
                    $activeProducts
                ),
            ],

            'out_of_stock' => [
                'value' => $outOfStock->count(),
                'note' => $this->share(
                    $outOfStock->count(),
                    $activeProducts
                ),
            ],

            'stock_in' => [
                'value' => $stockInThis,
            ] + $this->change($stockInThis, $stockInLast),
        ];

        $stockStatus = [
            [
                'label' => 'In Stock',
                'count' => $inStock->count(),
                'color' => '#10b981',
            ],
            [
                'label' => 'Low Stock',
                'count' => $lowStock->count(),
                'color' => '#f59e0b',
            ],
            [
                'label' => 'Out of Stock',
                'count' => $outOfStock->count(),
                'color' => '#ef4444',
            ],
            [
                'label' => 'Inactive',
                'count' => $inactiveProducts,
                'color' => '#c4c8d0',
            ],
        ];

        $trend = [
            'labels' => [],
            'values' => [],
            'products' => [],
        ];

        for ($i = 5; $i >= 0; $i--) {
            $end = now()->subMonthsNoOverflow($i)->endOfMonth();

            $value = 0;

            if ($priceColumn) {
                $value = StockTransaction::query()
                    ->join(
                        'products',
                        'products.id',
                        '=',
                        'stock_transactions.product_id'
                    )
                    ->where('stock_transactions.created_at', '<=', $end)
                    ->selectRaw(
                        "SUM(
                            CASE
                                WHEN stock_transactions.type = 'in'
                                THEN stock_transactions.quantity
                                ELSE -stock_transactions.quantity
                            END * " . $this->priceSql() . "
                        ) as total"
                    )
                    ->value('total');
            }

            $trend['labels'][] = $end->format("M 'y");
            $trend['values'][] = max(0, round((float) $value, 2));

            $trend['products'][] = Product::where(
                'created_at',
                '<=',
                $end
            )->count();
        }

        $lowStockItems = $products
            ->filter(
                fn ($product) =>
                    $product->available_stock <= (int) $product->minimum_stock
            )
            ->sortBy('available_stock')
            ->take(5)
            ->map(fn ($product) => [
                'name' => $product->name,
                'stock' => $product->available_stock,
                'reorder' => (int) $product->minimum_stock,
                'out' => $product->available_stock <= 0,
                'url' => route('products.show', $product),
            ])
            ->values();

        $activities = StockTransaction::with('product:id,name')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($transaction) => [
                'type' => $transaction->type,
                'title' => $transaction->type === 'in'
                    ? 'Stock In'
                    : 'Stock Out',
                'desc' => $transaction->product?->name ?? 'Deleted product',
                'amount' => ($transaction->type === 'in' ? '+' : '-')
                    . number_format($transaction->quantity)
                    . ' Units',
                'date' => $transaction->created_at->format('M d, Y h:i A'),
            ]);

        return view('dashboard', compact(
            'totalCategories',
            'totalSuppliers',
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'totalValue',
            'stats',
            'stockStatus',
            'trend',
            'lowStockItems',
            'activities'
        ));
    }

    private function change(int|float $current, int|float $previous): array
    {
        if ($previous == 0) {
            return [
                'change' => $current > 0 ? 100 : 0,
                'dir' => 'up',
            ];
        }

        $percentage = (($current - $previous) / $previous) * 100;

        return [
            'change' => abs(round($percentage)),
            'dir' => $percentage >= 0 ? 'up' : 'down',
        ];
    }

    private function share(int $count, int $total): string
    {
        return $total > 0
            ? round($count / $total * 100) . '% of active products'
            : 'No active products';
    }
}
