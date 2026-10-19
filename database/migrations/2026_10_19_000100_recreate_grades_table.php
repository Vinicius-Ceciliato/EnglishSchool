<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Recria a tabela do boletim. Cada linha é um boletim/avaliação de UM aluno:
     * conceitos em 4 habilidades + nota da prova (0 a 100, em percentual).
     * (A tabela antiga ainda não era usada em nenhuma tela.)
     */
    public function up(): void
    {
        Schema::dropIfExists('grades');

        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');                 // ex.: "1º bimestre", "Unit 3 test"
            $table->date('assessed_on');              // data da avaliação
            $table->string('reading', 12);            // excelente | muito_bom | bom | regular
            $table->string('writing', 12);
            $table->string('speaking', 12);
            $table->string('listening', 12);
            $table->decimal('exam_score', 5, 2);      // 0 a 100 (%)
            $table->text('comments')->nullable();     // observações da professora
            $table->timestamps();

            $table->index(['student_id', 'assessed_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};