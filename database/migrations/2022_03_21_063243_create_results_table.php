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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('terminal_id');
            $table->bigInteger('class_id');
            $table->bigInteger('section_id');
            $table->bigInteger('subject_id');
            $table->enum('theory_practical',["Yes","No"]);
            $table->bigInteger('obtained_marks')->nullable();
            $table->bigInteger('theory_obtained_marks')->nullable();
            $table->bigInteger('practical_obtained_marks')->nullable();
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
        Schema::dropIfExists('results');
    }
};
