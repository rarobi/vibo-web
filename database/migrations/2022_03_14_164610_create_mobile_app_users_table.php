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
        Schema::create('mobile_app_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('employee_number')->unique();
            $table->string('language');
            $table->string('first_name');
            $table->string('last_name');
            $table->tinyInteger('user_medium')->default(1)->comment('1=email, 2=cell phone');
            $table->string('email');
            $table->string('cell_phone_number')->unique();
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('mobile_app_users');
    }
};
