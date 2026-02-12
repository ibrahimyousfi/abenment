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
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gym_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->date('maintenance_date');
            $table->date('next_maintenance_date')->nullable();
            $table->string('status')->default('completed'); // pending, in_progress, completed
            $table->string('performed_by')->nullable(); // Technician name or company
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
