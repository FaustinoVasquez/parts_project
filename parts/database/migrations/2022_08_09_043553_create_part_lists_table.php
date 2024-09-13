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
        Schema::create('part_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('PartSequence');
            $table->string('PartName',50);
            $table->string('PartNameCode',5);
            $table->boolean('IsRequired');
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
        Schema::dropIfExists('part_lists');
    }
};
