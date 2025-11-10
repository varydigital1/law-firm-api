<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'nationality',
        'id_card_number',
        'email',
        'phone',
        'address',
        'created_by',
        'status',
    ];
}
