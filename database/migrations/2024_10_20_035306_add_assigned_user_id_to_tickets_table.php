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
            // Remove the assigned_user_id foreign key and column if it exists
            if (Schema::hasColumn('tickets', 'assigned_user_id')) {
                $table->dropForeign(['assigned_user_id']);
                $table->dropColumn('assigned_user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This method is optional since we're dropping the column in the up() method
    }
};
