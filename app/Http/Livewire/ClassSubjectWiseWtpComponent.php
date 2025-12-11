<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Wsclasssubjectweektp;

use App\Models\Wsclassdaytp;
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
        $this->classSubjectDetails = Wsclasssubjectweektp::
            all();
        $this->myclasses = Wsclass::all();
        
        $this->subjects = Wssubject::where('subject_type', 'Summative')->get();
    }

    public function openModal($classId)
    {
        $this->selectedClass = Wsclass::find($classId);
        $this->subjects = Wssubject::where('subject_type', 'Summative')->get();
        $this->classSubjectsData = [];

        $classSubjectPeriods = Wsclasssubjectweektp::where('wsclass_id', $classId)
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

        foreach ($this->classSubjectsData as $subjectId => $periods) {
            // dd($subjectId, $periods);
            Wsclasssubjectweektp::updateOrCreate(
                [
                    'wsclass_id' => $this->selectedClass->id,
                    'wssubject_id' => $subjectId,
                ],
                [
                    'weekly_total_periods' => $periods ?: 0,
                ]
            );
        }

        $this->classSubjectDetails = Wsclasssubjectweektp::all();

        $this->closeModal();
        
        session()->flash('message', 'Weekly periods updated successfully.');
    }

    public function render()
    {
        return view('livewire.class-subject-wise-wtp-component');
    }
}

