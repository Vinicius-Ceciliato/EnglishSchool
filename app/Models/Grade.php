<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    /** Habilidades avaliadas. */
    public const SKILLS = [
        'reading' => 'Reading',
        'writing' => 'Writing',
        'speaking' => 'Speaking',
        'listening' => 'Listening',
    ];

    /** Conceitos possíveis (valor salvo => texto exibido). */
    public const CONCEPTS = [
        'excelente' => 'Excelente',
        'muito_bom' => 'Muito Bom',
        'bom' => 'Bom',
        'regular' => 'Regular',
    ];

    protected $fillable = [
        'student_id',
        'title',
        'assessed_on',
        'reading',
        'writing',
        'speaking',
        'listening',
        'exam_score',
        'comments',
    ];

    protected $casts = [
        'assessed_on' => 'date',
        'exam_score' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /** Texto do conceito de uma habilidade (ex.: "Muito Bom"). */
    public function conceptLabel(string $skill): string
    {
        return self::CONCEPTS[$this->{$skill}] ?? '—';
    }

    /** Estilo (cores) do selo de um conceito. */
    public static function conceptStyle(?string $concept): string
    {
        return match ($concept) {
            'excelente' => 'background: rgba(46,125,50,0.12); color: #2e7d32;',
            'muito_bom' => 'background: rgba(0,137,123,0.12); color: #00796b;',
            'bom' => 'background: rgba(242,134,39,0.15); color: #b85a10;',
            default => 'background: rgba(191,51,38,0.10); color: #BF3326;',
        };
    }

    /** Formata um número como percentual: 87 -> "87%", 87.5 -> "87,5%". */
    public static function percent(?float $value): string
    {
        if ($value === null) {
            return '—';
        }

        return rtrim(rtrim(number_format($value, 1, ',', ''), '0'), ',').'%';
    }

    public function scoreLabel(): string
    {
        return self::percent($this->exam_score);
    }

    /** Cor da nota: verde a partir de 70, laranja a partir de 50, vermelho abaixo. */
    public static function scoreColor(?float $value): string
    {
        if ($value === null) {
            return '#999999';
        }

        return $value >= 70 ? '#2e7d32' : ($value >= 50 ? '#D95829' : '#BF3326');
    }
}