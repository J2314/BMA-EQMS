<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormDownloading extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'user_id',
        'form_files_id',
    ];
}
