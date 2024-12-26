<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider">Day</th>
                    @foreach($wsclasses as $wsclass)
                    <th class=" px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider">{{ $wsclass->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($wsdays as $wsday)
                <tr class="border border-gray-200 ">
                    <td class="px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-200">{{ $wsday->name }}</td>
                    @foreach($wsclasses as $wsclass)
                    @php
                    $page_wsclassdaytps = $wsclassdaytps->where('wsclass_id', $wsclass->id)->where('wsday_id', $wsday->id);
                    @endphp

                    <td class="px-2 py-1 text-xs font-medium text-gray-900 uppercase tracking-wider border border-gray-200">
                        {{ $wsclass->status }}:
                        @foreach($page_wsclassdaytps as $page_wsclassdaytp)
                        {{ $page_wsclassdaytp->daily_total_periods }}<br />
                        @endforeach
                    </td>
                    @endforeach
                </tr>
                @endforeach
                <tr class="border border-gray-600">
                    <td class="px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-600">
                        Total
                    </td>
                    @foreach($wsclasses as $wsclass)
                    <th class=" px-2 py-1 text-xs font-bold text-gray-900 uppercase tracking-wider border border-gray-600">
                        {{ $wsclassdaytps->where('wsclass_id', $wsclass->id)->sum('daily_total_periods') }}
                    </th>
                    @endforeach

                </tr>



            </tbody>
        </table>
    </div>

    
</div>
