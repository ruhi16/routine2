<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wsclasssubjectweektp extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'wsclasssubjectweektps';


    // protected $fillable = [
    //     'wsclass_id',
    //     'wsday_id',
    //     'wssubject_id',
    //     'teacher_id',
    //     'start_time',
    //     'end_time',
    //     'classroom_id',
    //     'status',
    // ];

    // public function wsclass()
    // {
    //     return $this->belongsTo(Wsclass::class);
    // }

    // public function wsday()
    // {
    //     return $this->belongsTo(Wsday::class);
    // }

    // public function subject()
    // {
    //     return $this->belongsTo(Subject::class);
    // }

    // public function teacher()
    // {
    //     return $this->belongsTo(Teacher::class);
    // }

    // public function classroom()
    // {
    //     return $this->belongsTo(Classroom::class);
    // }
}
