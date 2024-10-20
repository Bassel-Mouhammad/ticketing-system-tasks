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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Example: 'pending', 'ongoing', 'finished'
            $table->timestamps();
        });

        // Update the tickets table to include a foreign key to statuses
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->after('description'); // Place status_id after description
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->dropColumn('status'); // Remove the old status column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('status', ['pending', 'ongoing', 'finished']);
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });

        Schema::dropIfExists('statuses');
    }
};
