<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wsclasssectionsubjectteacherweektp extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function wsclass(){
        return $this->belongsTo(Wsclass::class, 'wsclass_id', 'id');
        // 'wsclass_id' is the foreign key in the wsteachers table
        // 'id' is the primary key in the schools table
    }

    public function wssection(){
        return $this->belongsTo(Wssection::class, 'wssection_id', 'id');
        // 'wssection_id' is the foreign key in the wsteachers table
        // 'id' is the primary key in the schools table
    }

    public function wssubject(){
        return $this->belongsTo(Wssubject::class, 'wssubject_id', 'id');
        // 'wssubject_id' is the foreign key in the wsteachers table
        // 'id' is the primary key in the schools table
    }

    public function wsteacher(){
        return $this->belongsTo(Wsteacher::class, 'wsteacher_id', 'id');
        // 'wsteacher_id' is the foreign key in the wsteachers table
        // 'id' is the primary key in the schools table
    }


    






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
