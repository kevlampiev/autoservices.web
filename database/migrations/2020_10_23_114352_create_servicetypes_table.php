<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false)->comment('Название услуги');
            $table->string('slug')->nullable(false)->unique()->comment('текстовый уникальный идентификатор услуги');
            $table->text('description')->nullable(true)->comment('Описание типа услуги (опционально)');
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
        Schema::dropIfExists('servicetypes');
        Schema::dropIfExists('types');
    }
}
