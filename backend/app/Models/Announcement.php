<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'department_id',
        'description',
        'content'
    ];

    function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
