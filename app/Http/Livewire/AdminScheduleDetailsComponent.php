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
use App\Models\Wsteacher;
use App\Models\Wsweeklyschedule;

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
    public $activeTeachers;
    public $allTeachers;


    public $weeklySchedules;

    public $only_active_subjects;


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

        $this->allTeachers = Wsteacher::all();
        $this->weeklySchedules = Wsweeklyschedule::all();

    }

    // find class_wise_active_subjects with class_id
    public function findClass_ActiveSubjects($class_id){

        $classSubjects = Wsclasssubject::where('wsclass_id', $class_id)
            ->where('is_active', true)
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
            $allSubjects = $this->findClass_ActiveSubjects($wsclasssection->wsclass_id);
            $scheduledSubjects = Wsweeklyschedule::
                where('wsday_id', 1)
                ->where('wsclass_id', $wsclasssection->wsclass_id)
                ->where('wssection_id', $wsclasssection->wssection_id)
                ->pluck('wssubject_id')
                ->toArray()
                ;

            $this->only_active_subjects = array_diff($allSubjects, $scheduledSubjects);


            foreach($this->only_active_subjects as $classSubject){
                $classSubjectWTPs = Wsclasssectionsubjectteacherweektp::where('wsclass_id', $wsclasssection->wsclass_id)
                    ->where('wssection_id', $wsclasssection->wssection_id)
                    ->where('wssubject_id', $classSubject)
                    // ->sum('weekly_total_periods')
                    ->get();

                $subjectDetails = array();
                foreach($classSubjectWTPs as $classSubjectWTP){
                    
                    $data = [ 
                        'teacher_id' => $classSubjectWTP->wsteacher_id ?? null,
                        'weekly_total_periods' => $classSubjectWTP->weekly_total_periods ?? null,
                        'weekly_total_periods_alloted' => $classSubjectWTP->weekly_total_periods_alloted ?? null,
                        'is_class_teacher' => $classSubjectWTP->is_classteacher ?? null,
                    ];
                    array_push($subjectDetails, $data);
                }

                $this->classSectionActiveSubjects[$wsclasssection->wsclass_id][$wsclasssection->wssection_id][$classSubject] = $subjectDetails;
            }
        }
    }

    public function assignDayPeriodOne($day_id = 1, $period_id = 1){

        // $classSectionSubjectCombinations = $this->classSectionActiveSubjects[6][2];
        foreach($this->wsclasssections as $wsclasssection){
            $classSectionSubjectCombinations = $this->classSectionActiveSubjects[$wsclasssection->wsclass_id][$wsclasssection->wssection_id];
        
            foreach($classSectionSubjectCombinations as $key => $classSectionSubjectCombination){

                foreach($classSectionSubjectCombination as $classSectionSubject){
                    if($period_id = 1 && $classSectionSubject['is_class_teacher'] == 1){
                        // dd($day_id, $period_id, 6, 2, $key, $classSectionSubject['teacher_id']);
                        $this->assignWeeklySchedule($day_id, $period_id, $wsclasssection->wsclass_id, $wsclasssection->wssection_id, $key, $classSectionSubject['teacher_id']);

                    }
                    // else{
                    //     $teacher_id = $classSectionSubject['teacher_id'];
                    //     $data = Wsweeklyschedule::where('wsday_id', $day_id)
                    //         ->where('wsperiod_id', $period_id)
                    //         ->where('wsteacher_id', $teacher_id)
                    //         ->get();
                    //     if($data == null || $data->count() == 0){
                    //         $this->assignWeeklySchedule($day_id, $period_id, $wsclasssection->wsclass_id, $wsclasssection->wssection_id, $key, $classSectionSubject['teacher_id']);
                    //     }


                    // }
                }

            }
        }
    }


    public function assignDayPeriodTwo($day_id = 1, $period_id = 8){

        // $classSectionSubjectCombinations = $this->classSectionActiveSubjects[6][2];
        foreach($this->wsclasssections as $wsclasssection){
            $classSectionSubjectCombinations = $this->classSectionActiveSubjects[$wsclasssection->wsclass_id][$wsclasssection->wssection_id];
        
            foreach($classSectionSubjectCombinations as $key => $classSectionSubjectCombination){

                foreach($classSectionSubjectCombination as $classSectionSubject){
                    // if($period_id = 1 && $classSectionSubject['is_class_teacher'] == 1){
                    //     // dd($day_id, $period_id, 6, 2, $key, $classSectionSubject['teacher_id']);
                    //     $this->assignWeeklySchedule($day_id, $period_id, $wsclasssection->wsclass_id, $wsclasssection->wssection_id, $key, $classSectionSubject['teacher_id']);

                    // }else{
                        $teacher_id = $classSectionSubject['teacher_id'];
                        $data = Wsweeklyschedule::where('wsday_id', $day_id)
                            ->where('wsperiod_id', $period_id)
                            ->where('wsteacher_id', $teacher_id)
                            ->get();
                        if($data == null || $data->count() == 0){
                            $this->assignWeeklySchedule($day_id, $period_id, $wsclasssection->wsclass_id, $wsclasssection->wssection_id, $key, $classSectionSubject['teacher_id']);
                            break;
                        }


                    // }
                }

            }
        }
    }


    public function find_ActiveTeachers(){
        $this->activeTeachers = Wsclasssectionsubjectteacherweektp::where('is_active', 1)
            ->get()
            ;
    }

    public function assignWeeklySchedule($day_id, $period_id, $class_id, $section_id, $subject_id = null, $teacher_id = null){
        try {

            Wsweeklyschedule::updateOrCreate([
                'wsday_id'        => $day_id,
                'wsperiod_id'     => $period_id,
                'wsclass_id'    => $class_id,
                'wssection_id'  => $section_id,
                
            ],[
                'wssubject_id'  => $subject_id,
                'wsteacher_id'  => $teacher_id,
                'status'        => 'active',
                'school_id'     => 1,
                'session_id'    => 1,
            ]);
        
            $weekly_total_periods_alloted = Wsweeklyschedule::where('wsclass_id', $class_id)
                ->where('wssection_id', $section_id)
                ->where('wssubject_id', $subject_id)
                ->where('wsteacher_id', $teacher_id)
                ->count();
            
            Wsclasssectionsubjectteacherweektp::where('wsclass_id', $class_id)
                ->where('wssection_id', $section_id)
                ->where('wssubject_id', $subject_id)
                ->where('wsteacher_id', $teacher_id)
                ->update([
                    'weekly_total_periods_alloted' => $weekly_total_periods_alloted
                ]);

            // $weekly_total_periods_alloted->update([
            //     'weekly_total_periods_alloted' => $weekly_total_periods_alloted->weekly_total_periods_alloted + 1
            // ]);
        
        

            session()->flash('message', 'Class Schedule Updated Successfully');
        }catch(\Exception $e){
            session()->flash('error', 'Error saving class schedule: ' . $e->getMessage());
        }
        
    }


    public function revokeWeeklySchedule($day_id, $period_id, $class_id, $section_id, $subject_id, $teacher_id){
        try {

            Wsweeklyschedule::updateOrCreate([
                'day_id'        => $day_id,
                'period_id'     => $period_id,
                'wsclass_id'    => $class_id,
                'wssection_id'  => $section_id,
                'wssubject_id'  => $subject_id,
                'wsteacher_id'  => $teacher_id,
                
            ],[
                'wssubject_id'  => null,
                'wsteacher_id'  => null,
                'status'        => 'active',
                'school_id'     => 1,
                'session_id'    => 1,
            ]);
        
            $weekly_total_periods_alloted = Wsclasssectionsubjectteacherweektp::where('wsclass_id', $class_id)
                ->where('wssection_id', $section_id)
                ->where('wssubject_id', $subject_id)
                ->where('wsteacher_id', $teacher_id)
                ->first();

            $weekly_total_periods_alloted->update([
                'weekly_total_periods_alloted' => $weekly_total_periods_alloted->weekly_total_periods_alloted - 1
            ]);
        
        

            session()->flash('message', 'Class Schedule Updated Successfully');
        }catch(\Exception $e){
            session()->flash('error', 'Error saving class schedule: ' . $e->getMessage());
        }
        
    }




    public function assignPeriodSubjects($period_id){
        $classAssignedSubjects = Wsweeklyschedule::all()
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
