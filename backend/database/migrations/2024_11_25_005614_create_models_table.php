<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->id(); // Основной ключ
            $table->string('username')->unique(); // Уникальное имя пользователя
            $table->string('status')->default('offline'); // Статус
            $table->integer('viewers')->default(0); // Количество зрителей
            $table->string('subject')->nullable(); // Тема трансляции
            $table->boolean('hd')->default(false); // Наличие HD
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Пол
            $table->integer('age')->nullable(); // Возраст
            $table->string('preview_image')->nullable(); // Превью изображение
            $table->string('chat_url')->nullable(); // URL чата
            $table->string('embed_url')->nullable(); // Встраиваемый URL
            $table->float('rating')->default(0); // Рейтинг
            $table->timestamps(); // created_at и updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('models');
    }
}
