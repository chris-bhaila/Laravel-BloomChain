<div class="fade-up bg-white p-4 flex flex-col rounded-xl shadow mb-2">

    <h2 class="text-2xl font-bold mb-4">Settings</h2>

    <a
        class="rounded-xl border-2 p-4 mb-2 flex justify-between hover:bg-gray-200 cursor-pointer transition duration-150 ease-in-out">
        <p class="text-xl font-bold">Change Password</p>
        <p>></p>
    </a>

    <a href="{{ route('settings.loginHistory') }}"
        @click.prevent="navigate('{{ route('settings.loginHistory') }}', 'settings.security.loginHistory', 'Login History')"
        class="rounded-xl border-2 p-4 flex justify-between hover:bg-gray-200 cursor-pointer transition duration-150 ease-in-out">
        <p class="text-xl font-bold">Where You're Logged In</p>
        <p>></p>
    </a>
</div>
