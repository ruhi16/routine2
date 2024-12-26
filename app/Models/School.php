<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sessions(){
        return $this->hasMany(Session::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the sessions table
        // 'id' is the primary key in the schools table
    }


    public function wsdays(){
        return $this->hasMany(Wsday::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wsdays table
        // 'id' is the primary key in the schools table
    }

    public function wsperiods(){
        return $this->hasMany(Wsperiod::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wsperiods table
        // 'id' is the primary key in the schools table
    }

    public function wstimes(){
        return $this->hasMany(Wstime::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wstimes table
        // 'id' is the primary key in the schools table
    }

    public function wsclasses(){
        return $this->hasMany(Wsclass::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wsclasses table
        // 'id' is the primary key in the schools table
    }

    public function wssections(){
        return $this->hasMany(Wssection::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wssections table
        // 'id' is the primary key in the schools table
    }

    public function wssubjects(){
        return $this->hasMany(Wssubject::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wssubjects table
        // 'id' is the primary key in the schools table
    }

    public function wsteachers(){
        return $this->hasMany(Wsteacher::class, 'school_id', 'id');
        // 'school_id' is the foreign key in the wsteachers table
        // 'id' is the primary key in the schools table
    }




}
