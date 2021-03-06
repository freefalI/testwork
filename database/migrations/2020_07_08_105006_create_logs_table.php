<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->drop('logs');
        Schema::connection('mongodb')-> create('logs', function (Blueprint $table) {
            $table->index('id');
            $table->foreignId('user_id')->constrained();
            $table->string('action');
            $table->string('changes');
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
        Schema::connection('mongodb')->drop('logs');
    }
}
