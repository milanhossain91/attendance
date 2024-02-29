<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentModel extends Model
{
    protected $table='departments';
    protected $primaryKey='id';
    use HasFactory;

}
