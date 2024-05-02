<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'role',
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
