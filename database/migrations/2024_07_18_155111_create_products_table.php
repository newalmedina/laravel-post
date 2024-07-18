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
            $table->id();
            $table->unsignedBigInteger("category_id")->nullable();
            $table->string("name");
            $table->string("description")->nullable();
            $table->boolean("unlimited_items")->default(0);
            $table->decimal("ammount", 12, 2)->default(0);
            $table->decimal("price", 16, 4)->default(0);
            $table->decimal("taxes", 12, 2)->default(0);
            $table->decimal("taxes_price", 16, 4)->default(0);
            $table->decimal("total", 16, 4)->default(0);
            $table->boolean("active")->default(1);
            $table->foreign('category_id', "category_fk_products")
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->timestamps();
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
