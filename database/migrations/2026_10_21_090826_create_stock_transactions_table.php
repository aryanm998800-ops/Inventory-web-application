
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('type', 20);
            $table->unsignedInteger('quantity');

            $table->decimal('unit_cost', 12, 2)->nullable();

            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('transaction_date')->useCurrent();

            $table->timestamps();

            $table->index(['product_id', 'transaction_date']);
            $table->index(['type', 'transaction_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
