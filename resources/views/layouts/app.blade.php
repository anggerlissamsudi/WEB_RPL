<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistem Informasi RPL - STIE Mahardhika') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        
        <div class="flex h-screen w-screen overflow-hidden">
            
            <!-- SIDEBAR  -->
            <aside class="w-64 bg-gray-950 text-gray-400 flex flex-col flex-shrink-0 border-r border-gray-900 h-full">
                <!-- BRAND LOGO -->
                <div class="p-5 text-center font-black border-b border-gray-900 tracking-widest text-indigo-400 text-lg flex-shrink-0 uppercase">
                    RPL SYSTEM
                </div>
                
                <!-- MENU ITEM NAVIGASI DENGAN IKON -->
                <nav class="flex-1 p-4 space-y-2 text-sm overflow-y-auto">
                    
                    <!-- DASHBOARD (ADMIN ATAU MAHASISWA) -->
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600/10 text-indigo-400 font-bold border-l-4 border-indigo-500 pl-3' : 'hover:bg-gray-900 hover:text-white' }}">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-indigo-600/10 text-indigo-400 font-bold border-l-4 border-indigo-500 pl-3' : 'hover:bg-gray-900 hover:text-white' }}">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    @endif

                    <!-- DATA TAHUN -->
                    <a href="{{ route('academic-years.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('academic-years.*') ? 'bg-indigo-600/10 text-indigo-400 font-bold border-l-4 border-indigo-500 pl-3' : 'hover:bg-gray-900 hover:text-white' }}">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Data Tahun</span>
                    </a>

                    <!-- DATA PRODI -->
                    <a href="{{ route('program-studies.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('program-studies.*') ? 'bg-indigo-600/10 text-indigo-400 font-bold border-l-4 border-indigo-500 pl-3' : 'hover:bg-gray-900 hover:text-white' }}">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Data Prodi</span>
                    </a>

                    <!-- DATA KURIKULUM -->
                    <a href="{{ route('curricula.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('curricula.*') ? 'bg-indigo-600/10 text-indigo-400 font-bold border-l-4 border-indigo-500 pl-3' : 'hover:bg-gray-900 hover:text-white' }}">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Data Kurikulum</span>
                    </a>

                    <!-- DATA PENDAFTAR -->
                    <a href="{{ route('admin.registrations.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.registrations.*') ? 'bg-indigo-600/10 text-indigo-400 font-bold border-l-4 border-indigo-500 pl-3' : 'hover:bg-gray-900 hover:text-white' }}">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Data Pendaftar</span>
                    </a>
                </nav>
            </aside>

            <!-- KONTEN UTAMA -->
            <div class="flex-1 flex flex-col h-full overflow-hidden">
                
                <div class="flex-shrink-0">
                    @include('layouts.navigation')
                </div>

                @if (isset($header))
                    <header class="bg-white shadow-sm border-b border-gray-100 flex-shrink-0">
                        <div class="max-w-7xl mx-auto py-4 px-6">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="flex-1 overflow-y-auto overflow-x-hidden p-6">
                    <div class="max-w-7xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>
                
            </div> 
        </div> 
    </body>
</html>