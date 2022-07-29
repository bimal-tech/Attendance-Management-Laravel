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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('class')->nullable();;
            $table->string('roll_no')->nullable();;
            $table->string('batch')->nullable();;
            $table->unsignedBigInteger('user_id')->nullable();;
            $table->unsignedBigInteger('fee_structure_id')->nullable();;
            $table->unsignedBigInteger('scholarship_type_id')->nullable();;
            // $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('fee_structure_id')->references('id')->on('fee_structures')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('scholarship_type_id')->references('id')->on('scholarship_types')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('students');
    }
};
