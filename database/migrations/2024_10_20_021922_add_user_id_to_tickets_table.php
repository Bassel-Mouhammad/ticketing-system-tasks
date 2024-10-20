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
        Schema::table('tickets', function (Blueprint $table) {
            // Only add the 'user_id' column if it doesn't exist
            if (!Schema::hasColumn('tickets', 'user_id')) {
                $table->foreignId('user_id')
                    ->constrained('users')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Drop the foreign key and the column if rolled back
            // $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
