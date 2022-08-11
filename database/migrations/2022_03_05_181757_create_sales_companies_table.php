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
        Schema::create('sales_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_logo')->nullable();
            $table->string('company_id')->unique();
            $table->string('company_name');
            $table->string('language');
            $table->string('street_name')->nullable();
            $table->string('street_number')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('country');
            $table->string('contact_person_first_name')->nullable();
            $table->string('contact_person_last_name')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('contact_person_phone_number')->nullable();
            $table->tinyInteger('is_api_lock_connection')->default(0);
            $table->tinyInteger('is_push_notification')->default(0);
            $table->tinyInteger('is_feedback_option')->default(0);
            $table->string('accepted_payment_methods')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('sales_companies');
    }
};
