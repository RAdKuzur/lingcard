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
        Schema::table('words', function (Blueprint $table) {
            $table->index(['language_id']);
        });
        Schema::table('word_translations', function (Blueprint $table) {
           $table->index(['target_language_id', 'word_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('word_translations', function (Blueprint $table) {
            $table->dropIndex(['target_language_id', 'word_id']);
        });
        Schema::table('words', function (Blueprint $table) {
            $table->dropIndex(['language_id']);
        });
    }
};
