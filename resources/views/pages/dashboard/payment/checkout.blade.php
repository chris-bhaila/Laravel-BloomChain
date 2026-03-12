@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    $plans = [
        'monthly' => ['label' => 'Monthly', 'price' => 999, 'total' => 999],
        'semi-annually' => ['label' => 'Semi-Annually', 'price' => 849, 'total' => 5094],
        'annually' => ['label' => 'Annually', 'price' => 599, 'total' => 7188],
    ];
    $selected = $plans[$plan ?? 'annually'];
@endphp
<style>
    .btn-slide {
        position: relative;
        overflow: hidden;
        z-index: 1;
        transition: all 250ms;
    }
    .btn-slide::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 0;
        border-radius: 15px;
        background-color: white;
        z-index: -1;
        transition: all 250ms;
    }
    .btn-slide:hover {
        color: #60BB46;
    }
    .btn-slide:hover::before {
        width: 100%;
    }
</style>
<div class="fade-up p-6 flex flex-col">
    <form method="POST" action="{{ route('esewa.initiate') }}">
        <input type="hidden" name="plan" value="{{ $plan }}">
        <div class="p-2">
            <h2 class="text-2xl font-semibold mb-6">Your Billing Details</h2>
            @csrf
            <div class="mb-4">
                <label for="name">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" class="w-full border-2 rounded-xl p-2 mt-1"
                    value="{{ $user->name }}" readonly />
            </div>
            <div class="mb-4">
                <label for="phone">Phone <span class="text-red-500">*</span></label>
                <input type="number" name="phone" class="w-full border-2 rounded-xl p-2 mt-1"
                    value="{{ $user->phone }}" readonly />
            </div>
            <div class="mb-4">
                <label for="email">Email <span class="text-red-500">*</span></label>
                <input type="text" name="email" class="w-full border-2 rounded-xl p-2 mt-1"
                    value="{{ $user->email }}" readonly />
            </div>
        </div>
        <div class="p-2">
            <h2 class="text-2xl font-semibold mb-4">Order</h2>
            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="p-4 text-left font-semibold text-gray-600 uppercase tracking-wider text-sm">
                                Subscription type</th>
                            <th class="p-4 text-left font-semibold text-gray-600 uppercase tracking-wider text-sm">
                                Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-md text-gray-700">{{ $selected['label'] }}</td>
                            <td class="p-4 text-md text-gray-700">
                                {{ $selected['total'] / $selected['price'] }}
                                @if ($selected['total'] / $selected['price'] == 1)
                                    month
                                @else
                                    months
                                @endif
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-md text-gray-700">Per Month</td>
                            <td class="p-4 text-md text-gray-700">Rs. {{ $selected['price'] }}</td>
                        </tr>
                        <tr class="bg-green-50 border-t-2 border-green-200">
                            <td class="p-4 font-bold text-lg text-gray-900">Grand Total</td>
                            <td class="p-4 font-bold text-lg text-[#16714B]">Rs. {{ number_format($selected['total']) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="btn-slide w-auto font-bold text-sm py-3 px-5 rounded-full text-white bg-[#60BB46] shadow-lg my-6 border-[3px] border-[#60BB46]">
                    Pay with eSewa
                </button>
            </div>
        </div>
    </form>
</div>