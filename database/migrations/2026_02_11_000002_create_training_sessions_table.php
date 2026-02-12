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
        Schema::create('training_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gym_id')->constrained()->onDelete('cascade');
            $table->foreignId('training_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('trainer_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('capacity')->default(20);
            $table->string('status')->default('scheduled'); // scheduled, cancelled, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_sessions');
    }
};
