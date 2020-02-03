<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('advert_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->nestedSet();
        });
    }

    public function down()
    {
        Schema::dropIfExists('advert_categories');
    }
}
