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
            
            <aside class="w-64 bg-gray-950 text-gray-300 flex flex-col flex-shrink-0 border-r border-gray-800 h-full">
                <div class="p-5 text-center font-black border-b border-gray-800 tracking-widest text-indigo-400 text-lg flex-shrink-0">
                    RPL SYSTEM
                </div>
                <nav class="flex-1 p-4 space-y-1 text-sm overflow-y-auto">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="block py-2.5 px-4 rounded-xl transition duration-200 hover:bg-gray-900 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-900/20' : '' }}">
                           Dashboard
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" 
                           class="block py-2.5 px-4 rounded-xl transition duration-200 hover:bg-gray-900 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white font-bold' : '' }}">
                           Dashboard
                        </a>
                    @endif

                    <a href="{{ route('academic-years.index') }}" class="block py-2.5 px-4 rounded-xl transition duration-200 hover:bg-gray-900 hover:text-white {{ request()->routeIs('academic-years.*') ? 'bg-indigo-600 text-white font-bold' : '' }}">
                        Data Tahun
                    </a>
                    <a href="{{ route('program-studies.index') }}" class="block py-2.5 px-4 rounded-xl transition duration-200 hover:bg-gray-900 hover:text-white {{ request()->routeIs('program-studies.*') ? 'bg-indigo-600 text-white font-bold' : '' }}">
                        Data Prodi
                    </a>
                    <a href="{{ route('curricula.index') }}" class="block py-2.5 px-4 rounded-xl transition duration-200 hover:bg-gray-900 hover:text-white {{ request()->routeIs('curricula.*') ? 'bg-indigo-600 text-white font-bold' : '' }}">
                        Data Kurikulum
                    </a>
                    <a href="{{ route('admin.registrations.index') }}" class="block py-2.5 px-4 rounded-xl transition duration-200 hover:bg-gray-900 hover:text-white {{ request()->routeIs('admin.registrations.*') ? 'bg-gray-900 text-white font-bold border-l-4 border-indigo-500 pl-3' : '' }}">
                        Data Pendaftar
                    </a>
                </nav>
            </aside>

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