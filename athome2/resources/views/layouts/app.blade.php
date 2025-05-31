<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

         <!-- Include Swiper CSS -->
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <!--House Details JS-->
        @stack('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const swipers = document.querySelectorAll('.swiper');
                swipers.forEach(swiperEl => {
                    const slides = swiperEl.querySelectorAll('.swiper-slide');
                    const enableLoop = slides.length >= 2; // Adjust based on your slidesPerView and slidesPerGroup settings
                    new Swiper(swiperEl, {
                        loop: enableLoop,
                        pagination: {
                            el: swiperEl.querySelector('.swiper-pagination'),
                            clickable: true,
                        },
                        navigation: {
                            nextEl: swiperEl.querySelector('.swiper-button-next'),
                            prevEl: swiperEl.querySelector('.swiper-button-prev'),
                        },
                    });
                });
            });
        </script>
        
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    </body>
</html>
