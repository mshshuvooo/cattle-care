<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cows', function (Blueprint $table) {
            $table->id();
            $table->string('cow_id')->unique();
            $table->string('name')->nullable()->unique();
            $table->date('date_of_birth')->nullable();
            $table->string('gender');
            $table->string('status')->default('active');
            $table->text('previous_owner_info')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->unsignedBigInteger('mother_id')->nullable();
            $table->unsignedBigInteger('father_id')->nullable();
            $table->string('sire_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('cows', function (Blueprint $table) {
            $table->foreign('mother_id')->references('id')->on('cows')->nullOnDelete();
            $table->foreign('father_id')->references('id')->on('cows')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cows', function (Blueprint $table) {
            $table->dropForeign(['mother_id']);
            $table->dropForeign(['father_id']);
        });

        Schema::dropIfExists('cows');
    }
};
