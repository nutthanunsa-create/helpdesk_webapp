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
            $table->boolean('requires_preventive_measure')->nullable()->after('resolution_notes');
            $table->timestamp('approved_at')->nullable()->after('resolved_at');
            $table->foreignId('approved_by')->nullable()->constrained('users')->after('resolved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('helpdesk_cases', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['requires_preventive_measure', 'approved_at', 'approved_by']);
        });
    }
};
