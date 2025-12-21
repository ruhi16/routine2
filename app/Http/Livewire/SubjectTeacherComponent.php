<?php

namespace App\Http\Livewire;
use Livewire\Component;

use App\Models\Wssubjectteacher;
use App\Models\Wssubject;
use App\Models\Wsteacher;

class SubjectTeacherComponent extends Component
{

    public $subjects;
    public $subjectTeacherDetails;
    public $allTeachers;
    public $selectedSubject;
    public $isModalOpen = false;
    public $teachersToAdd = [];


    public function mount() {
        $this->loadData();
        $this->allTeachers = Wsteacher::all();
    }

    public function loadData() {
        $this->subjects = Wssubject::where('subject_type', 'Summative')
            ->get()
            ;
        $this->subjectTeacherDetails = Wssubjectteacher::with('teacher')->get()
            // ->groupBy('wssubject_id')
            ;
    }

    public function openModal($subjectId)
    {
        $this->selectedSubject = Wssubject::find($subjectId);
        $this->teachersToAdd = [];
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function addTeachers()
    {
        if ($this->selectedSubject) {
            foreach ($this->teachersToAdd as $teacherId) {
                Wssubjectteacher::firstOrCreate([
                    'wssubject_id' => $this->selectedSubject->id,
                    'wsteacher_id' => $teacherId,
                ], [
                    'school_id' => $this->selectedSubject->school_id,
                    'session_id' => $this->selectedSubject->session_id,
                    'is_active' => 1,
                ]);
            }
            session()->flash('message', 'Teachers updated successfully.');
            $this->loadData();
            $this->closeModal();
        }
    }

    public function removeTeacher($subjectTeacherId)
    {
        $subjectTeacher = Wssubjectteacher::find($subjectTeacherId);
        if ($subjectTeacher) {
            $subjectTeacher->delete();
            session()->flash('message', 'Teacher removed successfully.');
            $this->loadData();
        }
    }

    public function render()
    {
        return view('livewire.subject-teacher-component');
    }
}