<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['portfolio_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_team');
    }
};
