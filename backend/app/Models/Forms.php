<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_code',
        'file_name',
        'description',
        'department_id',
        'is_removed',
    ];

    function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    function form_files()
    {
        return $this->hasMany(FormFiles::class, 'form_id');
    }
    
    function form_file()
    {
        return $this->hasOne(FormFiles::class, 'form_id');
    }
}
