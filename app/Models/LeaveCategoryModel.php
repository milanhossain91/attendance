<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveCategoryModel extends Model
{
    //use HasFactory;

    protected $table    = 'leave_categorys';
    protected $fillable = [
        'name'
    ];
}
