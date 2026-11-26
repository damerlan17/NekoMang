<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manga', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->string('cover')->nullable();

            $table->string('author')->nullable();
            $table->string('artist')->nullable();

            $table->string('type', 30)->default('manga');
            $table->unsignedSmallInteger('release_year')->nullable();

            $table->string('status', 30)->default('ongoing');

            $table->unsignedBigInteger('views')->default(0);

            $table->timestamps();

            $table->index('title');
            $table->index('type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manga');
    }
};
