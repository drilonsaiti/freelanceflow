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
        //
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['freelancer', 'client','admin'])->nullable();
            $table->string('avatar')->default('default.png')->after('name');
            $table->text('bio')->nullable()->after('avatar');
            $table->integer('hourly_rate')->nullable()->after('bio');
            $table->boolean('is_active')->default(true)->after('hourly_rate');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role','avatar','bio','hourly_rate','is_active']);
        });
    }
};
