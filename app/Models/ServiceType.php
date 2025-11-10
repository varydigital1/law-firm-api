<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class ServiceType extends Model
{
    protected $fillable = [
        'servicetype_name',
        'description',
        'status',
    ];
    public function service(){
        return $this->hasMany(Service::class);
    }
}
