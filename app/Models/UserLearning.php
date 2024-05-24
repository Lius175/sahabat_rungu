<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLearning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'completed_learning_ids',
    ];

    protected $casts = [
        'completed_learning_ids' => 'array',
    ];
}
