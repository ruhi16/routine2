<div>

	{{-- Hello! <span class="font-bold">{{ auth()->user()->name }}</span> You're logged in! --}}

	{{-- @foreach($clsSecs as $clsSec)
		{{ $clsSec->wsclass->name }}-{{ $clsSec->wssection->name }}:
		 @foreach($clsSec->wsclass->wsclasssubjects as $wsclasssubject)

		 	@if($wsclasssubject->wssubject->subject_type == 'Summative' && $wsclasssubject->is_additional == false)
				{{ $wsclasssubject->wssubject->name }},
			
			@endif

		 @endforeach
		<br/>
	@endforeach --}}

	@foreach($this->findClass_ActiveSubjects(5) as $classSubjects)
		{{-- {{ $classSubjects->wssubject->name }}, --}}
		{{ $classSubjects }},
	@endforeach


	{{ $this->assignClassSection_ActiveSubjects() }}
	{{-- @foreach($classSectionActiveSubjects as $classSectionActiveSubject) --}}
		xx{{ var_dump( $this->classSectionActiveSubjects ) }}yy
	{{-- @endforeach --}}

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
					<th class=" px-2 py-1 text-xs font-bold text-gray-500 uppercase tracking-wider border border-gray-500">
						
					</th>
					@endforeach
				</tr>
                @endforeach

			</tbody>
		</table>
	</div>



	
</div>