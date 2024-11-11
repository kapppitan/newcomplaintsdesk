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
        Schema::table('complaints', function (Blueprint $table) {
            $table->timestamp('verified_at')->nullable();
        });

        Schema::create('corrective', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('complaint_id')->references('id')->on('complaints')->onDelete('cascade');
            $table->mediumText('corrective_action');
            $table->timestamp('implementation_date');
            $table->string('effectiveness');
            $table->string('monitoring_period');
            $table->string('responsible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['verified_at']);
        });

        Schema::dropIfExists('corrective');
    }
};
