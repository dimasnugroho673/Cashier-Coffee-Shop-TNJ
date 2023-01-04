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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name');
            $table->string('from')->nullable();
            $table->unsignedBigInteger('TypeIcome_id');
            $table->float('price');
            $table->text('desc')->nullable();
            $table->timestamps();

            $table->foreign('TypeIcome_id')->references('id')->on('type_incomes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incomes');
    }
};
