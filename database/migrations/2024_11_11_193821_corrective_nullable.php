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
        Schema::table('corrective', function (Blueprint $table) {
            $table->mediumText('comment')->nullable()->change();
            $table->boolean('is_approved')->default(false)->change();
            $table->string('document')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('corrective', function (Blueprint $table) {
            $table->mediumText('comment')->change();
            $table->boolean('is_approved')->change();
            $table->string('document')->change();
        });
    }
};
