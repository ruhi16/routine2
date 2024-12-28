<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wsclass extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $table = 'wsclasses';

/*
    public function wssections(){
        return $this->hasMany(Wssection::class, 'wsclass_id', 'id');
        // 'school_id' is the foreign key in the wssections table
        // 'id' is the primary key in the schools table
    }

    public function wssubjects(){
        return $this->hasMany(Wssubject::class, 'wsclass_id', 'id');
        // 'wsclass_id' is the foreign key in the wssubjects table
        // 'id' is the primary key in the schools table
    }


    public function wsteachers(){
        return $this->hasMany(Wsteacher::class, 'wsclass_id', 'id');
        // 'wsclass_id' is the foreign key in the wsteachers table
        // 'id' is the primary key in the schools table
    }
*/
    public function wsclasssections(){
        return $this->hasMany(Wsclasssection::class, 'wsclass_id', 'id');
        // 'wsclass_id' is the foreign key in the wsclasssections table
        // 'id' is the primary key in the schools table
    }


    public function wsclasssubjects(){
        return $this->hasMany(Wsclasssubject::class, 'wsclass_id', 'id');
        // 'wsclass_id' is the foreign key in the wsclasssubjects table
        // 'id' is the primary key in the schools table
    }

    public function wsweeklyschedules(){
        return $this->hasMany(Wsweeklyschedule::class, 'wsclass_id', 'id');
        // 'wsclass_id' is the foreign key in the wsweeklyschedules table
        // 'id' is the primary key in the schools table
    }


    /*
    public function wsclassteachers(){
        return $this->hasMany(Wsclassteacher::class, 'wsclass_id', 'id');
        // 'wsclass_id' is the foreign key in the wsclassteachers table
        // 'id' is the primary key in the schools table
    }

    public function wsclassdays(){
        return $this->hasMany(Wsclassday::class, 'wsclass_id', 'id');
        // 'wsclass_id' is the foreign key in the wsclassdays table
        // 'id' is the primary key in the schools table
    }
    */


    public function wsclasssectionsubjectteacherweektps(){
        return $this->hasMany(Wsclasssectionsubjectteacherweektp::class, 'wsclass_id', 'id');
        // 'wsclass_id' is the foreign key in the wsclasssectionsubjectteacherweektps table
        // 'id' is the primary key in the schools table
    }







    // belongsTo relationship
    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wsclasses table
        // 'id' is the primary key in the schools table
    }

    public function session(){
        return $this->belongsTo(Session::class, 'session_id', 'id');
        // 'session_id' is the foreign key in the wsclasses table
        // 'id' is the primary key in the sessions table
    }



}
