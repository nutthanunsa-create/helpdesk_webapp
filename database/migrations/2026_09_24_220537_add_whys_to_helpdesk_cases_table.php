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
            $table->text('why_1')->nullable()->after('root_cause_category');
            $table->text('why_2')->nullable()->after('why_1');
            $table->text('why_3')->nullable()->after('why_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('helpdesk_cases', function (Blueprint $table) {
            $table->dropColumn(['why_1', 'why_2', 'why_3']);
        });
    }
};
