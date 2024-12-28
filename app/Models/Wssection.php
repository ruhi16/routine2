<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wssection extends Model
{
    use HasFactory;
    protected $table = 'wssections';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function wsclasssections(){
        return $this->hasMany(Wsclasssection::class, 'wssection_id', 'id');
        // 'school_id' is the foreign key in the wssections table
        // 'id' is the primary key in the schools table
    }   


    public function wsclasssectionsubjectteacherweektps(){
        return $this->hasMany(Wsclasssectionsubjectteacherweektp::class, 'wssection_id', 'id');
        // 'school_id' is the foreign key in the wssections table
        // 'id' is the primary key in the schools table
    }   


    public function wsweeklyschedules(){
        return $this->hasMany(Wsweeklyschedule::class, 'wssection_id', 'id');
        // 'school_id' is the foreign key in the wssections table
        // 'id' is the primary key in the schools table
    }








    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wssections table
        // 'id' is the primary key in the schools table
    }   

    public function session(){
        return $this->belongsTo(Session::class, 'session_id', 'id');
        // 'school_id' is the foreign key in the wssections table
        // 'id' is the primary key in the schools table
    }
}
