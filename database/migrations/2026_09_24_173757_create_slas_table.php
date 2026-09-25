<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('slas', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('priority');
            $table->integer('hours')->default(24);
            $table->string('name_th');
            $table->timestamps();

            $table->unique(['company', 'priority']);
        });

        $companies = [
            'Grand SK',
            'S.K. Polymer',
            'Thairubbtech',
            'Polymate',
            'GTK Smart Solution',
        ];

        $data = [];
        foreach ($companies as $company) {
            $data[] = ['company' => $company, 'priority' => 'urgent', 'hours' => 2, 'name_th' => 'ด่วนที่สุด', 'created_at' => now(), 'updated_at' => now()];
            $data[] = ['company' => $company, 'priority' => 'high', 'hours' => 4, 'name_th' => 'สูง', 'created_at' => now(), 'updated_at' => now()];
            $data[] = ['company' => $company, 'priority' => 'medium', 'hours' => 24, 'name_th' => 'ปานกลาง', 'created_at' => now(), 'updated_at' => now()];
            $data[] = ['company' => $company, 'priority' => 'low', 'hours' => 48, 'name_th' => 'ทั่วไป/ต่ำ', 'created_at' => now(), 'updated_at' => now()];
        }

        DB::table('slas')->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slas');
    }
};
