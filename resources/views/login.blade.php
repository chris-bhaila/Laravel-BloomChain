<x-app-layout>
    <div class="h-screen w-full flex items-center justify-center bg-green-900"> <!--Forces a full viewport height-->

        <div class="w-4/5 h-4/5 flex flex-col items-center text-black rounded-[24px] shadow-xl p-8 bg-gray-50">

            <!-- Logo -->
            <img
                src="{{ asset('images/BloomChain.png') }}"
                alt="Logo"
                class="w-32 mb-10"
            >

            <!-- Google button -->
            <a href="{{ route('google.redirect') }}"
            class="flex items-center gap-3 px-6 py-3 bg-white/30 border border-gray-300 text-gray-700 rounded-[28px] shadow hover:bg-gray-100 transition duration-300">
                <svg class="w-7 h-7" viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#4285F4" d="M533.5 278.4c0-17.4-1.6-34-4.8-50H272v95.2h146.9c-6.3 34-25 62.9-53.1 82l85.7 66.6c50-46.1 78-114 78-193.8z"/>
                    <path fill="#34A853" d="M272 544.3c71.7 0 132-23.8 176-64.6l-85.7-66.6c-23.8 16-54.2 25.5-90.3 25.5-69.3 0-128-46.9-149-110.1l-87.1 67.4c44 87.7 134.3 148.4 236.1 148.4z"/>
                    <path fill="#FBBC05" d="M123 323.1c-10-29.4-10-61.4 0-90.8l-87.1-67.4c-38.3 76.7-38.3 167.8 0 244.5l87.1 67.3z"/>
                    <path fill="#EA4335" d="M272 107.6c37.5 0 71 12.9 97.4 34.6l73-73C404 24 344.8 0 272 0 170.2 0 80 60.7 36 148.4l87.1 67.4c21-63.2 79.7-110.1 148.9-110.1z"/> </svg>
                <span class="text-xl font-medium">Sign in with Google</span> </a>
        </div>
    </div>
</x-app-layout>
