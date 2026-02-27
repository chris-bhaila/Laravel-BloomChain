@php
    use Illuminate\Support\Facades\Auth;
    use App\Helpers\UserAgentHelper;

    $user = Auth::user();
@endphp

<div class="fade-up bg-white p-6 rounded-xl shadow mb-2">
    <h3 class="text-2xl font-semibold mb-2">Login History</h3>

    <table class="table-auto border-collapse border border-gray-300 w-full">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="border px-4 py-2">IP Address</th>
                <th class="border px-4 py-2">Device / Browser</th>
                <th class="border px-4 py-2">Last Activity</th>
            </tr>
        </thead>
        <tbody>
            @foreach (auth()->user()->getLoginSessions() as $session)
                <tr @if ($session['session_id'] == session()->getId()) style="background-color: #e0ffe0;" @endif>
                    <td class="border px-4 py-2">{{ $session['ip_address'] }}</td>
                    <td class="border px-4 py-2">{{ UserAgentHelper::parse($session['user_agent']) }}</td>
                    <td class="border px-4 py-2">{{ $session['last_activity'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="mt-2 text-sm text-gray-600"><em>Green row indicates your current session</em></p>
</div>
