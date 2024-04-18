<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedures extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_type',
        'department',
        'document_name',
        'file_path',
        'is_active',
    ];
}
