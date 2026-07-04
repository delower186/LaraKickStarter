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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('cid')->unique();
            $table->string('title');
            $table->longText('summary');
            $table->longText('content');
            $table->string('lessons');
            $table->string('time');
            $table->string('level');
            $table->string('grade');
            $table->string('language');
            $table->integer('price')->unsigned();
            $table->integer('regularPrice')->unsigned();
            $table->string('image');
            $table->json('tags');
            $table->json('outcomes');
            $table->json('includes');
            $table->json('curriculum');
            $table->string('audience');
            $table->enum('status', [0,1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
