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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 180);
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete(); // Demandeur
            $table->string('priority')->default('normal'); // urgent|normal|bas
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete(); // Technicien
            $table->string('status')->default('open'); // open|in_progress|resolved|closed
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete(); // réseau, imprimante, etc.
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
