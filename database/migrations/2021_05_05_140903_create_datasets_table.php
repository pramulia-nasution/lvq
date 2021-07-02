<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatasetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datasets', function (Blueprint $table) {
            $table->id();
            $table->string('x1');
            $table->string('x2');
            $table->string('x3');
            $table->string('x4');
            $table->string('x5');
            $table->string('x6');
            $table->string('x7');
            $table->string('x8');
            $table->string('x9');
            $table->string('x10');
            $table->string('x11');
            $table->string('x12');
            $table->string('x13');
            $table->string('x14');
            $table->string('x15');
            $table->string('x16');
            $table->string('x17');
            $table->string('x18');
            $table->string('x19');
            $table->string('x20');
            $table->string('x21');
            $table->string('x22');
            $table->string('x23');
            $table->string('x24');
            $table->string('x25');
            $table->string('x26');
            $table->string('x27');
            $table->string('x28');
            $table->string('x29');
            $table->string('x30');
            $table->string('x31');
            $table->string('x32');
            $table->string('x33');
            $table->string('x34');
            $table->string('target');
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
        Schema::dropIfExists('datasets');
    }
}
