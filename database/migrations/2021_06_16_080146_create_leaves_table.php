<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->date('applied_at');
            $table->date('approved_at')->nullable();
            $table->date('from');
            $table->date('to');
            $table->string('type', 50);
            $table->string('reasons', 100);
            $table->char('status', 50);
            $table->foreignId('staff_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('approver_id')->nullable()->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade')->nullable();
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
        Schema::dropIfExists('leaves');
    }
}
