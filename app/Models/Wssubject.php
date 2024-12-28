<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wssubject extends Model
{
    use HasFactory;
    protected $table = 'wssubjects';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = true;


    public function wsclasssubjects(){
        return $this->hasMany(Wsclasssubject::class, 'wssubject_id', 'id');
        // 'wssubject_id' is the foreign key in the wsclasssubjects table
        // 'id' is the primary key in the wssubjects table
    }


    public function wsclasssectionsubjectteacherweektps(){
        return $this->hasMany(Wsclasssectionsubjectteacherweektp::class, 'wssubject_id', 'id');
        // 'wssubject_id' is the foreign key in the wsclasssectionsubjectteacherweektps table
        // 'id' is the primary key in the wssubjects table
    }



    public function wsweeklyschedule(){
        return $this->hasMany(Wsweeklyschedule::class, 'wssubject_id', 'id');
        // 'wssubject_id' is the foreign key in the wsclasssectionsubjectteacherweektps table
        // 'id' is the primary key in the wssubjects table
    }










    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wssubjects table
        // 'id' is the primary key in the schools table
    }

    public function session(){
        return $this->belongsTo(Session::class, 'session_id', 'id');
        // 'session_id' is the foreign key in the wssubjects table
        // 'id' is the primary key in the sessions table
    }


}
