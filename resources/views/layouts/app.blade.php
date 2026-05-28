<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        
        <div class="flex h-screen overflow-hidden bg-gray-100">
            
            <aside class="w-64 bg-gray-900 h-full text-white flex flex-col flex-shrink-0">
                <div class="p-5 text-center font-bold border-b border-gray-800 tracking-wider text-indigo-400">
                    RPL SYSTEM
                </div>
                <nav class="flex-1 p-4 space-y-2 text-sm overflow-y-auto">
                    <a href="{{ route('dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-800 {{ request()->routeIs('dashboard') ? 'bg-gray-800 font-bold' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.registrations.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-800 {{ request()->routeIs('admin.registrations.*') ? 'bg-gray-800 font-bold' : '' }}">
                        Data Pendaftar
                    </a>
                    <a href="{{ route('academic-years.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-800">
                        Data Tahun
                    </a>
                    <a href="{{ route('curricula.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-800">
                        Data Kurikulum
                    </a>
                    <a href="{{ route('program-studies.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-800">
                        Data Prodi
                    </a>
                </nav>
            </aside>

            <div class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden">
                
                @include('layouts.navigation')

                @if (isset($header))
                    <header class="bg-white shadow-sm border-b border-gray-200">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="p-6 flex-1">
                    {{ $slot }}
                </main>
                
            </div> 
        </div> 
    </body>
</html>