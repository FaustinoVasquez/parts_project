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
        Schema::create('part_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');
            $table->unsignedBigInteger('part_reference_id');
            $table->timestamps();
            $table->foreign('part_reference_id')->references('id')->on('part_references')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_images');
    }
};
