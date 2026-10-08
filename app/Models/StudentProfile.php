<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
protected $fillable = ['user_id', 'phone', 'age', 'english_level', 'payment_up_to_date', 'payment_due_date'];}
        
        