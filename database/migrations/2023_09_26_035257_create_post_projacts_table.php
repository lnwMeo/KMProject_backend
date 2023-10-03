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
        Schema::create('post_projacts', function (Blueprint $table) {
            $table->id();
            $table->string('titlenameprojact');
            $table->string('titleimgprojact')->nullable();
            $table->string('creatornameprojact');
            $table->string('creatorimgprojact')->nullable();
            $table->integer('yearcreatedprojact');
            $table->longText('contentprojact');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_projacts');
    }
};
