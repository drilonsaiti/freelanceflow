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
        Schema::create('proposals', function (Blueprint $table) {

            $table->id();
            $table->ulid()->unique();
            $table->foreignIdFor(\App\Models\Project::class,'project_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class,'freelancer_id')->constrained()->cascadeOnDelete();
            $table->text('cover_letter');
            $table->decimal('proposed_rate', 10, 2);
            $table->integer('estimated_days');
            $table->enum('status',['pending','accept','rejected','withdrawn'])->default('pending');
            $table->text('client_note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
