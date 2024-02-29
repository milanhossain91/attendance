<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryModel extends Model
{
    protected $table='salary_generates';
    protected $primaryKey='id';
    use HasFactory;
}
