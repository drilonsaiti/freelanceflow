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
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->decimal('budget_min', 10, 2)->nullable()->change();
            $table->decimal('budget_max', 10, 2)->nullable()->change();
            $table->string('category')->nullable()->change()->comment('project category');
            $table->json('required_skills')->nullable()->change()->comment('required skills');
            $table->date('deadline')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
};
