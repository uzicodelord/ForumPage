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
        Schema::table('privatemessages', function (Blueprint $table) {
            $table->string('room_id', 10)->after('recipient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('privatemessages', function (Blueprint $table) {
            $table->dropColumn('room_id');
        });
    }
};
