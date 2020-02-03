<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('slug');
            $table->integer('parent_id')->nullable()->references('id')
                ->on('regions')->onDelete('CASCADE');
            $table->timestamps();
            $table->unique(['parent_id', 'slug']);
            $table->unique(['parent_id', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
