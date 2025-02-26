<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('exams', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title'); // ✅ Tambahkan description
            $table->integer('duration')->default(60)->after('description'); // ✅ Tambahkan duration
        });
    }

    public function down() {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn(['description', 'duration']); // ✅ Hapus jika rollback
        });
    }
};
