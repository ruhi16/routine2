<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wssubjectteacher extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    
    
    public function subject(){
        return $this->belongsTo(Wssubject::class, 'wssubject_id', 'id');
    }
    public function teacher(){
        return $this->belongsTo(Wsteacher::class, 'wsteacher_id', 'id');
    }

}
