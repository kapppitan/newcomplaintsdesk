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
        Schema::create('complaintforms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('complaint_id')->references('id')->on('complaints')->onDelete('cascade');
            
            $table->mediumText('immediate_action');
            $table->mediumText('consequence');
            $table->mediumText('root_cause');
            $table->mediumText('nonconformity');

            $table->mediumText('corrective_action');
            $table->dateTime('implementation');
            $table->mediumText('measure');
            $table->string('period');
            $table->string('responsible');

            $table->mediumText('risk_opportunity');
            $table->mediumText('changes');
            $table->string('prepared_by');
            $table->dateTime('prepared_on');
            $table->string('approved_by');
            $table->dateTime('approved_on');
            $table->string('acknowledged_by');
            $table->dateTime('acknowledged_on');

            $table->mediumText('feedback');
            $table->string('reported_by');
            $table->dateTime('date_reported');
            $table->boolean('is_approved');
            $table->string('further_action');

            $table->string('effectiveness');
            $table->string('evidence');
            $table->string('qao_verified_by');
            $table->dateTime('qao_verified_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaintforms');
    }
};
