<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('client')->nullable();
            $table->unsignedSmallInteger('year');
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_caption')->nullable();
            $table->text('quote')->nullable();
            $table->json('content_sections')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('metrics')->nullable();
            $table->json('technical_specs')->nullable();
            $table->json('timeline')->nullable();
            $table->json('contributors')->nullable();
            $table->json('testimonial')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
