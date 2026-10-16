<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Recria a tabela de materiais: cada linha é um PDF liberado para UM aluno.
     * (A tabela antiga ainda não era usada em nenhuma tela.)
     */
    public function up(): void
    {
        Schema::dropIfExists('materials');

        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('description', 500)->nullable();
            $table->string('file_path');
            $table->string('original_name');
            $table->unsignedBigInteger('size')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};