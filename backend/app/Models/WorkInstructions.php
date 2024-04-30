<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkInstructions extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_type',
        'employee_name',
        'document_name',
        'file_path',
        'is_active',
    ];
}
