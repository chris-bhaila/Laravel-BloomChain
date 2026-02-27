@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $transaction = $user->transactions()->latest()->get();
@endphp
<div class="fade-up bg-white p-6 rounded-xl shadow mb-2">
    <h3 class="text-2xl font-semibold mb-6">Purchase History</h3>

    {{-- Desktop Table (hidden on mobile) --}}
    <div class="hidden md:block rounded-xl overflow-hidden border border-gray-300">
        <table class="table-auto border-collapse w-full">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border px-4 py-2">Purchase Date</th>
                    <th class="border px-4 py-2">Plan</th>
                    <th class="border px-4 py-2">Amount</th>
                    <th class="border px-4 py-2">Payment Method</th>
                    <th class="border px-4 py-2">Expiration Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction as $t)
                    <tr>
                        <td class="border px-4 py-2">{{ $t->created_at->format('M d, Y') }}</td>
                        <td class="border px-4 py-2">{{ ucwords($t->plan, '-') }}</td>
                        <td class="border px-4 py-2">Rs. {{ number_format($t->amount) }}</td>
                        <td class="border px-4 py-2">eSewa</td>
                        <td class="border px-4 py-2">{{ $t->renewal_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Mobile Cards (hidden on desktop) --}}
    <div class="flex flex-col gap-4 md:hidden">
        @foreach ($transaction as $t)
            <div class="border border-gray-300 rounded-xl p-4 text-sm">
                <div class="flex justify-between items-center mb-3">
                    <span class="font-semibold text-base">{{ ucwords($t->plan, '-') }}</span>
                    <span class="font-bold text-gray-800">Rs. {{ number_format($t->amount) }}</span>
                </div>
                <div class="grid grid-cols-2 gap-y-2 text-gray-600">
                    <span class="font-medium text-gray-500">Purchase Date</span>
                    <span>{{ $t->created_at->format('M d, Y') }}</span>

                    <span class="font-medium text-gray-500">Payment Method</span>
                    <span>eSewa</span>

                    <span class="font-medium text-gray-500">Expiration Date</span>
                    <span>{{ $t->renewal_at->format('M d, Y') }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>