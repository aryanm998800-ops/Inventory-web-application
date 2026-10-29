<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    private array $tables = [
        'users',
        'categories',
        'products',
        'suppliers',
        'stock_transactions',
    ];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table): void {
                $table->uuid('uuid')->nullable();
            });

            DB::table($tableName)
                ->whereNull('uuid')
                ->orderBy('id')
                ->chunkById(100, function ($records) use ($tableName): void {
                    foreach ($records as $record) {
                        DB::table($tableName)
                            ->where('id', $record->id)
                            ->update(['uuid' => (string) Str::uuid()]);
                    }
                });

            Schema::table($tableName, function (Blueprint $table) use ($tableName): void {
                $table->uuid('uuid')->nullable(false)->change();
                $table->unique('uuid', "{$tableName}_uuid_unique");
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName): void {
                $table->dropUnique("{$tableName}_uuid_unique");
                $table->dropColumn('uuid');
            });
        }
    }
};
