<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h4 class="text-xl font-semibold">Subject Teacher Details</h4>
        </div>
        <div class="p-6 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subject
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Teachers
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if($subjects)
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $subject->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @foreach ($subjectTeacherDetails->where('wssubject_id', $subject->id) as $subjectTeacher)
                                            <div class="flex flex-wrap">
                                                <span class="mr-2 mb-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 items-center">
                                                    {{ $subjectTeacher->teacher ? $subjectTeacher->teacher->name : 'N/a' }}
                                                    <button wire:click="removeTeacher({{ $subjectTeacher->id }})" class="ml-2 text-indigo-600 hover:text-indigo-900 focus:outline-none">
                                                        &times;
                                                    </button>
                                                            
                                            {{-- @if($subjectTeacher->subject->id == $subject->id)
                                                <div class="flex flex-wrap">
                                                    <span class="mr-2 mb-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 items-center">
                                                        @foreach($subjectTeacher as $subjectTeacherOnly)
                                                            {{ $subjectTeacherOnly ? $subjectTeacherOnly : 'N/a'}}
                                                            <button wire:click="removeTeacher({{ $subjectTeacher->id }})" class="ml-2 text-indigo-600 hover:text-indigo-900 focus:outline-none">
                                                                &times;
                                                            </button>
                                                                
                                                        @endforeach
                                                    </span>
                                                </div>
                                            @endif --}}
                                                </span>
                                            </div>
                                        @endforeach

                                        {{-- @if(isset($subjectTeacherDetails[$subject->id]))
                                            <div class="flex flex-wrap">
                                                @foreach ($subjectTeacherDetails[$subject->id] as $subjectTeacher)
                                                    @if($subjectTeacher->teacher)
                                                        <span class="mr-2 mb-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 items-center">
                                                            {{ $subjectTeacher->teacher->name }}
                                                            <button wire:click="removeTeacher({{ $subjectTeacher->id }})" class="ml-2 text-indigo-600 hover:text-indigo-900 focus:outline-none">
                                                                &times;
                                                            </button>
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif --}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button wire:click="openModal({{ $subject->id }})" class="text-indigo-600 hover:text-indigo-900">Add/Update</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($isModalOpen)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="addTeachers">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Add Teachers for Subject: {{ $selectedSubject->name ?? '' }}
                                    </h3>
                                    <div class="mt-4">
                                        <label for="teachers" class="block text-sm font-medium text-gray-700">Select Teachers to Add</label>
                                        <select wire:model="teachersToAdd" id="teachers" multiple class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            @foreach($allTeachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('teachersToAdd') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Add Teachers
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
