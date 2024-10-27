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
        Schema::table('complaintforms', function (Blueprint $table) {
            $table->timestamp('validated_on')->nullable()->change();
            $table->timestamp('acknowledgedqao_on')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaintforms', function (Blueprint $table) {
            $table->timestamp('validated_on')->change();
            $table->timestamp('acknowledgedqao_on')->change();
        });
    }
};
