<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    // use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];
    protected $guarded = [];
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
