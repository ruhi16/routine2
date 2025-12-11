<?php

namespace App\Http\Livewire;
use Livewire\Component;

use App\Models\Wsclasssubjectweektp;
use App\Models\Wsclassdaytp;
use App\Models\Wsclass;
use App\Models\Wsclasssection;
use App\Models\Wssubject;

class ClassSubjectTeacherWiseWtpComponent extends Component
{

    public $classSubjectDetails;
    public $myclasses;
    public $classSections;
    public $subjects;

    public function mount()
    {
        $this->classSubjectDetails = Wsclasssubjectweektp::all();
        $this->myclasses = Wsclass::all();     
        $this->classSections = Wsclasssection::all();
        // dd($this->classSections);   
        $this->subjects = Wssubject::where('subject_type', 'Summative')->get();
    }





    public function render()
    {
        return view('livewire.class-subject-teacher-wise-wtp-component');
    }
}
