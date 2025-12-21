<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Wsday;
use App\Models\Wsperiod;
use App\Models\Wsteacher;
use App\Models\Wsweeklyschedule;
use App\Models\Wsclassdaytp;

class TeacherWiseWeeklyScheduleComponent extends Component
{
    public $days = [];
    public $periods = [];
    public $teachers = [];
    public $selectedDay = null;
    public $scheduleData = [];
    
    public function mount()
    {
        // Load all days
        $this->days = Wsday::where('is_active', 1)->get();
        
        // Load all periods
        $this->periods = Wsperiod::where('is_active', 1)->get();
        
        // Load all teachers
        $this->teachers = Wsteacher::all();
        
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
    
    private function loadScheduleData()
    {
        if (!$this->selectedDay) {
            return;
        }
        
        // Load all schedule data for the selected day
        $schedules = Wsweeklyschedule::where('wsday_id', $this->selectedDay)
            ->with(['wsclass', 'wssection', 'wsteacher'])
            ->get();
            
        // Organize data by teacher, period for easy access in the view
        $this->scheduleData = [];
        
        foreach ($schedules as $schedule) {
            $teacherId = $schedule->wsteacher_id;
            $periodId = $schedule->wsperiod_id;
            
            // Create class-section combination
            $classSection = '';
            if ($schedule->wsclass && $schedule->wssection) {
                $classSection = $schedule->wsclass->name . '-' . $schedule->wssection->name;
            }
            
            $this->scheduleData[$teacherId][$periodId] = $classSection;
        }
    }
    
    public function render()
    {
        return view('livewire.teacher-wise-weekly-schedule-component');
    }
}
