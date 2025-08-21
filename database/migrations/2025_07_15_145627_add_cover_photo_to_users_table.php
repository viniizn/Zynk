<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('cover_photo')->nullable(); // Coluna para armazenar o caminho da imagem
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('cover_photo'); // Remove a coluna se a migração for revertida
    });
}

};
