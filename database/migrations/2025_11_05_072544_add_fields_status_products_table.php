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
            // Nếu cột status đã tồn tại, drop và tạo lại
            if (Schema::hasColumn('products', 'status')) {
                $table->dropColumn('status');
            }

            // Thêm cột status với nhiều giá trị
            $table->enum('status', [
                'active',       // Đang bán
                'inactive',     // Ngừng bán
                'draft',        // Bản nháp
                'out_of_stock', // Hết hàng
                'discontinued'  // Ngừng kinh doanh
            ])->default('active')->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
