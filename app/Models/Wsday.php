<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wsday extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function wstime(){
        return $this->hasMany(Wstime::class, 'wsday_id', 'id');
        // 'wsday_id' is the foreign key in the wstimes table
        // 'id' is the primary key in the wsdays table
    }


    public function wsclassdays(){
        return $this->hasMany(Wsclassday::class, 'wsday_id', 'id');
        // 'wsday_id' is the foreign key in the wsclassdays table
        // 'id' is the primary key in the wsdays table
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
