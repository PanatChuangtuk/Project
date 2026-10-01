<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loan_equipment', function (Blueprint $table) {
            // สภาพอุปกรณ์ตอนตรวจรับคืน: normal / damaged / lost (null = ยังไม่ได้ตรวจรับ)
            $table->string('condition', 20)->nullable()->after('quantity');
            $table->string('condition_note', 255)->nullable()->after('condition');
        });
    }

    public function down(): void
    {
        Schema::table('loan_equipment', function (Blueprint $table) {
            $table->dropColumn(['condition', 'condition_note']);
        });
    }
};
