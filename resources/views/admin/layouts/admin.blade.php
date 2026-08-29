<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin CMS - EduLearn Management Portal')</title>
    
    <!-- Google Fonts: Be Vietnam Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&family=Newsreader:ital,opsz,wght@0,6..72,400..700;1,6..72,400..700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="h-full bg-slate-950 text-slate-100 antialiased font-sans flex" x-data="{ sidebarOpen: true }">

    <!-- Admin Sidebar -->
    <aside class="w-64 bg-slate-900 border-r border-slate-800 flex flex-col justify-between flex-shrink-0 min-h-screen transition-all duration-200"
           :class="{'w-64': sidebarOpen, 'w-20': !sidebarOpen}">
        
        <div>
            <!-- Brand Logo -->
            <div class="h-18 px-6 flex items-center justify-between border-b border-slate-800/80">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 overflow-hidden">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-rose-600 to-rose-400 flex items-center justify-center text-white shadow-glow flex-shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div x-show="sidebarOpen" class="flex flex-col">
                        <span class="text-lg font-black font-display tracking-tight text-white leading-none">EduLearn</span>
                        <span class="text-[10px] font-bold text-rose-400 uppercase tracking-wider mt-0.5">Admin CMS</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 text-xs font-bold">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-3.5 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-rose-600 text-white shadow-glow' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Tổng Quan (Dashboard)</span>
                </a>

                <!-- IELTS Exam Management -->
                <a href="{{ route('admin.tests.index') }}" 
                   class="flex items-center space-x-3 px-3.5 py-3 rounded-xl transition {{ request()->routeIs('admin.tests.*') ? 'bg-rose-600 text-white shadow-glow' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i data-lucide="book-open-check" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Quản Lý Đề Thi IELTS</span>
                </a>

                <!-- Dictation Studio -->
                <a href="{{ route('admin.dictation.index') }}" 
                   class="flex items-center space-x-3 px-3.5 py-3 rounded-xl transition {{ request()->routeIs('admin.dictation.*') ? 'bg-rose-600 text-white shadow-glow' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i data-lucide="headphones" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Nghe Chép Chính Tả</span>
                </a>

                <!-- Writing & Speaking Samples -->
                <a href="{{ route('admin.samples.index') }}" 
                   class="flex items-center space-x-3 px-3.5 py-3 rounded-xl transition {{ request()->routeIs('admin.samples.*') ? 'bg-rose-600 text-white shadow-glow' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i data-lucide="file-text" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Kho Bài Mẫu Band 8.0+</span>
                </a>

                <!-- Vocabulary Repository -->
                <a href="{{ route('admin.vocabulary.index') }}" 
                   class="flex items-center space-x-3 px-3.5 py-3 rounded-xl transition {{ request()->routeIs('admin.vocabulary.*') ? 'bg-rose-600 text-white shadow-glow' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i data-lucide="layers" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Từ Điển & Flashcard</span>
                </a>

                <!-- Student Management -->
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center space-x-3 px-3.5 py-3 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-rose-600 text-white shadow-glow' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Học Viên & Bài Nộp</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom: Back to Web -->
        <div class="p-4 border-t border-slate-800/80 space-y-2">
            <a href="{{ route('home') }}" class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-slate-800/80 hover:bg-slate-800 text-slate-300 text-xs font-bold transition">
                <i data-lucide="globe" class="w-4 h-4 text-emerald-400"></i>
                <span x-show="sidebarOpen">Về Trang Học Viên</span>
            </a>
        </div>
    </aside>

    <!-- Main Admin Workspace -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        <!-- Topbar -->
        <header class="h-18 bg-slate-900/90 backdrop-blur-md border-b border-slate-800 px-6 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl bg-slate-800 text-slate-400 hover:text-white transition">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="text-xs font-bold text-slate-400 flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span class="text-slate-200">Hệ Thống Đang Hoạt Động Bình Thường</span>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <span class="px-3 py-1 bg-rose-500/20 text-rose-300 border border-rose-500/30 rounded-full text-xs font-bold">
                    Super Admin
                </span>
                <div class="flex items-center space-x-2">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80" alt="Admin" class="w-9 h-9 rounded-xl object-cover ring-2 ring-rose-500/30">
                    <span class="text-xs font-bold text-white hidden sm:block">Admin EduLearn</span>
                </div>
            </div>
        </header>

        <!-- Flash Notification Alert -->
        @if(session('success'))
        <div class="mx-6 mt-6 p-4 rounded-2xl bg-emerald-950/80 border border-emerald-500/50 text-emerald-300 text-xs font-bold flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Main Page Content -->
        <main class="flex-1 p-6 sm:p-8 bg-slate-950">
            @yield('content')
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
