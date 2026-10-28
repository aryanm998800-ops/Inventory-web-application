
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post(
    '/products/category-quick-add',
    [CategoryController::class, 'store']
)
    ->middleware('can:create categories')
    ->name('products.categories.quick-store');

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('can:view dashboard')
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('users')
        ->name('users.')
        ->controller(UserController::class)
        ->middleware('can:manage users')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');

            // Keep the static create route above dynamic user routes.
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::get('/{user}', 'show')->name('show');

            Route::put('/{user}', 'update')->name('update');
            Route::delete('/{user}', 'destroy')->name('destroy');
        });

   

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */
    Route::get('/products', [ProductController::class, 'index'])
        ->middleware('can:view products')
        ->name('products.index');

    Route::get('/products/create', [ProductController::class, 'create'])
        ->middleware('can:create products')
        ->name('products.create');

    Route::post('/products', [ProductController::class, 'store'])
        ->middleware('can:create products')
        ->name('products.store');

    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->middleware('can:view products')
        ->name('products.show');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->middleware('can:edit products')
        ->name('products.edit');

    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->middleware('can:edit products')
        ->name('products.update');

    Route::patch('/products/{product}', [ProductController::class, 'update'])
        ->middleware('can:edit products')
        ->name('products.update.patch');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->middleware('can:delete products')
        ->name('products.destroy');

    /*
    |--------------------------------------------------------------------------
    | Suppliers
    |--------------------------------------------------------------------------
    */
    Route::get('/suppliers', [SupplierController::class, 'index'])
        ->middleware('can:view suppliers')
        ->name('suppliers.index');

    Route::get('/suppliers/create', [SupplierController::class, 'create'])
        ->middleware('can:create suppliers')
        ->name('suppliers.create');

    Route::post('/suppliers', [SupplierController::class, 'store'])
        ->middleware('can:create suppliers')
        ->name('suppliers.store');

    Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])
        ->middleware('can:view suppliers')
        ->name('suppliers.show');

    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])
        ->middleware('can:edit suppliers')
        ->name('suppliers.edit');

    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])
        ->middleware('can:edit suppliers')
        ->name('suppliers.update');

    Route::patch('/suppliers/{supplier}', [SupplierController::class, 'update'])
        ->middleware('can:edit suppliers')
        ->name('suppliers.update.patch');

    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])
        ->middleware('can:delete suppliers')
        ->name('suppliers.destroy');

    /*
    |--------------------------------------------------------------------------
    | Stock Management
    |--------------------------------------------------------------------------
    */
    Route::get('/stock', [StockTransactionController::class, 'index'])
        ->middleware('can:view stock')
        ->name('stock.index');

    Route::get('/stock/history', [StockTransactionController::class, 'history'])
        ->middleware('can:view stock')
        ->name('stock.history');

    Route::get('/stock/in', [StockTransactionController::class, 'createIn'])
        ->middleware('can:stock in')
        ->name('stock.create-in');

    Route::post('/stock/in', [StockTransactionController::class, 'storeIn'])
        ->middleware('can:stock in')
        ->name('stock.store-in');

    Route::get('/stock/out', [StockTransactionController::class, 'createOut'])
        ->middleware('can:stock out')
        ->name('stock.create-out');

    Route::post('/stock/out', [StockTransactionController::class, 'storeOut'])
        ->middleware('can:stock out')
        ->name('stock.store-out');

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */
    Route::prefix('reports')
        ->name('reports.')
        ->controller(ReportController::class)
        ->middleware('can:view reports')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/stock', 'stock')->name('stock');
            Route::get('/transactions', 'transactions')
                ->name('transactions');
            Route::get('/valuation', 'valuation')
                ->name('valuation');
            Route::get('/low-stock', 'lowStock')
                ->name('low-stock');
        });
});

/*
|--------------------------------------------------------------------------
| Root Route
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/dashboard');
