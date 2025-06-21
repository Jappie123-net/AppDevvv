<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove old string fields
            $table->dropColumn(['category', 'supplier']);

            // Add new foreign key fields
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign keys
            $table->dropForeign(['category_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropColumn(['category_id', 'supplier_id']);

            // Optional: add old columns back
            $table->string('category')->nullable();
            $table->string('supplier')->nullable();
        });
    }
};
