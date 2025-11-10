<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceType;
class Service extends Model
{
    protected $fillable = [
        'servicetype_id',
        'service_name',
        'description',
        'created_by',
        'status',
    ];
    public function servicetype(){
        return $this->belongsTo(Servicetype::class);
    }
}
