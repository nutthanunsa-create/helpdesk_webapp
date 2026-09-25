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
        Schema::create('helpdesk_cases', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->string('priority')->default('medium'); // urgent, high, medium, low
            $table->string('status')->default('pending'); // pending, in_progress, resolved, closed, cancelled
            $table->string('requester_name');
            $table->string('requester_email')->nullable();
            $table->string('requester_phone')->nullable();
            $table->string('department');
            $table->string('location')->nullable();
            $table->string('assigned_to')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamp('sla_due_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helpdesk_cases');
    }
};
