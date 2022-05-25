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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('father_first_name')->nullable();
            $table->string('father_middle_name')->nullable();
            $table->string('father_last_name')->nullable();
            $table->string('nationality')->default('Nepalese');
            $table->string('profession')->nullable();
            $table->string('qualification')->nullable();
            $table->string('current_district')->nullable();
            $table->string('current_municipality')->nullable();
            $table->string('current_ward_no')->nullable();
            $table->string('current_tole')->nullable();
            $table->string('birth_district')->nullable();
            $table->string('birth_municipality')->nullable();
            $table->string('birth_ward_no')->nullable();
            $table->string('birth_tole')->nullable();
            $table->string('sco_name')->nullable();
            $table->enum('study_type',['Course comlete','Monthly']);
            $table->text('courses')->nullable();
            $table->enum('role',['Admin','Teacher','Student']);
            $table->enum('gender',['Male','Female','No Data'])->default('No Data');
            $table->date('dob')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('telephone_no')->nullable();
            $table->decimal('due_amount',10,2)->default(0);
            $table->enum('status',['Active','Disabled']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
