<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('member_plan');
            $table->bigInteger('member');
            $table->bigInteger('member_id');
            $table->float('paid',10,2);
            $table->timestamp('to')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('members_subs');
    }
}
