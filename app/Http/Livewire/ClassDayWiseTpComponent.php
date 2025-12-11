<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Wsclassdaytp;
use App\Models\Wsclass;
use App\Models\Wssection;
use App\Models\Wsday;

class ClassDayWiseTpComponent extends Component
{
    public $myclasses, $sections, $days;
    
    public $classDayDetails;
    

    public function mount()
    {
        $this->myclasses = Wsclass::all();
        $this->sections = Wssection::all();
        $this->days = Wsday::all();

        $this->classDayDetails = Wsclassdaytp::with('wsclass', 'wsday')
        ->get()
        ->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'class' => $schedule->wsclass->name,
                'day' => $schedule->wsday->name,
                'periods' => $schedule->daily_total_periods,
                'status' => $schedule->status ?? 'Active',
            ];
        });
        // dd($this->classDayDetails);
    }
    public function render()
    {
        return view('livewire.class-day-wise-tp-component', [
            'schedules' => $this->classDayDetails
        ]);
    }
}
