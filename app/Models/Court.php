<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CourtType;
use App\Models\Cases;

class Court extends Model
{
    protected $fillable = [
        'courttype_id',
        'court_name',
        'address',
        'email',
        'status',
    ];

    public function courttype(){
        return $this->belongsTo(Courttype::class);
    }
    public function case()
    {
        return $this->hasMany(Cases::class);
    }
}
