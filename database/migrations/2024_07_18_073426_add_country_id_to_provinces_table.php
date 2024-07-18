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
        Schema::table('provinces', function (Blueprint $table) {
            $table->unsignedBigInteger("country_id")->nullable()->after("id");
            $table->foreign('country_id', "provinces_fk_country")
            ->references('id')
            ->on('countries')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('provinces', function (Blueprint $table) {
            $table->dropForeign("provinces_fk_country");
            $table->dropColumn("country_id");
        });
        Schema::enableForeignKeyConstraints();
    }
};
