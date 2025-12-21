<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Wsclass;
use App\Models\Wsclasssection;
use App\Models\Wsweeklyschedule;
use App\Models\Wsday;
use App\Models\Wsperiod;
use App\Models\Wssubject;
use App\Models\Wsteacher;

class ClassSectionWiseWeeklyScheduleComponent extends Component
{
    public $classes = [];
    public $sections = [];
    public $selectedClass = null;
    public $selectedSection = null;
    public $scheduleData = [];
    public $days = [];
    public $periods = [];
    
    public function mount()
    {
        // Load all classes
        $this->classes = Wsclass::where('is_active', 1)->get();
        
        // Load days and periods for the schedule table
        $this->days = Wsday::where('is_active', 1)->get();
        $this->periods = Wsperiod::where('is_active', 1)->get();
    }
    
    public function selectClass($classId)
    {
        $this->selectedClass = $classId;
        $this->selectedSection = null;
        
        // Load sections for the selected class
        $this->sections = Wsclasssection::where('wsclass_id', $classId)
            ->where('is_active', 1)
            ->with(['wssection'])
            ->get();
            
        // Clear schedule data
        $this->scheduleData = [];
    }
    
    public function selectSection($sectionId)
    {
        $this->selectedSection = $sectionId;
        
        // Load schedule data for the selected class and section
        $this->loadScheduleData();
    }
    
    private function loadScheduleData()
    {
        if (!$this->selectedClass || !$this->selectedSection) {
            return;
        }
        
        // Load all schedule data for this class-section combination
        $schedules = Wsweeklyschedule::where('wsclass_id', $this->selectedClass)
            ->where('wssection_id', $this->selectedSection)
            ->with(['wssubject', 'wsteacher'])
            ->get();
            
        // Organize data by day and period for easy access in the view
        $this->scheduleData = [];
        foreach ($schedules as $schedule) {
            $dayId = $schedule->wsday_id;
            $periodId = $schedule->wsperiod_id;
            
            $this->scheduleData[$dayId][$periodId] = [
                'subject' => $schedule->wssubject ? $schedule->wssubject->name_in_short : '',
                'teacher' => $schedule->wsteacher ? $schedule->wsteacher->name_alias : ''
            ];
        }
    }
    
    public function render()
    {
        return view('livewire.class-section-wise-weekly-schedule-component');
    }
}
