<?php

use App\Dictionaries\StatusWordDictionary;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_translation_id')->constrained('word_translations');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('repeat')->default(0);
            $table->integer('status')->default(StatusWordDictionary::NONE);
            $table->dateTime('last_time_repeated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
