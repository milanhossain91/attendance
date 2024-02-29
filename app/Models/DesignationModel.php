<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationModel extends Model
{
    protected $table='designations';
    protected $primaryKey='id';
    use HasFactory;
}
