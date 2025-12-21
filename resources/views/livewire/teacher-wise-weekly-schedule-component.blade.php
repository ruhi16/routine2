<div>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6">Teacher Wise Weekly Schedule</h2>

        <!-- Day Tabs -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-3">Select Day:</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($days as $day)
                <button wire:click="selectDay({{ $day->id }})"
                    class="px-4 py-2 rounded-lg transition-colors duration-200 
                               {{ $selectedDay == $day->id ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                    {{ $day->name }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Schedule Table -->
        @if($selectedDay)
        <div class="mt-8 overflow-x-auto">
            <h3 class="text-lg font-semibold mb-3">Schedule for Selected Day</h3>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border border-gray-300 bg-gray-100">Teachers</th>
                        @foreach($periods as $period)
                        <th class="px-4 py-2 border border-gray-300 bg-gray-100">{{ $period->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300 font-semibold bg-gray-50">
                            {{ $teacher->name }} ({{ $teacher->name_alias }})
                        </td>
                        @foreach($periods as $period)
                        @php
                        $classSection = $scheduleData[$teacher->id][$period->id] ?? '';
                        @endphp
                        <td class="px-4 py-2 border border-gray-300">
                            {{ $classSection }}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>