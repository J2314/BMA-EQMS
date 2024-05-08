<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkInstructions extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_type',
        'user_id',
        'department_id',
        'document_name',
        'file_path',
        'is_active',
    ];

    function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}


