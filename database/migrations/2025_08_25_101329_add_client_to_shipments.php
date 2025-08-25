<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('shipment', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('shipment', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
    }
};
