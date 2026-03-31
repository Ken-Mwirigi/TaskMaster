<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
      // Run the migrations.
     
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Primary Key [cite: 15, 16, 17]
            $table->string('title'); // Task title [cite: 18, 19, 20]
            $table->date('due_date'); // Deadline [cite: 21, 22, 23]
            $table->enum('priority', ['low', 'medium', 'high']); // Priority level [cite: 24, 25, 26]
            $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending'); // Status [cite: 27, 28, 29, 30]
            $table->timestamps(); // Laravel default (created_at, updated_at) [cite: 31, 32, 33, 34, 35, 36]
        });
    }

    
     //Reverse the migrations.
    
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};