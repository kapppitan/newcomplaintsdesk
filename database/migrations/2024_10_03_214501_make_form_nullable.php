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
            $table->mediumText('immediate_action')->nullable()->change();
            $table->mediumText('consequence')->nullable()->change();
            $table->mediumText('root_cause')->nullable()->change();
            $table->mediumText('nonconformity')->nullable()->change();

            $table->mediumText('corrective_action')->nullable()->change();
            $table->dateTime('implementation')->nullable()->change();
            $table->mediumText('measure')->nullable()->change();
            $table->string('period')->nullable()->change();
            $table->string('responsible')->nullable()->change();

            $table->mediumText('risk_opportunity')->nullable()->change();
            $table->mediumText('changes')->nullable()->change();
            $table->string('prepared_by')->nullable()->change();
            $table->dateTime('prepared_on')->nullable()->change();
            $table->string('approved_by')->nullable()->change();
            $table->dateTime('approved_on')->nullable()->change();
            $table->string('acknowledged_by')->nullable()->change();
            $table->dateTime('acknowledged_on')->nullable()->change();

            $table->mediumText('feedback')->nullable()->change();
            $table->string('reported_by')->nullable()->change();
            $table->dateTime('date_reported')->nullable()->change();
            $table->boolean('is_approved')->nullable()->change();
            $table->string('further_action')->nullable()->change();

            $table->string('effectiveness')->nullable()->change();
            $table->string('evidence')->nullable()->change();
            $table->string('qao_verified_by')->nullable()->change();
            $table->dateTime('qao_verified_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
