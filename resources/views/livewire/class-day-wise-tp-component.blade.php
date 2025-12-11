<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                @foreach($days as $day)
                    <th class="px-2 py-2 text-left text-xs font-light text-gray-500 uppercase tracking-wider">{{ $day->name }}</th>
                @endforeach
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wk Total</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($myclasses as $class)
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $class->name }}</td>
                    @php
                        $classDayTps = $schedules->where('class', $class->name);
                    @endphp
                    @foreach($days as $day)
                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ $classDayTps->where('day', $day->name)->first()['periods'] ?? 'N/A' }}
                        </td>
                    @endforeach

                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-start">{{ $classDayTps->sum('periods') }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    </td>
                </tr>
            @endforeach
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">Total</td>
                    @foreach($days as $day)
                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ $schedules->where('day', $day->name)->sum('periods') }}
                        </td>
                    @endforeach
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-start">{{ $schedules->sum('periods') }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"></td>

                </tr>
        </tbody>
    </table>
</div>
