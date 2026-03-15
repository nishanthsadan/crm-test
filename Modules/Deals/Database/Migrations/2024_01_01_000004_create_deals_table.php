<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('account_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('stage', ['prospect', 'proposal', 'negotiation', 'won', 'lost'])->default('prospect');
            $table->decimal('value', 15, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->integer('probability')->default(10);
            $table->date('expected_close_date')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
