<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'UMKM Marketplace - Platform Jual Beli Produk Lokal Indonesia')</title>
    <meta name="description" content="@yield('meta_description', 'UMKM Marketplace adalah platform jual beli online yang menghubungkan UMKM Indonesia dengan pembeli di seluruh nusantara. Belanja produk lokal berkualitas dengan harga terjangkau.')">
    <meta name="keywords" content="@yield('meta_keywords', 'umkm, marketplace, belanja online, produk lokal, indonesia, jual beli, e-commerce')">
    <meta name="author" content="UMKM Marketplace">
    <meta name="robots" content="index, follow">
    
    {{-- Open Graph Meta Tags (Facebook, LinkedIn) --}}
    <meta property="og:title" content="@yield('og_title', 'UMKM Marketplace - Platform Jual Beli Produk Lokal Indonesia')">
    <meta property="og:description" content="@yield('og_description', 'Belanja produk UMKM lokal terbaik di Indonesia. Dukung ekonomi lokal dengan berbelanja di UMKM Marketplace.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:site_name" content="UMKM Marketplace">
    
    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'UMKM Marketplace')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Platform jual beli produk lokal Indonesia')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/twitter-image.jpg'))">
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Custom Styles --}}
    @stack('styles')
    <style>
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        /* Loading Spinner */
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #7c3aed;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Accessibility - Skip to main content */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 0;
            background: #7c3aed;
            color: white;
            padding: 8px;
            text-decoration: none;
            z-index: 100;
        }
        
        .skip-link:focus {
            top: 0;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    {{-- Skip to main content for accessibility --}}
    <a href="#main-content" class="skip-link">Skip to main content</a>
    
    {{-- Top Bar --}}
    @include('components.topbar')
    
    {{-- Navigation --}}
    @include('components.navbar')
    
    {{-- Main Content --}}
    <main id="main-content" class="flex-grow" role="main">
        @yield('content')
    </main>
    
    {{-- Footer --}}
    @include('components.footer')
    
    {{-- Toast Notifications --}}
    @if(session('success'))
        <div id="toast-success" class="fixed bottom-5 right-5 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 fade-in" role="alert">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div id="toast-error" class="fixed bottom-5 right-5 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 fade-in" role="alert">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif
    
    {{-- Custom Scripts --}}
    @stack('scripts')
    
    <script>
        // Auto-hide toast notifications
        setTimeout(function() {
            const toasts = document.querySelectorAll('[id^="toast-"]');
            toasts.forEach(toast => {
                if(toast) {
                    toast.style.transition = 'opacity 0.5s';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500);
                }
            });
        }, 5000);
        
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if(mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
