<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayModel extends Model
{
    protected $table='holidays';
    protected $primaryKey='id';
    use HasFactory;
}
