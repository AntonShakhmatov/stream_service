<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryAliasesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('country_aliases', function (Blueprint $collection) {
            // Добавьте нужные поля
            $collection->id();
            $collection->string('alias_name'); // Пример поля для имени алиаса
            $collection->foreignId('country_id'); // Внешний ключ для связи с Country
            $collection->timestamps(); // Добавляет поля created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mongodb')->dropIfExists('country_aliases');
    }
}
