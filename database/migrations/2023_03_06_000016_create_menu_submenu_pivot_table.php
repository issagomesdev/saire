<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuSubmenuPivotTable extends Migration
{
    public function up()
    {
        Schema::create('menu_submenu', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id');
            $table->foreign('menu_id', 'menu_id_fk_8130869')->references('id')->on('menus')->onDelete('cascade');
            $table->unsignedBigInteger('submenu_id');
            $table->foreign('submenu_id', 'submenu_id_fk_8130869')->references('id')->on('submenus')->onDelete('cascade');
        });
    }
}
