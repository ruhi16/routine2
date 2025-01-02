<div>
	<div class="h-fit min-w-full mx-auto">
		Message:         
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>

	{{-- @foreach($wsclasssections as $wsclasssection)
		{{ $wsclasssection->wsclass->status }}{{ $wsclasssection->wssection->name }}: {{ json_encode( $this->findClass_ActiveSubjects( $wsclasssection->wsclass_id ) ) }}, <br/>
	@endforeach --}}

	{{-- {{ $this->assignClassSection_ActiveSubjects() }} --}}
	All Subjects: {{ json_encode( $this->allSubjects ) }}
	Scheduled Subjects: {{ json_encode( $this->scheduledSubjects ) }}
	Only Active Subjects: {{ json_encode( $this->only_active_subjects ) }}

	<br/>
	{{-- @foreach($wsclasssections as $wsclasssection)
		{{ $wsclasssection->wsclass->status }}{{ $wsclasssection->wssection->name }}:
		{{ json_encode( $this->classSectionActiveSubjects[$wsclasssection->wsclass_id][$wsclasssection->wssection_id] ) }}, <br/><br/><br/>
	@endforeach --}}

	{{-- Assign Period One: {{ $this->assignDayPeriodOne(1,1) }} --}}
	{{-- Assign Period Two: {{ $this->assignDayPeriodTwo(1, 8) }} --}}

	
	Test_VAL: {{ $test_val }}
	<div class="overflow-x-auto">
        <table class="w-full border border-gray-500">
            <thead>
                <tr class="border-b border-gray-500">
                    <th class="px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-500"></th>
					@php $btnColor = ['blue', 'red', 'green', 'purple', 'indigo', 'orange', 'violet', 'rose']@endphp
                    @foreach($wsperiods as $index => $wsperiod)
					<th class=" px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-500">
						{{-- {{ $wsperiod->id }} --}}
						@if($loop->first)
							<button wire:click="assignDayPeriodOne({{ $wsperiod->id }})" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
								{{ $wsperiod->id }} Generate
							</button>
						@else 
							<button wire:click="assignDayPeriodTwo({{ $wsperiod->id }})" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
								{{ $wsperiod->id }} Generate
							</button>
						@endif

					</th>
					@endforeach
                </tr>
            </thead>
			<thead>
                <tr class="border-b border-gray-500">
                    <th class="px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-500">Class-Section</th>
                    @foreach($wsperiods as $wsperiod)
					<th class=" px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-500">
						{{ $wsperiod->id }}
					</th>
					@endforeach
                </tr>
            </thead>


			<tbody>
				@foreach($wsclasssections as $wsclasssection)
				<tr>
					<td class=" px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-500">
						{{ $wsclasssection->wsclass->name }}-{{ $wsclasssection->wssection->name }}
					</td>
					@foreach($wsperiods as $wsperiod)
					<th class=" px-2 py-1 text-xs font-bold text-black uppercase tracking-wider border border-gray-500">
						@php $data = $weeklySchedules->where('wsday_id', 1)->where('wsperiod_id', $wsperiod->id)->where('wsclass_id', $wsclasssection->wsclass_id)->where('wssection_id', $wsclasssection->wssection_id); @endphp

						@if($data->count() > 0)
							@foreach($data as $item)
							{{ $item->wssubject->name_in_short ?? 'x' }}-{{ $item->wsteacher->name_alias ?? 'x' }}<br/>
							@endforeach
						@endif
					</th>
					@endforeach
				</tr>
                @endforeach

			</tbody>

			<thead>
				<tr class="border-b border-gray-500"><td colspan="9"></td></tr>
                <tr class="border-b border-gray-500">
                    <th class="px-2 py-1 text-xs font-bold text-red-600 uppercase tracking-wider border border-gray-500">Teachers</th>
                    @foreach($wsperiods as $wsperiod)
					<th class=" px-2 py-1 text-xs font-bold text-red-600 uppercase tracking-wider border border-gray-500">
						{{ $wsperiod->id }}
					</th>
					@endforeach
                </tr>
            
			</thead>

			<tbody>
				@foreach($allTeachers as $teacher)
				<tr>
					<td class=" px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-500">
						{{ $teacher->name }} ({{ $teacher->name_alias }})
					</td>
					@foreach($wsperiods as $wsperiod)
					<th class=" px-2 py-1 text-xs font-bold text-black uppercase tracking-wider border border-gray-500">
						@php $data = $weeklySchedules->where('wsday_id', 1)->where('wsperiod_id', $wsperiod->id)->where('wsteacher_id', $teacher->id); @endphp

						@if($data->count() > 0)
							@foreach($data as $item)
							{{ $item->wssubject->name_in_short ?? 'x' }}: {{ $item->wsclass->status ?? '-' }} {{ $item->wssection->name ?? '-' }}
							<br/>
							@endforeach
						@endif
					</th>
					@endforeach
				</tr>				
				@endforeach


			</tbody>

		</table>
	</div>


	


	
</div>