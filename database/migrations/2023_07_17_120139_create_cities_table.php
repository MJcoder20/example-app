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
        if(Schema::hasTable('cities')) return;

        Schema::create('cities', function (Blueprint $table) {
            $table->id();      
            $table->string('name')->unique();
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')
            ->references('id')->on('countries');
            // $table->foreignId('country_id')->constrained()
            // ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('cities');
    }
};
