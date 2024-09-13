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
        Schema::create('part_references', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kit_id');
            $table->string('partName',50);
            $table->string('partValue',50);
            $table->string('partWeight',50);
            $table->string('partRef1',50);
            $table->string('partRef2',50);
            $table->string('partRef3',50);
            $table->timestamps();
            $table->foreign('kit_id')->references('id')->on('kits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_references');
    }
};
