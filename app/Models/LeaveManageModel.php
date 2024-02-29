<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveCategoryModel;
use App\Models\User;

class LeaveManageModel extends Model
{
    //use HasFactory;

    protected $table    = 'leaves';
    protected $fillable = [
        'from_date',
        'to_date',
    ];

    public function leaveType()
    {
        return $this->belongsTo(LeaveCategoryModel::class, 'category_id');
    }

    public function approvedUser()
    {
        return $this->belongsTo(User::class, 'approved_userid')->withDefault();
    }
}
