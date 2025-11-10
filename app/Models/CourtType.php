<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Court;

class CourtType extends Model
{
    protected $fillable = [
        'courttype_name',
        'description',
    ];
    public function court(){
        return $this->hasMany(Court::class);
    }
}
