<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'department_id',
        'batch_name',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
