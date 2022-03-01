<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpcomingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upcomings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('movie');
            $table->bigInteger('screen');
            $table->timestamp('release_on');
            $table->timestamp('release_off')->nullable();
            $table->timestamp('stream')->nullable();
            $table->float('VVIP',10,2)->nullable();
            $table->float('VIP',10,2)->nullable();
            $table->float('Terraces',10,2)->nullable();
            $table->float('Regular',10,2)->nullable();
            $table->string('status');
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
        Schema::dropIfExists('upcomings');
    }
}
