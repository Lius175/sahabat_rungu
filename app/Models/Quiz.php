<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';

    protected $fillable = [
        'title',
        'questions',
        'videos',
        'options_1',
        'options_2',
        'options_3',
    ];

    protected $casts = [
        'questions' => 'array',
        'videos' => 'array',
        'options_1' => 'array',
        'options_2' => 'array',
        'options_3' => 'array',
    ];
}

