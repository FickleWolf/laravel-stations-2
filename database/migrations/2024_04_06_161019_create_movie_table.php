<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('title', 255)->unique()->comment('映画のタイトル');
            $table->text('image_url')->comment('画像URL');
            $table->integer('published_year')->nullable()->comment('公開年');
            $table->boolean('is_showing')->default(false)->comment('上映中かどうか');
            $table->text('description')->comment('概要');
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
        Schema::dropIfExists('movies');
    }
}
