<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CaseType;
use App\Models\Court;

class Cases extends Model
{
    protected $fillable = [
        'casetype_id',
        'court_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
    ];
    public function casetype(){
        return $this->belongsTo(casetype::class);
    }
    public function court(){
        return $this->belongsTo(court::class);
    }
    public $timestamps = false;
}
