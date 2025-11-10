<?php

namespace App\Models;
use App\Models\Cases;

use Illuminate\Database\Eloquent\Model;

class CaseType extends Model
{
    protected $fillable =[
        'case_name',
        'description',
    ];
    public function case(){
        return $this->hasMany(Cases::class);
    }
}
