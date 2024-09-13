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
        Schema::create('kits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_center_id');
            $table->string('LCN',50);
            $table->string('partsLCN',50);
            $table->string('brand',50);
            $table->string('model',50);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('productSerialNumber',50);
            $table->unsignedBigInteger('country_id');
            $table->string('dateManufactured',50);
            $table->boolean('isComplete');
            $table->float('estimatedRetailPrice',10,2);
            $table->mediumText('notes');
            $table->unsignedBigInteger('user_id');
            $table->string('kitImageUrl');
            $table->timestamps();
            $table->foreign('work_center_id')->references('id')->on('work_centers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kits');
    }
};
