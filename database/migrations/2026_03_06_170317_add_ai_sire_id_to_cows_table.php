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
        Schema::table('cows', function (Blueprint $table) {
            $table->foreignId('ai_sire_id')->nullable()->after('father_id')->constrained('ai_sires')->nullOnDelete();
            $table->dropColumn('sire_name');
        });
    }

    public function down(): void
    {
        Schema::table('cows', function (Blueprint $table) {
            $table->dropForeign(['ai_sire_id']);
            $table->dropColumn('ai_sire_id');
            $table->string('sire_name')->nullable()->after('father_id');
        });
    }
};
