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
            $table->string('escalated_to_team')->nullable()->after('status');
            $table->string('attachment_path')->nullable()->after('escalated_to_team');
            $table->string('root_cause_category')->nullable()->after('resolution_notes');
            $table->string('root_cause_detail')->nullable()->after('root_cause_category');
            $table->text('preventive_measure')->nullable()->after('root_cause_detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('helpdesk_cases', function (Blueprint $table) {
            $table->dropColumn([
                'escalated_to_team',
                'attachment_path',
                'root_cause_category',
                'root_cause_detail',
                'preventive_measure',
            ]);
        });
    }
};
