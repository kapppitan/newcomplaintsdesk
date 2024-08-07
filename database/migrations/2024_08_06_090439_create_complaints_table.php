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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('user_type');
            $table->integer('complaint_type');
            $table->longText('details');
            $table->string('email');
            $table->integer('phone');
            $table->string('image_path');
            $table->integer('status');
            $table->dateTime('date_submitted')->nullable();
            $table->dateTime('date_verified')->nullable();
            $table->timestamps();

            // $file = $request->file('file')->store('image');
            // $complaint->image = $file;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
