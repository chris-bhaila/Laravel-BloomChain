@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

<div class="fade-up bg-white p-4 flex flex-col rounded-xl shadow mb-2">

    <h2 class="text-2xl font-bold mb-4">Settings</h2>

    @if ($user->verification_status === 'verified')
        <a href="{{ route('editProfile') }}"
            class="rounded-xl border-2 p-4 mb-2 flex justify-between hover:bg-gray-200 cursor-pointer transition duration-150 ease-in-out">
            <p class="text-xl font-bold">Edit Profile</p>
            <p>></p>
        </a>
    @endif
    <a href={{ route('security') }}
        @click.prevent="navigate('{{ route('security') }}', 'settings.security')"
        class="rounded-xl border-2 p-4 flex justify-between hover:bg-gray-200 cursor-pointer transition duration-150 ease-in-out">
        <p class="text-xl font-bold">Security</p>
        <p>></p>
    </a>
</div>
