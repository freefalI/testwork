<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_attachments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('task_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('image');
            $table->string('thumb_mobile')->nullable();
            $table->string('thumb_desktop')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_attachments');
    }
}
