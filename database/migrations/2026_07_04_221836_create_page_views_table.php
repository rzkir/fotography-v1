<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 64)->index();
            $table->string('path');
            $table->string('page_title')->nullable();
            $table->string('ip_address', 45);
            $table->string('country_code', 8)->nullable()->index();
            $table->string('country_name')->nullable();
            $table->string('device_type', 20)->default('unknown')->index();
            $table->text('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->string('referrer_source')->nullable()->index();
            $table->timestamp('viewed_at')->index();
            $table->timestamps();

            $table->index(['path', 'viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
