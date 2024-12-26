<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wsclassdaytp extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // protected $table = 'wsclassdaytp';

    public function wsclass(){
        return $this->belongsTo(Wsclass::class, 'wsclass_id', 'id');
        // 'wsclass_id' is the foreign key in the wsclasses table
        // 'id' is the primary key in the schools table
    }


    public function wsday(){
        return $this->belongsTo(Wsday::class, 'wsday_id', 'id');
        // 'wsday_id' is the foreign key in the wsclasses table
        // 'id' is the primary key in the schools table
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
