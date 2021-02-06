<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->nullable(false);
            $table->string('title', 100)->nullable(false);
            $table->string('cover_image_url')->nullable(true);
            $table->mediumText('description')->nullable(true);
            $table->string('file_url')->nullable(false);
            $table->boolean('is_published')->default(0);
            $table->timestamps();

            $table->index('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rewards');
    }
}
