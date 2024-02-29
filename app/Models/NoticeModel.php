<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeModel extends Model
{
    protected $table='notices';
    protected $primaryKey='id';
    use HasFactory;
}
