<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table): void {

            $table->increments('id');
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group_slug');
            $table->timestamps();
            $table->unique(['key', 'group_slug'], 'settings_unique_fields');
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
