<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('chat')->nullable();
            $table->integer('viewers')->default(0);
            $table->integer('status')->default(0); // например, статус комнаты
            $table->string('preview_image')->nullable();
            $table->string('chat_url')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('location')->nullable();
            $table->boolean('new')->default(false);
            $table->boolean('hd')->default(false);
            $table->integer('age')->nullable();
            $table->timestamps();
            // Добавьте другие поля, если необходимо
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
