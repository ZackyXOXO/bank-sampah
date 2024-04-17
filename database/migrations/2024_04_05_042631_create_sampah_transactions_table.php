<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sampah_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('bank_sampah_id');
            $table->unsignedBigInteger('category_sampah_id');
            $table->unsignedBigInteger('type_sampah_id');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('bank_sampah_id')->references('id')->on('bank_sampahs')->onDelete('cascade');
            $table->foreign('category_sampah_id')->references('id')->on('category_sampahs')->onDelete('cascade');
            $table->foreign('type_sampah_id')->references('id')->on('sampah_types')->onDelete('cascade');
            $table->integer('sampah_weight');
            $table->integer('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampah_transactions');
    }
};
