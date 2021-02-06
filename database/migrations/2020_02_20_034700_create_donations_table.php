<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('campaign_id')->nullable(false);
            $table->decimal('nominal')->nullable(false);
            $table->string('message')->nullable(true);
            $table->string('transaction_uuid')->nullable(false);
            $table->boolean('is_verified')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'campaign_id']);
            $table->unique('transaction_uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
}
