<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->unsignedInteger('invoice_id')->nullable();
            $table->unsignedInteger('invoice_item_id')->nullable();
            $table->foreign('invoice_item_id')->references('id')->on('invoice_items');
            $table->unsignedInteger('fee_id')->index()->nullable();
            $table->unsignedInteger('payment_id')->nullable();
            $table->unsignedInteger('class_id')->index();
            $table->string('transaction_type');
            $table->double('amount');
            $table->dateTime('date');
            $table->softDeletes();
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
        Schema::dropIfExists('student_accounts');
    }
}
