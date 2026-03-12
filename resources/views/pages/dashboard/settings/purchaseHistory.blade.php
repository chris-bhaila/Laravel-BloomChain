@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $transaction = $user->transactions()->latest()->get();
@endphp
<div class="fade-up bg-white p-6 rounded-xl shadow mb-2">
    <h3 class="text-2xl font-semibold mb-6">Purchase History</h3>
    <div class="flex flex-col gap-4">
        @foreach ($transaction as $t)
            <div class="border border-gray-300 rounded-xl p-4 text-sm">
                <div class="flex justify-between items-center mb-3">
                    <span class="font-semibold text-base">{{ ucwords($t->plan, '-') }}</span>
                    <span class="font-bold text-gray-800">Rs. {{ number_format($t->amount) }}</span>
                </div>
                <div class="grid grid-cols-2 gap-y-2 text-gray-600">
                    <span class="font-semibold font-medium text-gray-500">Purchase Date</span>
                    <span>{{ $t->created_at->format('M d, Y') }}</span>

                    <span class="font-semibold font-medium text-gray-500">Payment Method</span>
                    <span>eSewa</span>

                    <span class="font-semibold font-medium text-gray-500">Expiration Date</span>
                    <span>{{ $t->renewal_at->format('M d, Y') }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
