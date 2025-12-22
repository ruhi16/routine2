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
                        <th class="px-4 py-2 border border-gray-300 bg-gray-100">Daily Total Periods</th>
                        <th class="px-4 py-2 border border-gray-300 bg-gray-100">Weekly Total Periods</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300 font-semibold bg-gray-50">
                            {{ $teacher->name }} ({{ $teacher->name_alias }})
                            <div class="float-right">
                                <button wire:click="openAddModal({{ $teacher->id }})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">
                                    Add
                                </button>
                            </div>
                        </td>
                        @foreach($periods as $period)
                        @php
                        $classSection = $scheduleData[$teacher->id][$period->id] ?? '';
                        @endphp
                        <td class="px-4 py-2 border border-gray-300 relative">
                            {{ $classSection }}
                            @if($classSection)
                            <button
                                wire:click="removeSchedule({{ $selectedDay }}, {{ $period->id }}, {{ $teacher->id }})"
                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-700">
                                &times;
                            </button>
                            @endif
                        </td>
                        @endforeach
                        <td class="px-4 py-2 border border-gray-300 text-center font-semibold">
                            {{ $dailyTotals[$teacher->id] ?? 0 }}
                        </td>
                        <td class="px-4 py-2 border border-gray-300 text-center font-semibold">
                            {{ $weeklyTotals[$teacher->id] ?? 0 }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <!-- Session Messages -->
    @if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('message') }}</span>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Add Schedule Modal -->
    @if($isModalOpen)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div
            class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white max-h-screen overflow-y-auto">
            <div class="mt-3">
                <div class="flex justify-between items-center pb-3 border-b">
                    <p class="text-2xl font-bold text-gray-800">Add Schedule for {{ $selectedTeacher->name ?? 'Teacher'
                        }}</p>
                    <button wire:click="closeAddModal"
                        class="text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                </div>

                <div class="mt-6">
                    <!-- Teacher Selection -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Selected Teacher</label>
                        <div class="px-4 py-3 bg-gray-100 rounded font-semibold">
                            {{ $selectedTeacher->name }} ({{ $selectedTeacher->name_alias }})
                        </div>
                    </div>

                    <!-- Subject Selection -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="subject">Select Subject</label>
                        <select wire:model="selectedSubject"
                            class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                            <option value="">Choose a subject</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedSubject')
                        <span class="text-red-500 text-xs italic mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Class Selection -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="class">Select Class</label>
                        <select wire:model="selectedClass" @if(!$selectedSubject) disabled @endif
                            class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 @if(!$selectedSubject) bg-gray-100 cursor-not-allowed @endif">
                            <option value="">Choose a class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @if(!$selectedSubject)
                        <span class="text-gray-500 text-xs italic mt-1 block">Please select a subject first</span>
                        @endif
                        @error('selectedClass')
                        <span class="text-red-500 text-xs italic mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Section Selection -->
                    <div class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="section">Select Section</label>
                        <select wire:model="selectedSection" @if(!$selectedClass) disabled @endif
                            class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 @if(!$selectedClass) bg-gray-100 cursor-not-allowed @endif">
                            <option value="">Choose a section</option>
                            @foreach($sections as $section)
                            <option value="{{ $section->wssection_id }}">{{ $section->wssection->name }}</option>
                            @endforeach
                        </select>
                        @if(!$selectedClass)
                        <span class="text-gray-500 text-xs italic mt-1 block">Please select a class first</span>
                        @endif
                        @error('selectedSection')
                        <span class="text-red-500 text-xs italic mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Day and Period Selection Table -->
                    @if($selectedSubject && $selectedClass && $selectedSection)
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Select Period for Each Day</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300 rounded">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th
                                            class="px-6 py-3 border-b border-gray-300 text-left text-sm font-semibold text-gray-700">
                                            Day</th>
                                        <th
                                            class="px-6 py-3 border-b border-gray-300 text-left text-sm font-semibold text-gray-700">
                                            Available Periods</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($days as $day)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 border-b border-gray-300 font-medium text-gray-900">{{
                                            $day->name }}</td>
                                        <td class="px-6 py-4 border-b border-gray-300">
                                            <div class="flex flex-wrap gap-3">
                                                @foreach($periods as $period)
                                                <label
                                                    class="inline-flex items-center bg-white border border-gray-300 rounded-md px-4 py-2 hover:bg-blue-50 transition-colors duration-150 cursor-pointer">
                                                    <input type="radio" wire:model="selectedPeriods.{{ $day->id }}"
                                                        value="{{ $period->id }}"
                                                        class="form-radio h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                                                    <span class="ml-2 text-gray-700">{{ $period->name }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-8 text-gray-500">
                        <p>Please select subject, class, and section to view available periods.</p>
                    </div>
                    @endif
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button wire:click="closeAddModal"
                        class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                        Cancel
                    </button>
                    <button wire:click="saveSchedule"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Save Schedule
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>