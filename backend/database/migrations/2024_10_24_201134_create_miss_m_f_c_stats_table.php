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
        Schema::create('miss_m_f_c_stats', function (Blueprint $table) {
            $table->id();
            $table->date('upload_date')->nullable();
            $table->string('mfc_id');
            $table->string('name');
            $table->integer('rank');
            $table->timestamp('archived_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('miss_m_f_c_stats');
    }
};
