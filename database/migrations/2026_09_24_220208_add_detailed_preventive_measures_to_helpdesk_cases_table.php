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
            $table->text('preventive_measure_specific')->nullable()->after('preventive_measure');
            $table->text('preventive_measure_systemic')->nullable()->after('preventive_measure_specific');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('helpdesk_cases', function (Blueprint $table) {
            $table->dropColumn(['preventive_measure_specific', 'preventive_measure_systemic']);
        });
    }
};
