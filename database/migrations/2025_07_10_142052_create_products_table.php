<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id_product')->primary();
            $table->string('id_vendor');
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->timestamps();

            $table->foreign('id_vendor')->references('id_vendor')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
