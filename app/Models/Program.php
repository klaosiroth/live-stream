<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    // use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = [];
    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'program_id', 'id');
    }
}
