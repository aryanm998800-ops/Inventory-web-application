<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class UuidTest extends TestCase
{
    use RefreshDatabase;

    public function test_app_records_receive_unique_uuids_and_keep_numeric_keys(): void
    {
        $category = Category::create(['name' => 'Hardware']);
        $secondCategory = Category::create(['name' => 'Office']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Hammer',
        ]);
        $supplier = Supplier::create(['name' => 'Supplier']);
        $user = User::factory()->create();
        $transaction = StockTransaction::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'type' => 'in',
            'quantity' => 1,
        ]);

        $records = [
            $category,
            $secondCategory,
            $product,
            $supplier,
            $user,
            $transaction,
        ];

        foreach ($records as $record) {
            $this->assertTrue(Str::isUuid($record->uuid));
            $this->assertIsInt($record->id);
        }

        $this->assertNotSame($category->uuid, $secondCategory->uuid);
        $this->assertSame($category->id, $product->category_id);
        $this->assertSame($product->id, $transaction->product_id);
        $this->assertSame($user->id, $transaction->user_id);
    }

    public function test_resource_routes_accept_uuid_and_legacy_numeric_ids(): void
    {
        Route::middleware('web')->get('/uuid-test/products/{product}', function (Product $product) {
            return response()->json([
                'id' => $product->id,
                'uuid' => $product->uuid,
            ]);
        });

        $category = Category::create(['name' => 'Hardware']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Hammer',
        ]);

        foreach ([$product->uuid, (string) $product->id] as $identifier) {
            $this->getJson("/uuid-test/products/{$identifier}")
                ->assertOk()
                ->assertJsonPath('id', $product->id)
                ->assertJsonPath('uuid', $product->uuid);
        }

        $this->getJson('/uuid-test/products/not-a-uuid')
            ->assertNotFound();
    }

    public function test_product_crud_works_with_uuid_routes_and_numeric_foreign_keys(): void
    {
        $permissions = collect([
            'create products',
            'view products',
            'edit products',
            'delete products',
        ])->map(fn (string $name) => Permission::create([
            'name' => $name,
            'guard_name' => 'web',
        ]));

        $user = User::factory()->create();
        $user->givePermissionTo($permissions);
        $this->actingAs($user);

        $category = Category::create(['name' => 'Hardware']);

        $this->post('/products', [
            'category_id' => $category->id,
            'unit' => 'piece',
            'purchase_price' => 12.50,
            'sale_price' => 18.00,
            'minimum_stock' => 2,
        ])->assertRedirect(route('products.index'));

        $product = Product::query()->sole();
        $this->assertTrue(Str::isUuid($product->uuid));
        $this->assertSame($category->id, $product->category_id);

        $this->get(route('products.index'))->assertOk();
        $this->get(route('products.show', $product->uuid))->assertOk();
        $this->get("/products/{$product->id}")->assertOk();
        $this->get(route('products.edit', $product->uuid))->assertOk();

        $this->put(route('products.update', $product->uuid), [
            'category_id' => $category->id,
            'barcode' => null,
            'unit' => 'piece',
            'purchase_price' => 14.00,
            'sale_price' => 20.00,
            'minimum_stock' => 3,
            'is_active' => true,
            'description' => 'Updated product',
        ])->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'uuid' => $product->uuid,
            'category_id' => $category->id,
            'purchase_price' => 14.00,
            'minimum_stock' => 3,
        ]);

        $this->delete("/products/{$product->id}")
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_model_json_includes_uuid_without_removing_numeric_id(): void
    {
        $category = Category::create(['name' => 'Hardware']);

        $this->assertSame($category->id, $category->toArray()['id']);
        $this->assertSame($category->uuid, $category->toArray()['uuid']);
    }

    public function test_category_quick_add_keeps_numeric_id_and_adds_uuid(): void
    {
        Permission::create([
            'name' => 'create categories',
            'guard_name' => 'web',
        ]);

        $user = User::factory()->create();
        $user->givePermissionTo('create categories');

        $response = $this->actingAs($user)
            ->postJson('/products/category-quick-add', ['name' => 'Hardware']);

        $response->assertCreated()
            ->assertJsonPath('category.id', 1)
            ->assertJsonPath('category.name', 'Hardware');

        $uuid = $response->json('category.uuid');
        $this->assertTrue(Str::isUuid($uuid));

        $this->actingAs($user)
            ->postJson('/products/category-quick-add', ['name' => 'Hardware'])
            ->assertOk()
            ->assertJsonPath('category.id', 1)
            ->assertJsonPath('category.uuid', $uuid)
            ->assertJsonPath('already_exists', true);
    }
}
