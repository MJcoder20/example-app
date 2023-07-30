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
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->float('price');
            $table->string('image');
            $table->tinyInteger('is_active');
            $table->tinyInteger('available');
            $table->integer('total_purchases');
            $table->float('total_sales');
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->unique(['brand_id', 'name']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
