<?php

namespace App\Http\Livewire;
use Livewire\Component;

use App\Models\Wsclasssectionsubjectwtp;
use App\Models\Wsclassdaytp;
use App\Models\Wsclass;
use App\Models\Wsclasssection;
use App\Models\Wssubject;
use App\Models\Wsteacher;
use App\Models\Wsclasssubject;
use App\Models\Wsclasssectionsubjectteacherweektp;

class ClassSectionSubjectTeacherWiseWtpComponent extends Component
{

    public $classSectionSubjectTeacherWtp;
    public $classSubjectDetails;
    public $myclasses;
    public $classSections;
    public $subjects;

    public $isModalOpen = false;
    public $teachers;
    public $selectedClass, $selectedClassSection;
    public $subjectsForClass;
    public $subjectTeacherData = [];

    public function mount()
    {
        $this->classSectionSubjectTeacherWtp = Wsclasssectionsubjectteacherweektp::all();
        $this->classSubjectDetails = Wsclasssectionsubjectwtp::all();
        $this->myclasses = Wsclass::all();     
        $this->classSections = Wsclasssection::all();
        // dd($this->classSections);   
        $this->subjects = Wssubject::where('subject_type', 'Summative')->get();
        $this->teachers = Wsteacher::all();
    }





    public function render()
    {
        return view('livewire.class-section-subject-teacher-wise-wtp-component');
    }

    public function openModal($classId, $classSectionId)
    {
        $this->selectedClass = Wsclass::find($classId);
        $this->selectedClassSection = Wsclasssection::with('wssection')->find($classSectionId);

        $this->subjectsForClass = Wsclasssubject::where('wsclass_id', $classId)->with('wssubject')->get();

        $this->subjectTeacherData = [];
        foreach ($this->subjectsForClass as $classSubject) {
            $subject = $classSubject->wssubject;
            if ($subject) {
                $data = Wsclasssectionsubjectteacherweektp::where('wsclass_id', $this->selectedClass->id)
                    ->where('wssection_id', $this->selectedClassSection->wssection_id)
                    ->where('wssubject_id', $subject->id)
                    ->first();

                $this->subjectTeacherData[$subject->id] = [
                    'wsteacher_id' => $data->wsteacher_id ?? null,
                    'weekly_total_periods' => $data->weekly_total_periods ?? 0,
                ];
            }
        }

        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function saveSubjectTeachers()
    {
        if (!$this->selectedClass || !$this->selectedClassSection) {
            return;
        }

        foreach ($this->subjectTeacherData as $subjectId => $data) {
            if (!empty($data['wsteacher_id']) && is_numeric($data['weekly_total_periods'])) {
                Wsclasssectionsubjectteacherweektp::updateOrCreate(
                    [
                        'school_id' => $this->selectedClass->school_id,
                        'session_id' => $this->selectedClass->session_id,
                        'wsclass_id' => $this->selectedClass->id,
                        'wssection_id' => $this->selectedClassSection->wssection_id,
                        'wssubject_id' => $subjectId,
                    ],
                    [
                        'wsteacher_id' => $data['wsteacher_id'],
                        'weekly_total_periods' => $data['weekly_total_periods'],
                        'is_active' => 1,
                    ]
                );
            } else {
                // If teacher or periods are not set, delete the record
                Wsclasssectionsubjectteacherweektp::where('wsclass_id', $this->selectedClass->id)
                    ->where('wssection_id', $this->selectedClassSection->wssection_id)
                    ->where('wssubject_id', $subjectId)
                    ->delete();
            }
        }

        session()->flash('message', 'Teacher allotment has been saved successfully.');
        $this->closeModal();
    }
}
