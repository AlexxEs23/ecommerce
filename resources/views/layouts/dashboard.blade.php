<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'Dashboard - UMKM Marketplace')</title>
    <meta name="description" content="@yield('meta_description', 'Dashboard UMKM Marketplace untuk mengelola akun, produk, dan pesanan Anda.')">
    <meta name="robots" content="noindex, nofollow">
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    @stack('styles')
    
    <style>
        html {
            scroll-behavior: smooth;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    {{-- Top Bar --}}
    @include('components.topbar')
    
    {{-- Navigation --}}
    @include('components.navbar')
    
    {{-- Main Layout with Sidebar --}}
    <div class="flex">
        {{-- Sidebar --}}
        @include('components.sidebar')
        
        {{-- Main Content --}}
        <main class="flex-1 p-6" role="main">
            {{-- Breadcrumb --}}
            @if(isset($breadcrumbs))
                <nav aria-label="Breadcrumb" class="mb-6">
                    <ol class="flex items-center space-x-2 text-sm">
                        @foreach($breadcrumbs as $index => $breadcrumb)
                            <li class="flex items-center">
                                @if($loop->last)
                                    <span class="text-gray-500">{{ $breadcrumb['title'] }}</span>
                                @else
                                    <a href="{{ $breadcrumb['url'] }}" class="text-purple-600 hover:underline">
                                        {{ $breadcrumb['title'] }}
                                    </a>
                                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif
            
            {{-- Page Content --}}
            @yield('content')
        </main>
    </div>
    
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
        
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            
            if(sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });
    </script>
</body>
</html>
