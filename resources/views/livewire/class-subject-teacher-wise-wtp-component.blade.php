<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                    @foreach($subjects as $subject)
                        <th class="px-2 py-2 text-left text-xs font-light text-gray-500 uppercase tracking-wider">{{ $subject->name_in_short }}</th>
                    @endforeach
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wk Total</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($myclasses as $class)
                    @php
                        $selectedClassSections = $classSections->where('wsclass_id', $class->id);                        
                    @endphp
                    @foreach($selectedClassSections as $section)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $class->name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $section->wssection->name }}</td>
                            @php
                                $classSubjectWiseWtp = $classSubjectDetails->where('wsclass_id', $class->id);
                                $weeklyTotalForClass = 0; // Initialize
                            @endphp
                            @foreach($subjects as $subject)
                                @php
                                    $period = $classSubjectWiseWtp->where('wssubject_id', $subject->id)->first();
                                    $periodValue = $period->weekly_total_periods ?? 0;
                                    $weeklyTotalForClass += $periodValue;
                                @endphp
                                <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $periodValue }}
                                </td>
                            @endforeach
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $weeklyTotalForClass }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                {{-- @if($weeklyTotalForClass > 0)
                                    <span class="text-green-500">✓</span>
                                @else
                                    <span class="text-red-500">✗</span>
                                @endif --}}
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                {{-- <button wire:click="openModal({{ $class->id }})" class="text-indigo-600 hover:text-indigo-900">
                                    Add/Update
                                </button> --}}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>