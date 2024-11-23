<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('room_maintenances', function (Blueprint $table) {
            $table->string('assigned_technician')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_maintenances', function (Blueprint $table) {
            $table->dropColumn('assigned_technician');
            $table->dropColumn('scheduled_at');
            $table->dropColumn('completed_at');
        });
    }
};
