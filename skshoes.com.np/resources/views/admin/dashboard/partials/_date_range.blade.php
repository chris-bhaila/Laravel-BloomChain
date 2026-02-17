<!-- Date Range Selector -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <h1 class="text-xl md:text-2xl font-semibold text-gray-800"></h1>
    <div class="flex flex-col w-full sm:w-auto gap-2">
        <div class="grid grid-cols-2 sm:flex gap-2">
            <!-- Year Selector -->
            <select id="yearSelect" name="year" class="w-full sm:w-auto bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm">
                <option value="All" selected>All Year</option>
                @foreach($availableYears as $year)
                <option value="{{ $year }}"
                    {{ request('year') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
                @endforeach
            </select>

            <!-- Month Selector -->
            <select id="monthSelect" name="month" class="w-full sm:w-auto bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm"
                @if (!request('year') || request('year')=='All' )
                    disabled
                @endif>
                <option value="All" selected>All Month</option>
                @php
                $months = [
                1 => 'January', 2 => 'February', 3 => 'March',
                4 => 'April', 5 => 'May', 6 => 'June',
                7 => 'July', 8 => 'August', 9 => 'September',
                10 => 'October', 11 => 'November', 12 => 'December'
                ];
                @endphp
                @foreach($months as $num => $name)
                <option value="{{ $num }}"
                    {{ request('month') == $num ? 'selected' : '' }}>
                    {{ $name }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
</div>