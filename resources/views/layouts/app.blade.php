<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Maison V - Premium Clothing Store')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .logo {
            font-family: 'Playfair Display', serif;
            letter-spacing: 2px;
        }
        
        .product-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .product-card img {
            transition: transform 0.5s ease;
        }
        
        .product-card:hover img {
            transform: scale(1.08);
        }
        
        .hero-section {
            background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
            min-height: 500px;
        }
        
        .category-badge {
            transition: all 0.3s ease;
        }
        
        .category-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #000000;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">

    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    @stack('scripts')
</body>
</html>