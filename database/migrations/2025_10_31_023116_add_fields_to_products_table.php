<?php

use App\Models\Product;
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
            $table->string('code', 12)->nullable()->after('id');
        });
            $products = Product::all();

        foreach ($products as $index => $product) {

            $number = str_pad($index + 1, 9, '0', STR_PAD_LEFT);
            $code = 'COD' . $number;

            $product->code = $code;
            $product->save();
        }


        Schema::table('products', function (Blueprint $table) {
            $table->unique('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropColumn('code');
        });
    }
};
