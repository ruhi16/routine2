<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wsclasssubject extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function wsclass(){
        return $this->belongsTo(Wsclass::class, 'wsclass_id', 'id');
        // 'wsclass_id' is the foreign key in the wsclasssubjects table
        // 'id' is the primary key in the wsclasses table
    }

    public function wssubject(){
        return $this->belongsTo(Wssubject::class, 'wssubject_id', 'id');
        // 'wssubject_id' is the foreign key in the wsclasssubjects table
        // 'id' is the primary key in the wssubjects table
    }


   



    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wsclasssubjects table
        // 'id' is the primary key in the schools table
    }   

    public function session(){
        return $this->belongsTo(Session::class, 'session_id', 'id');
        // 'session_id' is the foreign key in the wsclasssubjects table
        // 'id' is the primary key in the sessions table
    }


}
