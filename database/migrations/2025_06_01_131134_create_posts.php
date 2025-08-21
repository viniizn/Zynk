<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // já é auto-increment e unsigned
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title', 200)->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('img_path')->nullable();

            $table->string('video_path')->nullable();
            $table->string('doc_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
