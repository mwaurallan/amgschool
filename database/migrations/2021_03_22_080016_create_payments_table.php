<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_mode');
            $table->unsignedInteger('student_id')->index()->nullable();
            $table->string('ref_number')->nullable();
            $table->integer('bank_id')->nullable();
            $table->double('amount');
            $table->string('phone_number')->nullable();
            $table->string('BillRefNumber')->nullable();
            $table->string('TransID')->nullable();
            $table->timestamp('TransTime')->nullable();
            $table->string('FirstName')->nullable();
            $table->string('middleName')->nullable();
            $table->string('LastName')->nullable();
            $table->dateTime('received_on')->nullable();
            $table->integer('created_by')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('payments');
    }
}
