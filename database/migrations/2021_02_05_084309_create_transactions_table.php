<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->decimal('amount', 16, 0, true);
            $table->string('currency')->nullable();
            $table->string('gateway');
            $table->string('uuid');
            $table->string('rrn')->nullable();
            $table->string('stan')->nullable();
            $table->morphs('payable');
            $table->string('message')->nullable();
            $table->jsonb('logs')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
