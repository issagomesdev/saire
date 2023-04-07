<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryGalleryPivotTable extends Migration
{
    public function up()
    {
        Schema::create('category_gallery', function (Blueprint $table) {
            $table->unsignedBigInteger('gallery_id');
            $table->foreign('gallery_id', 'gallery_id_fk_8085392')->references('id')->on('galleries')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id', 'category_id_fk_8085392')->references('id')->on('categories')->onDelete('cascade');
        });
    }
}
