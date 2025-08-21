<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('body'); // O corpo do comentário
            $table->string('img_path')->nullable();
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Relacionamento com post
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relacionamento com usuário
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}