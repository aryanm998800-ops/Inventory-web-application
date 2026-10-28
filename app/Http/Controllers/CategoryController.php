<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
        ]);

        // Quick-add category from the Product form.
        if ($request->expectsJson()) {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
            ]);

            $existingCategory = Category::where(
                'name',
                $validated['name']
            )->first();

            if ($existingCategory) {
                return response()->json([
                    'message' => 'Category already exists.',
                    'category' => [
                        'id' => $existingCategory->id,
                        'name' => $existingCategory->name,
                    ],
                    'already_exists' => true,
                ]);
            }

            $category = Category::create([
                'name' => $validated['name'],
                'description' => null,
            ]);

            return response()->json([
                'message' => 'Category created successfully.',
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                ],
                'already_exists' => false,
            ], 201);
        }

        // Normal category creation form.
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(
        Request $request,
        Category $category
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->ignore($category->id),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'This category cannot be deleted because products are assigned to it.'
                );
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
