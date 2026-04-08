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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->foreignUuid('user_id')
                ->primary()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUuid('school_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('nim')->unique();
            $table->string('major');
            $table->string('faculty');
            $table->unique(['school_id','nim']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
