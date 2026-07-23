<?php

use App\Dictionaries\StatusNewsDictionary;
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
        Schema::table('news', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->string('address')->nullable();
            $table->integer('status')->default(StatusNewsDictionary::APPROVED);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('address');
            $table->dropColumn('status');
        });
    }
};
