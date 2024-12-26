<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wsteacher extends Model
{
    use HasFactory;
    protected $guarded = ['id'];



    public function wsclasssectionsubjectteacherweektps(){
        return $this->hasMany(Wsclasssectionsubjectteacherweektp::class, 'wsteacher_id', 'id');
        // 'wssubject_id' is the foreign key in the wsclasssectionsubjectteacherweektps table
        // 'id' is the primary key in the wssubjects table
    }



    // public function wsclasssectionsubjectteacherweektps(){
    //     return $this->hasMany(Wsclasssectionsubjectteacherweektp::class, 'wsteacher_id', 'id');
    //     // 'wsteacher_id' is the foreign key in the wsteachers table
    //     // 'id' is the primary key in the schools table
    // }



    public function wsclassteachers(){
        return $this->hasMany(Wsclassteacher::class, 'wsteacher_id', 'id');
        // 'wsteacher_id' is the foreign key in the wsteachers table
        // 'id' is the primary key in the schools table
    }









    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wsteachers table
        // 'id' is the primary key in the schools table
    }

    public function session(){
        return $this->belongsTo(Session::class, 'session_id', 'id');
        // 'session_id' is the foreign key in the wsteachers table
        // 'id' is the primary key in the sessions table
    }


}
