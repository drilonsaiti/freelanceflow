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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->ulid()->unique();
            $table->foreignIdFor(\App\Models\Project::class,'project_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class,'freelancer_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class,'client_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Proposal::class,'proposal_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->decimal('rate', 10, 2);
            $table->enum('rate_type',["hourly","fixed"]);
            $table->integer('estimated_days');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status',['draft','active','paused','completed','disputed','cancelled'])->default('draft');
            $table->text('terms')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
