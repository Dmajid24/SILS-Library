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
        Schema::create('lecturer_profiles', function (Blueprint $table) {
           $table->foreignUuid('user_id')
                ->primary()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUuid('school_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('nip')->unique();
            $table->string('degree')->nullable();
            $table->string('department');
            $table->unique(['school_id','nip']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_profiles');
    }
};
