<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contaner') }}: <span class="font-bold">{{ auth()->user()->name }}</span> You're logged in!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 ">

                    
                    {{-- <livewire:admin-schedule-day-class-details-component /> --}}
                    <div class="mt-4 "></div>
                    {{-- <livewire:admin-schedule-subject-allotment-component /> --}}
                    @livewire('admin-schedule-subject-allotment-component')
                    
                    <div class="mt-4 "></div>                    
                    @livewire('admin-schedule-details-component')
                    
                </div>
            </div>
        </div>
    </div>




</div>
