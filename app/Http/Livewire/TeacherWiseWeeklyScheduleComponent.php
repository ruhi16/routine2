<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Wsday;
use App\Models\Wsperiod;
use App\Models\Wsteacher;
use App\Models\Wsweeklyschedule;
use App\Models\Wssubject;
use App\Models\Wsclass;
use App\Models\Wssection;
use App\Models\Wsclasssection;

class TeacherWiseWeeklyScheduleComponent extends Component
{
    public $days = [];
    public $periods = [];
    public $teachers = [];
    public $selectedDay = null;
    public $scheduleData = [];
    public $dailyTotals = [];
    public $weeklyTotals = [];
    
    // Modal properties
    public $isModalOpen = false;
    public $selectedTeacher = null;
    public $selectedSubject = null;
    public $selectedClass = null;
    public $selectedSection = null;
    public $selectedPeriods = []; // Store single period per day (key: day_id, value: period_id)
    
    // Data for dropdowns
    public $subjects = [];
    public $classes = [];
    public $sections = [];
    
    protected $rules = [
        'selectedSubject' => 'required',
        'selectedClass' => 'required',
        'selectedSection' => 'required',
    ];
    
    public function mount()
    {
        // Load all days
        $this->days = Wsday::where('is_active', 1)->get();
        
        // Load all periods
        $this->periods = Wsperiod::where('is_active', 1)->get();
        
        // Load all teachers
        $this->teachers = Wsteacher::all();
        
        // Load subjects, classes for dropdowns
        $this->subjects = Wssubject::where('subject_type', 'Summative')->get();
        $this->classes = Wsclass::where('is_active', 1)->get();
        
        // Set the first day as default selection if days exist
        if ($this->days->count() > 0) {
            $this->selectedDay = $this->days->first()->id;
            $this->loadScheduleData();
        }
    }
    
    public function selectDay($dayId)
    {
        $this->selectedDay = $dayId;
        $this->loadScheduleData();
    }
    
    public function openAddModal($teacherId)
    {
        $this->selectedTeacher = Wsteacher::find($teacherId);
        $this->selectedSubject = null;
        $this->selectedClass = null;
        $this->selectedSection = null;
        $this->selectedPeriods = [];
        $this->sections = [];
        
        $this->isModalOpen = true;
    }
    
    public function closeAddModal()
    {
        $this->isModalOpen = false;
        $this->selectedTeacher = null;
        $this->selectedSubject = null;
        $this->selectedClass = null;
        $this->selectedSection = null;
        $this->selectedPeriods = [];
        $this->sections = [];
    }
    
    public function updatedSelectedClass($classId)
    {
        // Reset sections and selected section when class changes
        $this->sections = [];
        $this->selectedSection = null;
        
        if ($classId) {
            // Load sections for the selected class
            $this->sections = Wsclasssection::where('wsclass_id', $classId)
                ->where('is_active', 1)
                ->with('wssection')
                ->get();
        }
    }
    
    public function updatedSelectedSubject($subjectId)
    {
        // Reset class and section when subject changes
        $this->selectedClass = null;
        $this->selectedSection = null;
        $this->sections = [];
    }
    
    public function saveSchedule()
    {
        $this->validate();
        
        try {
            // Save schedule for each selected period (one per day)
            foreach ($this->selectedPeriods as $dayId => $periodId) {
                if ($periodId) { // Only save if a period is selected
                    // Check if this period is already assigned to any teacher
                    $existingSchedule = Wsweeklyschedule::where('wsday_id', $dayId)
                        ->where('wsperiod_id', $periodId)
                        ->first();
                    
                    if ($existingSchedule) {
                        // Period is already assigned, skip it
                        continue;
                    }
                    
                    Wsweeklyschedule::create([
                        'wsday_id' => $dayId,
                        'wsperiod_id' => $periodId,
                        'wsclass_id' => $this->selectedClass,
                        'wssection_id' => $this->selectedSection,
                        'wssubject_id' => $this->selectedSubject,
                        'wsteacher_id' => $this->selectedTeacher->id,
                        'school_id' => 1, // Assuming default school
                        'session_id' => 1, // Assuming default session
                        'is_active' => 1,
                        'status' => 'active',
                    ]);
                }
            }
            
            // Refresh the schedule data
            $this->loadScheduleData();
            
            $this->closeAddModal();
            
            session()->flash('message', 'Schedule saved successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving schedule: ' . $e->getMessage());
        }
    }
    
    public function removeSchedule($dayId, $periodId, $teacherId)
    {
        try {
            // Find and delete the schedule entry
            Wsweeklyschedule::where('wsday_id', $dayId)
                ->where('wsperiod_id', $periodId)
                ->where('wsteacher_id', $teacherId)
                ->delete();
            
            // Refresh the schedule data
            $this->loadScheduleData();
            
            session()->flash('message', 'Schedule removed successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error removing schedule: ' . $e->getMessage());
        }
    }
    
    private function loadScheduleData()
    {
        if (!$this->selectedDay) {
            return;
        }
        
        // Load all schedule data for the selected day
        $dailySchedules = Wsweeklyschedule::where('wsday_id', $this->selectedDay)
            ->with(['wsclass', 'wssection', 'wsteacher'])
            ->get();
            
        // Load all schedule data for the week
        $weeklySchedules = Wsweeklyschedule::with(['wsclass', 'wssection', 'wsteacher', 'wsday'])
            ->get();
            
        // Organize data by teacher, period for easy access in the view
        $this->scheduleData = [];
        
        foreach ($dailySchedules as $schedule) {
            $teacherId = $schedule->wsteacher_id;
            $periodId = $schedule->wsperiod_id;
            
            // Create class-section combination
            $classSection = '';
            if ($schedule->wsclass && $schedule->wssection) {
                $classSection = $schedule->wsclass->name . '-' . $schedule->wssection->name;
            }
            
            $this->scheduleData[$teacherId][$periodId] = $classSection;
        }
        
        // Calculate daily totals (for the selected day)
        $this->dailyTotals = [];
        foreach ($dailySchedules as $schedule) {
            $teacherId = $schedule->wsteacher_id;
            if (!isset($this->dailyTotals[$teacherId])) {
                $this->dailyTotals[$teacherId] = 0;
            }
            $this->dailyTotals[$teacherId]++;
        }
        
        // Calculate weekly totals
        $this->weeklyTotals = [];
        foreach ($weeklySchedules as $schedule) {
            $teacherId = $schedule->wsteacher_id;
            if (!isset($this->weeklyTotals[$teacherId])) {
                $this->weeklyTotals[$teacherId] = 0;
            }
            $this->weeklyTotals[$teacherId]++;
        }
    }
    
    public function render()
    {
        return view('livewire.teacher-wise-weekly-schedule-component');
    }
}
