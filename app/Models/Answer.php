<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level_1_answers',
        'level_2_answers',
        'level_3_answers',
    ];

    protected $casts = [
        'level_1_answers' => 'array',
        'level_2_answers' => 'array',
        'level_3_answers' => 'array',
    ];
}
