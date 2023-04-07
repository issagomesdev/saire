<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryPublicationPivotTable extends Migration
{
    public function up()
    {
        Schema::create('category_publication', function (Blueprint $table) {
            $table->unsignedBigInteger('publication_id');
            $table->foreign('publication_id', 'publication_id_fk_8085385')->references('id')->on('publications')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id', 'category_id_fk_8085385')->references('id')->on('categories')->onDelete('cascade');
        });
    }
}
