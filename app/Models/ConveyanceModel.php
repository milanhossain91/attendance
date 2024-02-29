<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConveyanceModel extends Model
{
    protected $table='conveyances';
    protected $primaryKey='id';
    use HasFactory;
}
