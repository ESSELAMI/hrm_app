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
        Schema::create('rubriques_values', function (Blueprint $table) {
            $table->id();
            $table->date('day');
            $table->double('value');
            $table->unsignedBigInteger('rubrique_id');
            $table->foreign('rubrique_id')->references('id')->on('rubriques');
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
        Schema::dropIfExists('rubriques_values');
    }
};
