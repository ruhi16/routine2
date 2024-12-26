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

use App\Models\Wsperiod;

use App\Models\Wsweeklyschedules;

class AdminScheduleDetailsComponent extends Component{
    public $wsdays;
    public $wsclasses;
    public $wsclassdaytps;

    public $wsclasssections;


    public $wssubjects;
    public $wsclasssubjects;

    public $wsclasssectionsubjectteachers;

    public $wsperiods;


    public $clsSecs;
    public $classSectionActiveSubjects;


    public function mount(){
        $this->wsdays = Wsday::all();
        $this->wsclasses = Wsclass::all();
        $this->wsclassdaytps = Wsclassdaytp::all();

        $this->wsclasssections = Wsclasssection::where('is_active', 1)
            ->where('id', '<', 19)
            ->orderBy('id', 'desc')
            ->get();


        $this->wssubjects = Wssubject::
            where('subject_type', 'Summative')->get();

        $this->wsclasssubjects = Wsclasssubject::all();

        $this->wsclasssectionsubjectteachers = Wsclasssectionsubjectteacherweektp::all();
        $this->wsperiods = Wsperiod::all();

        // $this->clsSecs = Wsclasssection::where('is_active', 1)
        //     ->where('id', '<', 19)
        //     ->orderBy('id', 'desc')
        //     ->get();

    }

    // find class wise active subjects with class_id
    public function findClass_ActiveSubjects($class_id){
        $classSubjects = Wsclasssubject::where('wsclass_id', $class_id)
            ->where('is_active', 1)
            ->where('is_additional', false)
            ->whereHas('wssubject', function($q){
                $q->where('subject_type', 'Summative');
                // $q->where('id', '!=', 1);
            })
            ->pluck('wssubject_id')
            ->toArray()
            ;
        return $classSubjects;
    }


    public function assignClassSection_ActiveSubjects(){
        
        foreach($this->wsclasssections as $wsclasssection){
            $this->classSectionActiveSubjects[$wsclasssection->wsclass_id][$wsclasssection->wssection_id] = $this->findClass_ActiveSubjects($wsclasssection->wsclass_id);
            // $wsclasssection->wssubjects()->sync($classSubjects);
            // $wsclasssection->wssubjects()->syncWithoutDetaching($classSubjects);            
        }

        // dd($this->classSectionActiveSubjects);
    }




    public function assignPeriodSubjects($period_id){
        $classAssignedSubjects = Wsweeklyschedules::all()
            ;
        $classSubject_ids = Wsclasssubject::where('is_active', 1)
            ->inRandomOrder()
            ->pluck('wssubject_id')
            ->toArray()
            ;
            
        // $this->wsclasssubjects = Wsclasssection::where('is_active', 1)
            // ->where('wsperiod_id', $wsperiod_id)
            // ->get();
    }








    public function render(){
        return view('livewire.admin-schedule-details-component');
    }
}
