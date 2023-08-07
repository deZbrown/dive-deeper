<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', static function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained(); // User foreign key
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->foreignId('pomodoro_id')->nullable()->constrained();
            $table->foreignId('calendar_id')->nullable()->constrained();
            $table->foreignId('project_id')->nullable()->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
