<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentModel extends Model
{
    protected $table='adjustments';
    protected $primaryKey='id';
    // protected $fillable = ['adjustment_date', 'status', 'time'];
    use HasFactory;
}
