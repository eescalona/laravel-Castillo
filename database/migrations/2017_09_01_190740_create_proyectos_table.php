<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->integer('year')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('style_id')->unsigned()->nullable();
            $table->string('price')->nullable();
            $table->string('description')->nullable();
            $table->string('address')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('styles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('project_id')->unsigned()->index();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->integer('url');

            $table->timestamps();

        });

        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('style_id')
                ->references('id')->on('styles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('files', function (Blueprint $table) {
            $table->foreign('project_id')
                ->references('id')->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('styles');
        Schema::dropIfExists('categories');
    }
}
