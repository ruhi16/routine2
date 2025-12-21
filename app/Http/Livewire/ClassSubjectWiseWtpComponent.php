<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Wsclasssectionsubjectwtp;

use App\Models\Wsclasssection;
use App\Models\Wsclass;
use App\Models\Wssubject;
// use App\Models\Teacher;
// use App\Models\Classroom;
// use App\Models\Wssection;
// use App\Models\Wsday;

class ClassSubjectWiseWtpComponent extends Component
{
    public $classSubjectDetails;
    public $myclasses;
    // public $mysection;
    // public $myclassroom;
    // public $myteacher;
    public $subjects;
    // public $myday;

    public $showModal = false;
    public $selectedClass;
    public $classSubjectsData = [];

    public function mount()
    {
        $this->classSubjectDetails = Wsclasssectionsubjectwtp::
            all();
        $this->myclasses = Wsclass::all();
        
        $this->subjects = Wssubject::where('subject_type', 'Summative')->get();
    }

    public function openModal($classId)
    {
        $this->selectedClass = Wsclass::find($classId);
        $this->subjects = Wssubject::where('subject_type', 'Summative')->get();
        $this->classSubjectsData = [];

        $classSubjectPeriods = Wsclasssectionsubjectwtp::where('wsclass_id', $classId)
            ->get()
            ->keyBy('wssubject_id');

        foreach ($this->subjects as $subject) {
            $this->classSubjectsData[$subject->id] = $classSubjectPeriods->has($subject->id)
                ? $classSubjectPeriods[$subject->id]->weekly_total_periods
                : 0;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedClass = null;
        $this->classSubjectsData = [];
    }

    public function save()
    {
        if (!$this->selectedClass) {
            return;
        }

        $classSections = Wsclasssection::where('wsclass_id', $this->selectedClass->id)->get();
        // foreach($classSections as $classsection);{
        //     dd($classsection->wssection->name);
        // }

        
        foreach ($this->classSubjectsData as $subjectId => $periods) {
            // dd($subjectId, $periods);
            foreach($classSections as $classsection)
            Wsclasssectionsubjectwtp::updateOrCreate(
                [
                    'wsclass_id' => $this->selectedClass->id,
                    'wssubject_id' => $subjectId,
                    'wssection_id' => $classsection->wssection->id,
                ],
                [
                    'weekly_total_periods' => $periods ?: 0,
                    'school_id' => $this->selectedClass->school_id,
                    'session_id' => $this->selectedClass->session_id
                ]
            );
        }

        $this->classSubjectDetails = Wsclasssectionsubjectwtp::all();

        $this->closeModal();
        
        session()->flash('message', 'Weekly periods updated successfully.');
    }

    public function render()
    {
        return view('livewire.class-subject-wise-wtp-component');
    }
}

