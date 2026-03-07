<?php

use App\Enums\Breed;
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
        Schema::create('ai_sires', function (Blueprint $table) {
            $table->id();
            $table->string('bull_id')->unique();
            $table->string('name')->nullable();
            $table->enum('breed', array_column(Breed::cases(), 'value'));
            $table->decimal('breed_percentage', 5, 2)->nullable();
            $table->string('owner')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_sires');
    }
};
