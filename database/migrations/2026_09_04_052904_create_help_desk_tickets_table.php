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
        Schema::create('help_desk_tickets', function (Blueprint $table) {

            $table->id();

            // Ticket identification
            $table->string('ticket_number')->unique();

            // User who submitted the ticket
            $table->foreignId('requester_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Department responsible for the ticket
            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            // Office where the issue occurred
            $table->foreignId('office_id')
                ->constrained('offices')
                ->restrictOnDelete();

            // ICT staff assigned to handle the ticket
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Ticket information
            $table->string('category');
            $table->string('priority')->default('medium');
            $table->string('status')->default('open');
            $table->string('subject');
            $table->text('description');

            // Resolution information
            $table->text('resolution')->nullable();

            // Ticket lifecycle timestamps
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            // Laravel timestamps
            $table->timestamps();

            // Indexes
            $table->index(['status', 'priority']);
            $table->index('assigned_to');
            $table->index('department_id');
            $table->index('office_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_desk_tickets');
    }
};
