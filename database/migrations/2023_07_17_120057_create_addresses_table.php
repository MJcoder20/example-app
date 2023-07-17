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
        if(Schema::hasTable('addresses')) return; 

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->morphs('addressable');
            // $table->foreignId('city_id')
            // ->constrained()
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')
            ->references('id')->on('cities');
            $table->string('district');
            $table->string('street');
            $table->string('phone')->unique();
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
        Schema::dropIfExists('addresses');
    }
};
