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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('excerpt');
            $table->longText('content');
            $table->string('category');
            $table->string('image');
            $table->string('read_time');
            $table->integer('views')->default(0);
            $table->boolean('is_headline')->default(false);
            $table->boolean('is_secondary_headline')->default(false);
            
            // Reaction metrics
            $table->integer('reactions_suka')->default(0);
            $table->integer('reactions_terkejut')->default(0);
            $table->integer('reactions_inspiratif')->default(0);
            $table->integer('reactions_sedih')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
