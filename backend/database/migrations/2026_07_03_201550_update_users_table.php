<?php

use App\Dictionaries\RoleDictionary;
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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('base_language_id')->constrained('languages');
            $table->foreignId('target_language_id')->constrained('languages');
            $table->integer('role')->default(RoleDictionary::ADMIN);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('base_language_id');
            $table->dropColumn('target_language_id');
            $table->dropColumn('role');
        });
    }
};
