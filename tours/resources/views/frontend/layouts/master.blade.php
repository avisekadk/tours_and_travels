{{-- resources/views/frontend/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'HimalayaVoyage - Nepal Tours & Travel')</title>
    
    <meta name="description" content="@yield('meta_description', 'Discover Nepal with expert guides. Book trekking, cultural tours, and adventure packages.')">
    <meta name="keywords" content="@yield('meta_keywords', 'Nepal tours, Everest trek, Nepal travel, Himalayan adventure')">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    
    @include('frontend.layouts.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('frontend.layouts.footer')
    
    @stack('scripts')
    
</body>
</html>