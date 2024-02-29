<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    protected $table='employees';
    protected $primaryKey='id';
    use HasFactory;

}
