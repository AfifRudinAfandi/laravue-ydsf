<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('admin_id')->nullable(false);
            $table->unsignedInteger('regional_id')->nullable(false);
            $table->unsignedInteger('campaign_category_id')->nullable(false);
            $table->string('title', 100)->nullable(false);
            $table->longText('content')->nullable(false);
            $table->string('location', 100)->nullable(false);
            $table->decimal('max_nominal')->nullable(true);
            $table->timestamp('max_time')->nullable(true);
            $table->string('cover_image_url')->nullable(true);
            $table->string('video_url')->nullable(true);
            $table->string('tags')->nullable(true);
            $table->string('slug')->nullable(false);
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_published')->default(0);
            $table->timestamps();

            $table->index([
                'admin_id', 'regional_id', 'campaign_category_id', 'slug'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
