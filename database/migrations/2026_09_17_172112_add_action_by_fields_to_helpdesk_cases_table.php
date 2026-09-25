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
        Schema::table('helpdesk_cases', function (Blueprint $table) {
            $table->foreignId('analyzing_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('in_progress_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('helpdesk_cases', function (Blueprint $table) {
            $table->dropForeign(['analyzing_by']);
            $table->dropForeign(['in_progress_by']);
            $table->dropForeign(['resolved_by']);
            $table->dropForeign(['closed_by']);
            $table->dropColumn(['analyzing_by', 'in_progress_by', 'resolved_by', 'closed_by']);
        });
    }
};
