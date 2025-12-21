<div>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6">Class Section Wise Weekly Schedule</h2>

        <!-- Class Tabs -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-3">Select Class:</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($classes as $class)
                <button wire:click="selectClass({{ $class->id }})"
                    class="px-4 py-2 rounded-lg transition-colors duration-200 
                               {{ $selectedClass == $class->id ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                    {{ $class->name }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Section Tabs (shown only when a class is selected) -->
        @if($selectedClass)
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-3">Select Section:</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($sections as $section)
                <button wire:click="selectSection({{ $section->wssection_id }})"
                    class="px-4 py-2 rounded-lg transition-colors duration-200 
                                   {{ $selectedSection == $section->wssection_id ? 'bg-green-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                    {{ $section->wssection->name }}
                </button>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Schedule Table (shown only when both class and section are selected) -->
        @if($selectedClass && $selectedSection)
        <div class="mt-8 overflow-x-auto">
            <h3 class="text-lg font-semibold mb-3">Weekly Schedule</h3>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border border-gray-300 bg-gray-100">Days / Periods</th>
                        @foreach($periods as $period)
                        <th class="px-4 py-2 border border-gray-300 bg-gray-100">{{ $period->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($days as $day)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300 font-semibold bg-gray-50">{{ $day->name }}</td>
                        @foreach($periods as $period)
                        @php
                        $scheduleInfo = $scheduleData[$day->id][$period->id] ?? ['subject' => '', 'teacher' => ''];
                        @endphp
                        <td class="px-4 py-2 border border-gray-300">
                            <div class="font-medium">{{ $scheduleInfo['subject'] }}</div>
                            <div class="text-sm text-gray-600">{{ $scheduleInfo['teacher'] }}</div>
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