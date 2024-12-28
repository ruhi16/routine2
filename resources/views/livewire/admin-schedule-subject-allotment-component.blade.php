<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200">
            <thead>
                <tr class="border border-gray-500">
                    <th class="px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-500">Day</th>
                    @foreach($wsclasses as $wsclass)
                    @php $page_wsclasssections = $wsclasssections->where('wsclass_id', $wsclass->id) @endphp

                    <th colspan="{{ $page_wsclasssections->count() }}" class=" px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-500">
                        {{ $wsclass->name }}: (WTP-{{ $wsclassdaytps->where('wsclass_id', $wsclass->id)->sum('daily_total_periods') }})

                        {{-- @foreach($page_wsclasssections as $wsclasssection)
                    {{ $wsclasssection->wsclass->status ?? 'x'}}-{{ $wsclasssection->wssection->name ?? 'x'}}
                        @endforeach --}}

                    </th>
                    @endforeach
                </tr>


                <tr class="border border-gray-500">
                    <th class="px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-500">Day</th>
                    @foreach($wsclasses as $wsclass)
                    @php $page_wsclasssections = $wsclasssections->where('wsclass_id', $wsclass->id) @endphp

                    @foreach($page_wsclasssections as $wsclasssection)
                    <th class=" px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-500">
                        {{ $wsclasssection->wsclass->status ?? 'x'}}-{{ $wsclasssection->wssection->name ?? 'x'}}
                    </th>
                    @endforeach

                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($wssubjects as $wssubject)
                <tr class="border border-gray-200">
                    <td class="px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-200">{{ $wssubject->name }}</td>

                    @foreach($wsclasses as $wsclass)

                    @foreach($wsclasssections->where('wsclass_id', $wsclass->id) as $wsclasssection)
                    @php
                    $page_wsclasssubjects = $wsclasssubjects->where('wsclass_id', $wsclasssection->wsclass_id)->where('wssubject_id', $wssubject->id);
                    @endphp

                    <td class="px-2 py-1 text-xs font-medium text-gray-900 uppercase tracking-wider border border-gray-200">

                        @forelse($page_wsclasssubjects as $page_wsclasssubject)
                        {{ $page_wsclasssubject->wssubject->name_in_short }}:<br />
                            @php
                            $page_wsclasssectionsubjectteachers = $wsclasssectionsubjectteachers
                                ->where('wsclass_id', $wsclasssection->wsclass_id)
                                ->where('wssection_id', $wsclasssection->wssection_id)
                                ->where('wssubject_id', $wssubject->id);
                            @endphp

                            @foreach($page_wsclasssectionsubjectteachers as $page_wsclasssectionsubjectteacher)
                                {{-- {{ $page_wsclasssectionsubjectteacher->wssubject->name_in_short }}- --}}
                                @if($page_wsclasssectionsubjectteacher->is_classteacher == 1)
                                    <span class="bg-red-500 text-white px-2">
                                    {{ $page_wsclasssectionsubjectteacher->wsteacher->name_alias ?? 'x'}}
                                    {{ $page_wsclasssectionsubjectteacher->weekly_total_periods ?? 'x' }}
                                    </span>
                                @else
                                    {{ $page_wsclasssectionsubjectteacher->wsteacher->name_alias ?? 'x'}}
                                    {{ $page_wsclasssectionsubjectteacher->weekly_total_periods ?? 'x' }}
                                @endif
                                <br />
                            @endforeach


                        @empty
                        -
                        @endforelse
                    </td>
                    @endforeach

                    @endforeach

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
