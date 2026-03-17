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
        Schema::create('books', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->foreignUuid('school_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('isbn')->nullable()->index();

            $table->string('title');

            $table->text('description')->nullable();

            $table->integer('page')->nullable();

            $table->string('author')->index();

            $table->string('publisher')->nullable();

            $table->integer('stock')->default(0);

            // cover image
            $table->string('cover')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};