<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900 text-slate-100 selection:bg-teal-500 selection:text-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NomadThread Admin Console')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="admin-body flex h-full overflow-hidden bg-slate-950">

    <!-- Sidebar Navigation -->
    <aside class="w-64 sidebar-glass flex flex-col justify-between shrink-0">
        <div>
            <!-- Header/Logo -->
            <div class="h-16 flex items-center px-6 border-b border-slate-800/80 border-b-espresso">
                <a href="{{ route('backend.dashboard') }}" id="sidebar-logo" class="flex items-center gap-2 text-decoration-none">
                    <div class="h-9 w-9 rounded-lg bg-gradient-to-br from-[#c9a84c] to-[#a88734] flex items-center justify-center text-[#251710] font-bold">
                        NT
                    </div>
                    <div>
                        <div class="text-[#f7f4eb] font-bold text-base leading-tight tracking-wide">NomadThread</div>
                        <div class="text-[#a89284] text-[9px] uppercase tracking-widest leading-none">Admin Panel</div>
                    </div>
                </a>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4 space-y-1.5">
                <a href="{{ route('backend.dashboard') }}" id="admin-nav-dashboard" class="nav-item-backend flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ Route::is('backend.dashboard') ? 'active' : '' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                    </svg>
                    Dashboard Stats
                </a>
                
                <a href="{{ route('backend.users.index') }}" id="admin-nav-users" class="nav-item-backend flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ Route::is('backend.users.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 18H8.25c-.621 0-1.125-.504-1.125-1.125V18m0-1.875c0-1.29.339-2.5.935-3.557M6.078 18H5.25A2.25 2.25 0 0 1 3 15.75V12c0-.1.002-.199.006-.298m0 0A2.25 2.25 0 0 1 5.25 9.75h.3m-3.3 1.952A2.252 2.252 0 0 1 3 9.75M6.078 18c-.007-.088-.012-.177-.012-.266V18Zm0 0c.007-.156.026-.312.057-.465m0 0a4.502 4.502 0 0 1 2.227-3.197m0 0c-.822-.619-1.355-1.614-1.355-2.733 0-1.88 1.503-3.418 3.375-3.418s3.375 1.538 3.375 3.418c0 1.12-.533 2.114-1.355 2.733a4.502 4.502 0 0 1 2.227 3.197M18.75 7.5a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm-6 3a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 7.5a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    User Management
                </a>

                <a href="{{ route('backend.threads.index') }}" id="admin-nav-threads" class="nav-item-backend flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ Route::is('backend.threads.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9s.005 0 0 0m-9 3h9m-9 3h9m-9 3h9m-9 3H12a2.25 2.25 0 0 0 2.25-2.25V7.5A2.25 2.25 0 0 0 12 5.25H5.25A2.25 2.25 0 0 0 3 7.5v11.25A2.25 2.25 0 0 0 5.25 21ZM16.5 7.5V6a2.25 2.25 0 0 1 2.25-2.25H21A2.25 2.25 0 0 1 23.25 6v11.25A2.25 2.25 0 0 1 21 19.5h-1.5" />
                    </svg>
                    Thread Moderation
                </a>
            </nav>
        </div>

        <!-- Back to Website -->
        <div class="p-4 border-t border-slate-800/80" style="border-top-color: #362319;">
            <a href="{{ route('home') }}" id="admin-nav-exit" class="flex w-full items-center justify-center gap-2 rounded-lg py-2 text-xs font-semibold transition-all duration-300 admin-nav-exit-btn">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                </svg>
                Exit Console
            </a>
        </div>
    </aside>

    <!-- Main Admin Workspace -->
    <div class="flex-grow flex flex-col overflow-hidden">
        
        <!-- Top bar -->
        <header class="h-16 backend-header flex items-center justify-between px-8 shrink-0">
            <div>
                <h1 class="text-lg font-semibold tracking-wide text-[#f7f4eb]">
                    @yield('admin_section_title', 'System Administration')
                </h1>
            </div>
            
            <!-- User Status Info & Logout -->
            @if(Auth::check())
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <div class="text-xs font-semibold text-[#f7f4eb]">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-[#c9a84c] font-medium">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'User' }}</div>
                    </div>
                    <div class="h-9 w-9 rounded-full bg-gradient-to-br from-[#c9a84c] to-[#a88734] flex items-center justify-center text-sm font-bold text-[#251710] border border-transparent shadow-inner">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>
                
                <form action="{{ route('backend.logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold transition-all duration-300 backend-logout-btn" title="Logout">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
            @endif
        </header>

        <!-- Flash messages / Notifications -->
        @if(session('success'))
            <div class="mx-8 mt-6 rounded-lg bg-teal-900/30 border border-teal-500/30 p-4 text-sm text-teal-300 animate-pulse" id="flash-success">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Dynamic Content -->
        <main class="flex-grow overflow-y-auto p-8 bg-slate-950">
            @yield('content')
        </main>
    </div>
</body>
</html>
