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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('category');
            $table->string('description');
            $table->string('type')->nullable();
            $table->text('coordinat')->nullable();
            $table->string('radius')->nullable();
            $table->string('foto');
            $table->timestamps();
            // $table->foreign('category')->references('id')->on('categories');
            // $table->foreign('username')->references('username')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
