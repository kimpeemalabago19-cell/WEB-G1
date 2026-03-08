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
        // Check if username column exists and rename/create proper columns
        $columns = Schema::getColumnListing('users');
        
        // Add missing columns if they don't exist
        if (!in_array('name', $columns)) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('name')->nullable()->after('id');
            });
        }
        
        if (!in_array('email', $columns)) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('email')->nullable()->unique()->after('name');
            });
        }
        
        if (!in_array('email_verified_at', $columns)) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            });
        }
        
        if (!in_array('remember_token', $columns)) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('remember_token', 100)->nullable()->after('password');
            });
        }
        
        if (!in_array('updated_at', $columns)) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to drop columns in down() as it would lose data
    }
};

