<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedures extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_type',
        'department_id',
        'document_name',
        'file_path',
        'is_active',
    ];

    function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
