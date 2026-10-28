<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display the products list.
     */
    public function index(): View
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Show the product creation form.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a new product.
     * The selected category name becomes the product name.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],

            'unit' => [
                'required',
                Rule::in([
                    'piece',
                    'kg',
                    'gram',
                    'liter',
                    'meter',
                    'box',
                    'pack',
                    'dozen',
                ]),
            ],

            'purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'sale_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        $category = Category::findOrFail($validated['category_id']);

        $validated['name'] = $category->name;
        $validated['is_active'] = true;
        $validated['barcode'] = null;
        $validated['description'] = null;

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display a specific product.
     */
    public function show(Product $product): View
    {
        $product->load([
            'category',
            'stockTransactions',
        ]);

        return view('products.show', compact('product'));
    }

    /**
     * Show the product edit form.
     */
    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view(
            'products.edit',
            compact('product', 'categories')
        );
    }

    /**
     * Update an existing product.
     * Its name always matches its selected category.
     */
    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],

            'barcode' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'barcode')
                    ->ignore($product->id),
            ],

            'unit' => [
                'required',
                Rule::in([
                    'piece',
                    'kg',
                    'gram',
                    'liter',
                    'meter',
                    'box',
                    'pack',
                    'dozen',
                ]),
            ],

            'purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'sale_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $category = Category::findOrFail($validated['category_id']);

        $validated['name'] = $category->name;

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Delete a product only if it has no stock history.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->stockTransactions()->exists()) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'This product cannot be deleted because it has stock transaction history.'
                );
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
