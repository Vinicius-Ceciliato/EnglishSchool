<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'student_id',
        'type',
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function isTask(): bool
    {
        return $this->type === 'tarefa';
    }

    /** Horário no formato 14:00 (ou null). */
    public function startLabel(): ?string
    {
        return $this->start_time ? substr($this->start_time, 0, 5) : null;
    }

    public function endLabel(): ?string
    {
        return $this->end_time ? substr($this->end_time, 0, 5) : null;
    }
}