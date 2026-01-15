<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOGUE — Brutalist Fashion Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=IBM+Plex+Mono:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0a0a0a',
                        secondary: '#f5f5f0',
                        accent: '#0066ff',
                        border: '#2a2a2a',
                    },
                    fontFamily: {
                        'display': ['Archivo Black', 'sans-serif'],
                        'mono': ['IBM Plex Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'IBM Plex Mono', monospace;
        }
        
        @keyframes slideDown {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-slideDown { animation: slideDown 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .animate-fadeInUp { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) backwards; }
        .animate-fadeInLeft { animation: fadeInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) backwards; }
        
        .hover-lift {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 12px 12px 0 #0a0a0a;
        }
        
        .btn-brutalist {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .btn-brutalist::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #0066ff;
            transition: left 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: -1;
        }
        
        .btn-brutalist:hover::before {
            left: 0;
        }
        
        .btn-brutalist:hover {
            border-color: #0066ff;
            transform: translateY(-2px);
            box-shadow: 0 8px 0 #0a0a0a;
        }
        
        .product-card {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 8px 8px 0 #0a0a0a;
        }
        
        .badge-corner::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 50px 50px 0;
            border-color: transparent #0066ff transparent transparent;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .badge-corner:hover::before {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-white text-gray-900">
    
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-3 max-w-7xl mx-auto">
            
            <!-- Brand Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard.index') }}" class="font-display text-2xl tracking-tighter uppercase text-gray-900">VOGUE</a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#new" class="text-sm text-gray-700 hover:text-blue-600 transition-colors font-medium">New Arrivals</a>
                <a href="#collections" class="text-sm text-gray-700 hover:text-blue-600 transition-colors font-medium">Collections</a>
                <a href="#categories" class="text-sm text-gray-700 hover:text-blue-600 transition-colors font-medium">Categories</a>
                <a href="#about" class="text-sm text-gray-700 hover:text-blue-600 transition-colors font-medium">About</a>
            </nav>

            <!-- Right Side Icons -->
            <div class="flex items-center space-x-4">
                
                <!-- Search Button -->
                <button class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                @auth
                    <!-- Notifications (Only for logged in users) -->
                    <button class="text-gray-500 hover:text-gray-700 relative transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
                    </button>

                    <!-- Cart -->
                    <button class="text-gray-500 hover:text-gray-700 relative transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">3</span>
                    </button>

                    <!-- Profile Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button 
                            @click="open = !open"
                            class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none transition-colors"
                        >
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-4 h-4 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div 
                            x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-100"
                            style="display: none;"
                        >
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    My Profile
                                </div>
                            </a>

                            <a href="#orders" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    My Orders
                                </div>
                            </a>

                            <a href="#wishlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    Wishlist
                                </div>
                            </a>

                            <a href="#settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Settings
                                </div>
                            </a>
                            
                            <div class="border-t border-gray-100 mt-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Login & Register Buttons (Only for guests) -->
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-blue-600 transition-colors font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">
                        Register
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button 
                    @click="mobileMenu = !mobileMenu" 
                    class="md:hidden text-gray-500 hover:text-gray-700"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-16 min-h-screen grid md:grid-cols-2 bg-gray-50">
        <div class="bg-secondary border-r-4 border-primary p-12 lg:p-20 flex flex-col justify-center animate-fadeInLeft">
            <h1 class="font-display text-6xl lg:text-8xl leading-none uppercase tracking-tighter mb-6">
                Street<br>
                <span class="text-accent">Style</span><br>
                Redefined
            </h1>
            <p class="text-lg lg:text-xl leading-relaxed mb-10 max-w-xl font-light">
                Where raw fashion meets bold statements. Curated streetwear and contemporary clothing for those who refuse to blend in. Unapologetically different.
            </p>
            <button class="btn-brutalist bg-primary text-secondary border-4 border-primary px-10 py-4 text-sm font-semibold uppercase tracking-widest self-start relative z-10">
                Shop Collection
            </button>
        </div>
        
        <div class="bg-primary relative overflow-hidden min-h-[600px]" style="animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.3s backwards;">
            <div class="absolute inset-0 opacity-5" style="background: linear-gradient(45deg, transparent 48%, #0066ff 48%, #0066ff 52%, transparent 52%), linear-gradient(-45deg, transparent 48%, #0066ff 48%, #0066ff 52%, transparent 52%); background-size: 100px 100px;"></div>
            <img src="data:image/svg+xml,%3Csvg width='800' height='800' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='800' height='800' fill='%230a0a0a'/%3E%3Ctext x='400' y='400' font-size='200' fill='%230066ff' opacity='0.3' text-anchor='middle' font-family='Arial Black'%3EVOGUE%3C/text%3E%3Crect x='200' y='600' width='400' height='100' fill='%23f5f5f0' opacity='0.2'/%3E%3C/svg%3E" alt="Hero" class="w-full h-full object-cover opacity-90">
        </div>
    </section>

    <!-- Flash Sale CTA -->
    <section class="bg-accent text-secondary py-8 border-y-4 border-primary">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="font-display text-3xl">⚡</div>
                <div>
                    <div class="font-display text-2xl uppercase tracking-tight">Flash Sale</div>
                    <div class="text-sm opacity-90">Up to 50% OFF • Limited Time Only</div>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex gap-3 text-center">
                    <div>
                        <div class="font-display text-3xl">05</div>
                        <div class="text-xs uppercase tracking-wider">Hours</div>
                    </div>
                    <div class="font-display text-3xl">:</div>
                    <div>
                        <div class="font-display text-3xl">24</div>
                        <div class="text-xs uppercase tracking-wider">Mins</div>
                    </div>
                    <div class="font-display text-3xl">:</div>
                    <div>
                        <div class="font-display text-3xl">39</div>
                        <div class="text-xs uppercase tracking-wider">Secs</div>
                    </div>
                </div>
                <button class="bg-primary text-secondary border-4 border-primary px-8 py-3 text-sm font-semibold uppercase tracking-wider hover:bg-secondary hover:text-primary transition-all">
                    Shop Now
                </button>
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section id="new" class="py-20 px-6 bg-secondary">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-baseline justify-between mb-12 pb-4 border-b-4 border-primary">
                <h2 class="font-display text-5xl uppercase tracking-tighter">New Arrivals</h2>
                <a href="#" class="text-sm uppercase tracking-wider border-b-2 border-accent hover:text-accent transition-colors">View All →</a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Product 1 -->
                @foreach ( $newArrivals as $newArrival )
                    
                <div class="product-card bg-secondary border-4 border-primary relative badge-corner" style="animation-delay: 0.1s;">
                    <div class="absolute top-3 left-3 bg-accent text-secondary text-xs font-bold px-3 py-1 uppercase tracking-wider z-10">{{ $newArrival->badge }}</div>
                    <div class="aspect-square bg-border overflow-hidden">
                        <img src="data:image/svg+xml,%3Csvg width='400' height='400' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='400' height='400' fill='%23f5f5f0'/%3E%3Crect x='150' y='50' width='100' height='300' fill='%230a0a0a' opacity='0.8'/%3E%3Ctext x='200' y='380' font-size='14' fill='%230066ff' text-anchor='middle' font-family='monospace'%3EOVERSIZED TEE%3C/text%3E%3C/svg%3E" alt="Product" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-accent uppercase tracking-wider font-semibold mb-1">{{ $newArrival->category->name }}</div>
                        <h3 class="font-display text-lg uppercase tracking-tight mb-2">{{ $newArrival->name }}</h3>
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-xl"> Rp {{ number_format($newArrival->price, 0, ',', '.') }}</span>
                            <button class="bg-primary text-secondary border-2 border-primary px-4 py-2 text-xs uppercase tracking-wider hover:bg-accent hover:border-accent transition-all">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                    @endforeach

            </div>
        </div>
    </section>

    <!-- Featured Collections -->
    <section id="collections" class="py-20 px-6 bg-secondary">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-baseline justify-between mb-12 pb-4 border-b-4 border-primary">
                <h2 class="font-display text-5xl uppercase tracking-tighter">Featured Collections</h2>
                <a href="#" class="text-sm uppercase tracking-wider border-b-2 border-accent hover:text-accent transition-colors">View All →</a>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Collection 1 -->
                 @foreach ( $featureds as $featured)
                <div class="hover-lift bg-secondary border-4 border-primary relative overflow-hidden">
                   
                        
                    
                    <div class="h-96 bg-border overflow-hidden">
                        <img src=" " alt="Collection" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-6">
                        <div class="text-xs text-accent uppercase tracking-wider font-semibold mb-2">{{ $featured->product_count }} Products</div>
                        <h3 class="font-display text-2xl uppercase tracking-tight mb-3">{{ $featured->name }}</h3>
                        <p class="text-sm mb-4 font-light leading-relaxed">{{ $featured->description }}</p>
                        <button class="w-full bg-primary text-secondary border-4 border-primary py-3 text-sm font-semibold uppercase tracking-wider hover:bg-accent hover:border-accent transition-all">
                            Shop {{ $featured->name }}
                        </button>
                    </div>
                 
                </div>
                   @endforeach


                <!-- Collection 3 -->
 
            </div>
        </div>
    </section>

    <!-- Shop by Category -->
    <section id="categories" class="py-20 px-6 bg-primary text-secondary">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-baseline justify-between mb-12 pb-4 border-b-4 border-accent">
                <h2 class="font-display text-5xl uppercase tracking-tighter">Shop by Category</h2>
            </div>
            
         
                
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                   @foreach ($categorys as $category)
                <a href="#" class="border-4 border-secondary p-8 text-center hover:bg-accent hover:border-accent transition-all group">
                    <div class="text-6xl mb-4">{{ $category->icon }}</div>
                    <div class="font-display text-xl uppercase tracking-tight group-hover:text-secondary">{{ $category->name }}</div>
                    <div class="text-sm mt-2 opacity-70 group-hover:opacity-100">{{ $category->product_count }} Styles</div>
                </a>
                 @endforeach
            </div>
            

        </div>
    </section>

    <!-- Trending Products (Small Grid) -->
    <section class="py-20 px-6 bg-secondary">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-baseline justify-between mb-12 pb-4 border-b-4 border-primary">
                <h2 class="font-display text-5xl uppercase tracking-tighter">Trending Now</h2>
                <a href="#" class="text-sm uppercase tracking-wider border-b-2 border-accent hover:text-accent transition-colors">View All →</a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($trendings as $trending )
                    
                <!-- Trending Product 1 -->
                <div class="product-card bg-secondary border-4 border-primary">
                    <div class="aspect-square bg-border overflow-hidden">
                        <img src="data:image/svg+xml,%3Csvg width='300' height='300' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='300' height='300' fill='%230a0a0a'/%3E%3Crect x='100' y='80' width='100' height='140' fill='%230066ff' opacity='0.6'/%3E%3Ctext x='150' y='260' font-size='12' fill='%23f5f5f0' text-anchor='middle'%3EZIP HOODIE%3C/text%3E%3C/svg%3E" alt="Trending" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-accent uppercase tracking-wider font-semibold mb-1">{{ $trending->badge }}</div>
                        <h3 class="font-display text-base uppercase tracking-tight mb-2">{{ $trending->name }}</h3>
                        <div class="font-bold text-lg">Rp {{ number_format($trending->price, 0, ',', '.') }}</div>
                        <div class="flex gap-1 mt-2">
                            <span class="text-accent">★★★★★</span>
                            <span class="text-xs opacity-60">(324)</span>
                        </div>
                    </div>
                     
                </div>
                 @endforeach

           
            </div>
        </div>
    </section>

    <!-- Split CTA Banner -->
    <section class="grid md:grid-cols-2">
        <div class="bg-primary text-secondary p-12 lg:p-20 flex flex-col justify-center border-r-4 border-accent">
            <h2 class="font-display text-5xl uppercase tracking-tighter mb-6">Join the Movement</h2>
            <p class="text-lg mb-8 font-light leading-relaxed max-w-md">Get exclusive access to limited drops, early releases, and members-only deals.</p>
            <button class="btn-brutalist bg-accent text-secondary border-4 border-accent px-10 py-4 text-sm font-semibold uppercase tracking-widest self-start">
                Become a Member
            </button>
        </div>
        
        <div class="bg-accent text-secondary p-12 lg:p-20 flex flex-col justify-center">
            <h2 class="font-display text-5xl uppercase tracking-tighter mb-6">Free Shipping</h2>
            <p class="text-lg mb-8 font-light leading-relaxed max-w-md">On all orders over $75. Express delivery available. Easy returns within 30 days.</p>
            <button class="btn-brutalist bg-primary text-secondary border-4 border-primary px-10 py-4 text-sm font-semibold uppercase tracking-widest self-start">
                Shop Now
            </button>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-primary text-secondary py-16 border-y-4 border-accent">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="font-display text-6xl text-accent mb-3">800+</div>
                <div class="text-sm uppercase tracking-wider opacity-80">Fashion Items</div>
            </div>
            <div class="text-center">
                <div class="font-display text-6xl text-accent mb-3">24/7</div>
                <div class="text-sm uppercase tracking-wider opacity-80">Customer Support</div>
            </div>
            <div class="text-center">
                <div class="font-display text-6xl text-accent mb-3">100%</div>
                <div class="text-sm uppercase tracking-wider opacity-80">Authentic Goods</div>
            </div>
            <div class="text-center">
                <div class="font-display text-6xl text-accent mb-3">12K+</div>
                <div class="text-sm uppercase tracking-wider opacity-80">Happy Customers</div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 px-6 bg-secondary">
        <div class="max-w-7xl mx-auto">
            <h2 class="font-display text-5xl uppercase tracking-tighter mb-12 text-center">What People Say</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="border-4 border-primary p-8 hover:shadow-[8px_8px_0_#0a0a0a] transition-all">
                    <div class="flex gap-1 text-accent text-xl mb-4">★★★★★</div>
                    <p class="text-lg mb-6 font-light leading-relaxed">"Finally, streetwear that actually fits my style. Quality is insane."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary rounded-full"></div>
                        <div>
                            <div class="font-bold">Marcus Lee</div>
                            <div class="text-sm opacity-60">Skater</div>
                        </div>
                    </div>
                </div>

                <div class="border-4 border-primary p-8 hover:shadow-[8px_8px_0_#0a0a0a] transition-all">
                    <div class="flex gap-1 text-accent text-xl mb-4">★★★★★</div>
                    <p class="text-lg mb-6 font-light leading-relaxed">"Bold designs that turn heads. Been getting compliments non-stop!"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-accent rounded-full"></div>
                        <div>
                            <div class="font-bold">Rina Santos</div>
                            <div class="text-sm opacity-60">Content Creator</div>
                        </div>
                    </div>
                </div>

                <div class="border-4 border-primary p-8 hover:shadow-[8px_8px_0_#0a0a0a] transition-all">
                    <div class="flex gap-1 text-accent text-xl mb-4">★★★★★</div>
                    <p class="text-lg mb-6 font-light leading-relaxed">"This is what I've been looking for. Raw, honest fashion."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-border rounded-full"></div>
                        <div>
                            <div class="font-bold">Jake Morrison</div>
                            <div class="text-sm opacity-60">DJ & Producer</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-20 px-6 bg-secondary">
        <div class="max-w-3xl mx-auto border-4 border-primary p-12 text-center">
            <h2 class="font-display text-4xl uppercase tracking-tighter mb-4">Stay In The Loop</h2>
            <p class="text-lg mb-8 opacity-80">Get exclusive drops, early access to new collections, and streetwear news.</p>
            
            <form class="flex gap-0 max-w-2xl mx-auto">
                <input type="email" placeholder="YOUR@EMAIL.COM" required class="flex-1 border-4 border-primary border-r-0 px-6 py-4 text-sm font-mono focus:outline-none focus:bg-white">
                <button type="submit" class="bg-primary text-secondary border-4 border-primary px-10 py-4 text-sm font-semibold uppercase tracking-wider hover:bg-accent hover:border-accent transition-all">
                    Subscribe
                </button>
            </form>
            
            <div class="mt-6 text-xs opacity-60">
                No spam. Unsubscribe anytime. Privacy matters.
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-secondary border-t-4 border-accent">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="font-display text-3xl mb-4">VOGUE</div>
                    <p class="text-sm opacity-70 leading-relaxed">Bold fashion for bold people. Streetwear meets contemporary style.</p>
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="w-10 h-10 border-2 border-secondary flex items-center justify-center hover:bg-accent hover:border-accent transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 border-2 border-secondary flex items-center justify-center hover:bg-accent hover:border-accent transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 border-2 border-secondary flex items-center justify-center hover:bg-accent hover:border-accent transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-display text-xl uppercase mb-4 tracking-tight">Shop</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">New Arrivals</a></li>
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Best Sellers</a></li>
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Collections</a></li>
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Sale</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-display text-xl uppercase mb-4 tracking-tight">Support</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Contact Us</a></li>
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Shipping Info</a></li>
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Returns</a></li>
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-display text-xl uppercase mb-4 tracking-tight">Company</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">About Us</a></li>
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Careers</a></li>
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Privacy Policy</a></li>
                        <li><a href="#" class="opacity-70 hover:opacity-100 hover:text-accent transition-all">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t-2 border-secondary pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm opacity-60">
                <div>© 2026 VOGUE. All rights reserved.</div>
                <div class="flex gap-6">
                    <span>🔒 Secure Checkout</span>
                    <span>📦 Fast Shipping</span>
                    <span>↩️ Easy Returns</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Add to cart animation
        document.querySelectorAll('.product-card button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Add animation
                const originalText = this.textContent;
                this.textContent = '✓ Added!';
                this.classList.add('bg-green-600');
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.classList.remove('bg-green-600');
                }, 2000);
                
                // Here you would normally send AJAX request to add to cart
                // Example: fetch('/cart/add', { method: 'POST', body: ... })
            });
        });

        // Newsletter form submission
        const newsletterForms = document.querySelectorAll('form');
        newsletterForms.forEach(form => {
            if (form.querySelector('input[type="email"]')) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Here you would normally send AJAX request
                    // For now, just show success message
                    alert('Thank you for subscribing!');
                    this.reset();
                });
            }
        });

        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe product and collection cards for animations
        document.querySelectorAll('.product-card, .hover-lift').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>