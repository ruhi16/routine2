<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Wsclass;
use App\Models\Wsclasssection;
use App\Models\Wssection;
use App\Models\Wsday;
use App\Models\Wsperiod;
use App\Models\Wsweeklyschedule;

class AllClassSectionWeeklyScheduleComponent extends Component
{
    public $classes = [];
    public $classSections = [];
    public $days = [];
    public $periods = [];
    public $allScheduleData = [];
    
    public function mount()
    {
        // Load all classes
        $this->classes = Wsclass::where('is_active', 1)->get();
        
        // Load all days
        $this->days = Wsday::where('is_active', 1)->get();
        
        // Load all periods
        $this->periods = Wsperiod::where('is_active', 1)->get();
        
        // Load all class sections and their schedules
        $this->loadAllClassSections();
    }
    
    private function loadAllClassSections()
    {
        // Load all class-section combinations
        $classSections = Wsclasssection::with(['wsclass', 'wssection'])
            ->get();
            
        // Group by class id manually
        $this->classSections = [];
        foreach ($classSections as $classSection) {
            $classId = $classSection->wsclass_id;
            if (!isset($this->classSections[$classId])) {
                $this->classSections[$classId] = [];
            }
            $this->classSections[$classId][] = $classSection;
        }
            
        // Load schedule data for all class-section combinations
        $this->loadAllScheduleData();
    }
    
    private function loadAllScheduleData()
    {
        // Load all schedule data
        $schedules = Wsweeklyschedule::with(['wsday', 'wsperiod', 'wssubject', 'wsteacher', 'wsclass', 'wssection'])
            ->get();
            
        // Organize data by class, section, day, period for easy access in the view
        $this->allScheduleData = [];
        
        foreach ($schedules as $schedule) {
            $classId = $schedule->wsclass_id;
            $sectionId = $schedule->wssection_id;
            $dayId = $schedule->wsday_id;
            $periodId = $schedule->wsperiod_id;
            
            // Create subject-teacher combination
            $subjectTeacher = '';
            if ($schedule->wssubject && $schedule->wsteacher) {
                $subjectTeacher = $schedule->wssubject->name . ' (' . $schedule->wsteacher->name_alias . ')';
            }
            
            $this->allScheduleData[$classId][$sectionId][$dayId][$periodId] = $subjectTeacher;
        }
    }
    
    public function render()
    {
        return view('livewire.all-class-section-weekly-schedule-component');
    }
}
