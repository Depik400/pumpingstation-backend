<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Дачники
        Schema::create('residents', function (Blueprint $table) {
            $table->id();                       // ID (номер лицевого счета) дачника
            $table->string('fio');              // ФИО дачника
            $table->float('area');              // Площадь огорода дачника
            $table->timestampTz('start_date')->useCurrent();  // Дата подключения дачника к водокачке
            $table->unsignedBigInteger('pumping_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residents');
    }
}
