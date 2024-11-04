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
        Schema::table('ppn_keluarans', function (Blueprint $table) {
            $table->boolean('is_faktur')->default(0)->after('onhold');
            $table->boolean('dipungut')->default(1)->after('no_faktur');
            $table->boolean('is_expired')->default(0)->after('dipungut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppn_keluarans', function (Blueprint $table) {
            $table->dropColumn('dipungut');
            $table->dropColumn('is_expired');
            $table->dropColumn('is_faktur');
        });
    }
};
