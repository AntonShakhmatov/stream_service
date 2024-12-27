<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryAliasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_aliases', function (Blueprint $table) {
            $table->id(); // Первичный ключ
            $table->string('alias_name'); // Поле для имени алиаса
            $table->foreignId('country_id') // Внешний ключ, связанный с таблицей countries
                ->constrained('countries') // Ссылается на таблицу countries
                ->onDelete('cascade'); // Удаление всех алиасов при удалении страны
            $table->timestamps(); // Поля created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_aliases');
    }
}
