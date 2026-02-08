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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('board_id')
                ->constrained('boards', 'id')
                ->cascadeOnDelete();
            $table->foreignId('column_id')
                ->constrained('columns', 'id')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('priority', [
                'Low',
                'Medium',
                'High',
                'Urgent'
            ])->default('Medium');

            $table->date('due_date')->nullable();
            $table->integer('estimate_minutes')->nullable();
            $table->integer('actual_minutes')->nullable();

            $table->integer('position')
                ->nullable()
                ->default(1);
            $table->boolean('is_archived')->default(false);

            $table->foreignId('created_by')
                ->constrained('users', 'id');
            $table->timestamps();


            $table->index(['column_id', 'position']);
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
