<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_progress', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('admin_id')->nullable(false);
            $table->unsignedBigInteger('campaign_id')->nullable(false);
            $table->string('title', 100)->nullable(false);
            $table->longText('content')->nullable(false);
            $table->string('video_url');
            $table->timestamps();

            $table->index(['admin_id', 'campaign_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::dropIfExists('campaign_progress');
    }
}
