<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFiles extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'file_path',
        'is_active',
    ];
}
