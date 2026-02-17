<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contact Us - SK Shoes</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Custom CSS -->
        <style>
            /* Add any custom styles here */
            .scale-125 {
                transform: scale(1.25);
            }
            html {
                scroll-behavior: smooth;
            }
        </style>
    </head>
    <body class="bg-gray-100">
        <!-- Include the header component -->
        <x-header />

        <!-- Contact Section -->
        <x-contact-section />

        <!-- Include the footer component -->
        <x-footer />
    </body>
</html> 