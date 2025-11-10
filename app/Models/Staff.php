<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Staff extends Model
{
    protected $fillable = [
        'user_id',
        'staff_name',
        'title',
        'image',
        'phone',
        'address',
        'gender',
        'date_of_birth',
        'join_date',
        'end_date',
        'details',
        'created_by',
        'updated_by',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
