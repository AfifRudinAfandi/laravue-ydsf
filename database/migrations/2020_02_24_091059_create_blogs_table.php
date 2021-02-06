<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('admin_id')->nullable(false);
            $table->string('title')->nullable(false);
            $table->longText('content')->nullable(false);
            $table->string('cover_image_url')->nullable(true);
            $table->string('tags')->nullable(true);
            $table->string('slug')->nullable(false);
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_published')->default(0);
            $table->timestamps();

            $table->index(['admin_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
