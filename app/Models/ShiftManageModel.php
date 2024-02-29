<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftManageModel extends Model
{
    //use HasFactory;

    protected $table    = 'shifts';
    protected $fillable = [
        'title',
        'start_time',
        'start_end',
    ];
}
