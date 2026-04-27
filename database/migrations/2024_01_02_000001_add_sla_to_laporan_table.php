<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->unsignedSmallInteger('estimasi_hari')->nullable()->after('catatan_ai');
            $table->timestamp('tenggat_sla')->nullable()->after('estimasi_hari');
        });
    }

    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn(['estimasi_hari', 'tenggat_sla']);
        });
    }
};
