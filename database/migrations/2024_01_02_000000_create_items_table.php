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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->enum('category', ['Clothing', 'Bags', 'Gadgets', 'Documents', 'Accessories', 'Others']);
            $table->enum('status', ['lost', 'found', 'claimed'])->default('lost');
            $table->string('image')->nullable();
            $table->date('date_found')->nullable();
            $table->foreignId('reported_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('claimed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('claim_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

