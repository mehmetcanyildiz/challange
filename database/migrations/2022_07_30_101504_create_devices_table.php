<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) { // devices
            $table->id();
            $table->unsignedBigInteger('app_id');
            $table->unsignedBigInteger('uid')->unique();
            $table->string('language',20);
            $table->enum('os', ['ios', 'android']);
            $table->string('token',100)->unique();
            $table->timestamps();
            $table->foreign('app_id')->references('id')->on('apps')->onDelete('cascade');
            $table->index('app_id');
            $table->index('uid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
};
