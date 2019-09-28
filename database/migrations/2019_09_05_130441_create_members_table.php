<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('membership_date');
            $table->string('name');
            $table->string('kana_name');
            $table->string('email');
            $table->integer('age');
            $table->string('sex');
            $table->string('car_status');
            $table->string('address');
            $table->string('holiday');
            $table->string('plan_stance');
            $table->string('job');
            $table->string('member_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
