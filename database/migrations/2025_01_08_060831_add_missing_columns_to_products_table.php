<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('products', 'slug')) {
                $table->string('slug')->after('name')->unique();
            }
            if (!Schema::hasColumn('products', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('products', 'productable_id')) {
                $table->unsignedBigInteger('productable_id')->after('product_type_id');
            }
            if (!Schema::hasColumn('products', 'productable_type')) {
                $table->string('productable_type')->after('productable_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name', 'slug', 'description', 'productable_id', 'productable_type']);
        });
    }
};
