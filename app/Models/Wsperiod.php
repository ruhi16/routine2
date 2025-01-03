<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wsperiod extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function wsweeklyschedules(){
        return $this->hasMany(Wsweeklyschedule::class, 'wsperiod_id', 'id');
        // 'wsperiod_id' is the foreign key in the wsweeklyschedules table
        // 'id' is the primary key in the wsperiods table
    }














    

    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wsperiods table
        // 'id' is the primary key in the schools table
    }

    public function session(){
        return $this->belongsTo(Session::class, 'session_id', 'id');
        // 'session_id' is the foreign key in the wsperiods table
        // 'id' is the primary key in the sessions table
    }
}
