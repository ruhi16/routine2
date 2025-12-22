<div class="p-6">
    <h2 class="text-2xl font-bold mb-6">All Class Section Weekly Schedules</h2>

    @if(count($classSections) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($classSections as $classId => $sections)
        @if(isset($sections[0]) && $sections[0]->wsclass)
        @php
        $class = $sections[0]->wsclass;
        @endphp

        @foreach($sections as $classSection)
        @if($classSection->wssection)
        <div class="border border-gray-300 rounded-lg shadow-sm overflow-hidden">
            <div class="bg-gray-100 px-4 py-2 font-semibold border-b border-gray-300">
                {{ $class->name }} - {{ $classSection->wssection->name }}
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-2 py-1 border border-gray-300">Day</th>
                            @foreach($periods as $period)
                            <th class="px-2 py-1 border border-gray-300">{{ $period->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($days as $day)
                        <tr>
                            <td class="px-2 py-1 border border-gray-300 font-medium">{{ $day->name }}</td>
                            @foreach($periods as $period)
                            @php
                            $subjectTeacher =
                            $allScheduleData[$classId][$classSection->wssection_id][$day->id][$period->id] ?? '';
                            @endphp
                            <td class="px-2 py-1 border border-gray-300 {{ $subjectTeacher ? 'bg-blue-50' : '' }}">
                                {{ $subjectTeacher }}
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @endforeach
        @endif
        @endforeach
    </div>
    @else
    <div class="text-center py-8 text-gray-500">
        <p>No class sections found.</p>
    </div>
    @endif
</div>