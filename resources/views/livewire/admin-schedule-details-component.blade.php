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

	{{ $this->assignClassSection_ActiveSubjects() }}
	{{-- {{ $this->assignDayPeriodOne() }} --}}

	{{-- {{ $this->assignDayPeriodTwo() }} --}}

	{{-- xx{{ json_encode( $this->classSectionActiveSubjects[6][2][1]) }} --}}

	@php 
		// $data = $this->classSectionActiveSubjects[6][2];
		$clTeacher = null;
	@endphp
	{{-- {{ json_encode( $this->classSectionActiveSubjects[6][2] ) }} --}}


	<div class="overflow-x-auto">
        <table class="w-full border border-gray-500">
            <thead>
                <tr class="border-b border-gray-500">
                    <th class="px-2 py-1 text-xs font-bold text-gray-500 uppercase tracking-wider border border-gray-500">Cls-Sec</th>
                    @foreach($wsperiods as $wsperiod)
					<th class=" px-2 py-1 text-xs font-bold text-gray-500 uppercase tracking-wider border border-gray-500">
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