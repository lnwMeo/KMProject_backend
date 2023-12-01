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
        Schema::create('postkms', function (Blueprint $table) {
            $table->id();
            $table->string('titlename');
            $table->string('titleimg')->nullable();
            $table->string('creatorname');
            $table->string('creatorimg')->nullable();
            $table->integer('yearcreated');
            $table->longText('content')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postkms');
    }
};
