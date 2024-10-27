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
            $table->string('validated_by')->nullable();
            $table->dateTime('validated_on')->nullable();
            $table->string('acknowledgedqao_by')->nullable();
            $table->dateTime('acknowledgedqao_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaintforms', function (Blueprint $table) {
            $table->dropColumn(['validated_by', 'validated_on', 'acknowledgedqao_by', 'acknowledgedqao_on']);
        });
    }
};
