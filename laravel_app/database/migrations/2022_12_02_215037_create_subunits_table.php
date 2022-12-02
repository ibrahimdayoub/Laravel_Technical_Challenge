<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubunitsTable extends Migration
{
    public function up()
    {
        Schema::create('subunits', function (Blueprint $table) {
            $table->id();
            $table->string('subunit_name');
            $table->integer('unit_id');
            $table->double('unit_parts');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subunits');
    }
}
