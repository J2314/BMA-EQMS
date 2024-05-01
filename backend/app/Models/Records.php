<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_type',
        'record_name',
        'document_name',
        'department_id',
        'file_path',
        'is_active'
    ];
}
