<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        .content-transition {
            transition: margin-left 0.3s ease-in-out;
        }
    </style>
    @stack('styles')
    
    <!-- Add in the head section -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <x-admin.header />
    
    <div class="min-h-screen flex pt-16"> <!-- Reduced top padding -->
        <x-admin.sidebar />
        
        <!-- Main Content -->
        <main class="flex-1 transition-all duration-300 content-transition p-4">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html> 