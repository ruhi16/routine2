<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <h1 class="text-2xl font-bold mb-4">Class (Section) Subject Wise Total Periods</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
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
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $class->name }}</td>
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
                            @if($weeklyTotalForClass > 0)
                                <span class="text-green-500">✓</span>
                            @else
                                <span class="text-red-500">✗</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                            <button wire:click="openModal({{ $class->id }})" class="text-indigo-600 hover:text-indigo-900">
                                Add/Update
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal --}}
    @if($showModal)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- Background overlay --}}
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                {{-- Modal panel --}}
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Update Weekly Periods for {{ $selectedClass->name }}
                            </h3>
                            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                                @foreach($subjects as $subject)
                                    <div class="sm:col-span-1">
                                        <label for="subject_{{ $subject->id }}" class="block text-sm font-medium text-gray-700">
                                            {{ $subject->name }} ({{ $subject->id }})
                                        </label>
                                        <div class="mt-1">
                                            <input type="number" wire:model.defer="classSubjectsData.{{ $subject->id }}" id="subject_{{ $subject->id }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Save
                            </button>
                            <button wire:click="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

