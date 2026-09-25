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
            $table->timestamp('analyzing_at')->nullable()->after('in_progress_at');
            $table->timestamp('closed_at')->nullable()->after('resolved_at');
            $table->timestamp('cancelled_at')->nullable()->after('closed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('helpdesk_cases', function (Blueprint $table) {
            $table->dropColumn(['analyzing_at', 'closed_at', 'cancelled_at']);
        });
    }
};
