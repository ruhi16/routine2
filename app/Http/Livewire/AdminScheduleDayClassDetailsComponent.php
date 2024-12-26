<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Wsday;
use App\Models\Wsclass;
use App\Models\Wsclassdaytp;

use App\Models\Wsclasssection;

use App\Models\Wssubject;
use App\Models\Wsclasssubject;

use App\Models\Wsclasssectionsubjectteacherweektp;

class AdminScheduleDayClassDetailsComponent extends Component
{

    public $wsdays;
    public $wsclasses;
    public $wsclassdaytps;

    public $wsclasssections;


    public $wssubjects;
    public $wsclasssubjects;

    public $wsclasssectionsubjectteachers;


    public function mount(){
        $this->wsdays = Wsday::all();
        $this->wsclasses = Wsclass::all();
        $this->wsclassdaytps = Wsclassdaytp::all();

        $this->wsclasssections = Wsclasssection::
            where('is_active', 1)
            ->get();


        $this->wssubjects = Wssubject::
            where('subject_type', 'Summative')->get();

        $this->wsclasssubjects = Wsclasssubject::all();

        $this->wsclasssectionsubjectteachers = Wsclasssectionsubjectteacherweektp::all();   
    }
    public function render()
    {
        return view('livewire.admin-schedule-day-class-details-component');
    }
}
