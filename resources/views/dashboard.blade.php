<x-app-layout>
    <div x-data="{ open: true }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        <aside :class="open ? 'w-64' : 'w-16'" class="bg-gray-800 text-white flex flex-col transition-width duration-300">
            <div class="p-4 text-2xl font-bold">Logo</div>
            <nav class="flex-1 px-2 space-y-2 overflow-y-auto">
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Users</a>
            </nav>
            <div class="p-4 border-t border-gray-700">
                <button @click="open = !open" class="w-full bg-blue-600 py-2 rounded">Toggle</button>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-6 overflow-auto">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
            <p>Content goes here...</p>
        </main>

    </div>
</x-app-layout>
