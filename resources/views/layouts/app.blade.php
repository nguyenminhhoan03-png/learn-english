<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Primary Meta Tags & SEO Optimization -->
    <title>@yield('title', 'EduLearn - Luyện Thi IELTS & Tự Học Tiếng Anh Chuẩn DOL Linearthinking')</title>
    <meta name="title" content="@yield('title', 'EduLearn - Luyện Thi IELTS & Tự Học Tiếng Anh Chuẩn DOL Linearthinking')">
    <meta name="description" content="@yield('meta_description', 'Nền tảng tự học tiếng Anh thông minh ứng dụng phương pháp Linearthinking độc quyền DOL English. Luyện thi IELTS Cambridge 10-19, thi thử 4 kỹ năng, AI chấm Writing 4 tiêu chí, Nghe chép chính tả Dictation và Flashcard SM-2.')">
    <meta name="keywords" content="@yield('meta_keywords', 'luyện thi ielts, tự học ielts, dol english, linearthinking, cambridge ielts 19, ielts reading, ielts listening, ielts writing task 2, ai cham bai writing, nghe chep chinh ta, dictation, hoc tu vung flashcard sm-2, hoc tieng anh online')">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="author" content="EduLearn English">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon & Brand Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

    <!-- Open Graph / Facebook / Zalo -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'EduLearn - Luyện Thi IELTS Chuẩn DOL Linearthinking')">
    <meta property="og:description" content="@yield('meta_description', 'Luyện thi IELTS thông minh, tối ưu 50% thời gian làm bài với phương pháp Linearthinking độc quyền.')">
    <meta property="og:image" content="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=1200&q=80">
    <meta property="og:locale" content="vi_VN">
    <meta property="og:site_name" content="EduLearn English">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'EduLearn - Luyện Thi IELTS Chuẩn DOL Linearthinking')">
    <meta name="twitter:description" content="@yield('meta_description', 'Luyện thi IELTS thông minh, tối ưu 50% thời gian làm bài với phương pháp Linearthinking độc quyền.')">
    <meta name="twitter:image" content="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=1200&q=80">

    <!-- Schema.org JSON-LD Structured Data for Google Search Ranking -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "EducationalOrganization",
          "@id": "{{ url('/') }}/#organization",
          "name": "EduLearn English - Linearthinking Platform",
          "url": "{{ url('/') }}",
          "logo": "https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=200&q=80",
          "description": "Nền tảng tự học và luyện thi IELTS trực tuyến ứng dụng công nghệ AI và phương pháp tư duy Linearthinking.",
          "sameAs": [
            "https://facebook.com",
            "https://youtube.com"
          ]
        },
        {
          "@type": "WebSite",
          "@id": "{{ url('/') }}/#website",
          "url": "{{ url('/') }}",
          "name": "EduLearn English",
          "publisher": {
            "@id": "{{ url('/') }}/#organization"
          },
          "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('/luyen-thi-ielts') }}?search={search_term_string}",
            "query-input": "required name=search_term_string"
          }
        },
        {
          "@type": "Course",
          "name": "Luyện Thi IELTS Online Chuẩn Phương Pháp Linearthinking",
          "description": "Trọn bộ đề thi Cambridge IELTS 10-19 có phân tích cấu trúc nòng cốt S-V-O, AI chấm Writing 4 tiêu chí và luyện Dictation.",
          "provider": {
            "@id": "{{ url('/') }}/#organization"
          }
        }
      ]
    }
    </script>
    
    <!-- Resource Preconnects for Ultra Fast First Contentful Paint -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com">
    <link rel="dns-prefetch" href="https://images.unsplash.com">
    
    <!-- Google Fonts: Asynchronous Non-blocking Loading -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;700;800;900&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;700;800;900&display=swap">
    </noscript>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="h-full bg-slate-50 text-slate-800 antialiased flex flex-col selection:bg-rose-500 selection:text-white" 
      x-data="globalApp({
          streak: {{ $currentUser?->streak_count ?? 7 }},
          xp: {{ $currentUser?->xp_points ?? 820 }},
          name: '{{ $currentUser?->name ?? 'Nguyễn Minh Anh' }}',
          email: '{{ $currentUser?->email ?? 'student@edulearn.vn' }}',
          targetBand: '{{ $currentUser?->target_band ?? '7.5' }}',
          role: '{{ $currentUser?->role ?? 'user' }}'
      })">

    <!-- Modern Multi-Level Sticky Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-xl border-b border-slate-200 shadow-xs" x-data="{ activeDropdown: null }">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-18">
                
                <!-- Left: Brand Logo -->
                <div class="flex items-center space-x-6 lg:space-x-8 flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2.5 group whitespace-nowrap">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-rose-600 via-rose-500 to-rose-400 flex items-center justify-center text-white shadow-glow transform group-hover:scale-105 transition duration-200 flex-shrink-0">
                            <i data-lucide="zap" class="w-5 h-5 fill-current"></i>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center space-x-1.5">
                                <span class="text-xl font-black font-display tracking-tight text-slate-900 leading-none">EduLearn</span>
                                <span class="px-1.5 py-0.5 text-[9px] font-extrabold uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-200/80 rounded-md">DOL</span>
                            </div>
                            <span class="text-[9px] font-bold text-slate-400 tracking-wider uppercase hidden sm:block mt-0.5">Linearthinking Method</span>
                        </div>
                    </a>

                    <!-- Desktop Multi-Level Navigation -->
                    <nav class="hidden lg:flex items-center space-x-1">
                        
                        <!-- Link 0: Lộ Trình Học -->
                        <a href="{{ route('roadmaps.index') }}" class="flex items-center space-x-1 px-3 py-2 text-xs xl:text-sm font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('roadmaps.*') ? 'text-rose-700 bg-rose-50' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <i data-lucide="compass" class="w-4 h-4 text-rose-600" aria-hidden="true"></i>
                            <span>Lộ Trình Học</span>
                        </a>

                        <!-- Dropdown 1: Luyện Đề & Thi Thử (IELTS • TOEIC) -->
                        <div class="relative" @mouseenter="activeDropdown = 'ielts'" @mouseleave="activeDropdown = null">
                            <button class="flex items-center space-x-1 px-3 py-2 text-xs xl:text-sm font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('ielts.*') ? 'text-rose-600 bg-rose-50' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100/80' }}">
                                <i data-lucide="book-open" class="w-4 h-4 text-rose-500"></i>
                                <span>Luyện Đề & Thi Thử</span>
                                <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-150" :class="{'rotate-180 text-rose-600': activeDropdown === 'ielts'}"></i>
                            </button>

                            <!-- Submenu Panel 1 -->
                            <div x-show="activeDropdown === 'ielts'" 
                                 x-cloak 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-1"
                                 class="absolute top-full left-0 w-84 bg-white rounded-2xl shadow-dropdown border border-slate-200/90 p-2.5 space-y-1 z-50">
                                
                                <a href="{{ route('ielts.index', ['category' => 'ielts-academic']) }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-rose-50/70 group transition">
                                    <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-600 group-hover:text-white transition">
                                        <i data-lucide="library" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-rose-600 transition">IELTS Academic (Cam 10 - 19)</p>
                                        <p class="text-[11px] text-slate-400 font-medium">40+ đề thi Academic có giải thích Linearthinking</p>
                                    </div>
                                </a>

                                <a href="{{ route('ielts.index', ['category' => 'toeic-reading-listening']) }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-indigo-50/70 group transition">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition">
                                        <i data-lucide="award" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-indigo-600 transition">TOEIC ETS 2024 (Reading & Listening)</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Bẫy ngữ pháp Part 5 trong 15s & Đọc hiểu Part 7</p>
                                    </div>
                                </a>

                                <a href="{{ route('ielts.index', ['category' => 'ielts-general-training']) }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-emerald-50/70 group transition">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition">
                                        <i data-lucide="file-text" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-emerald-600 transition">IELTS General Training (Định Cư)</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Văn bản công sở, thông báo và đời sống thực tế</p>
                                    </div>
                                </a>

                                <a href="{{ route('ielts.index', ['category' => 'ielts-recent-actual-tests']) }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-amber-50/70 group transition">
                                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition">
                                        <i data-lucide="zap" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-amber-600 transition">IELTS Forecast Actual Tests 2025</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Bộ đề dự đoán đề thi thật quý 1 & 2 năm 2025</p>
                                    </div>
                                </a>

                                <a href="{{ route('ielts.take', ['slug' => 'cambridge-19-test-1-reading', 'mode' => 'full_test']) }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-slate-100 group transition border-t border-slate-100 pt-2 mt-1">
                                    <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="timer" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-rose-600 transition">Vào Phòng Thi Thử Full Test</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Bấm giờ nghiêm ngặt, tự động tính Band 9.0</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Dropdown 2: Kỹ Năng & Tự Học -->
                        <div class="relative" @mouseenter="activeDropdown = 'skills'" @mouseleave="activeDropdown = null">
                            <button class="flex items-center space-x-1 px-3 py-2 text-xs xl:text-sm font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('dictation.*') || request()->routeIs('samples.*') ? 'text-rose-600 bg-rose-50' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100/80' }}">
                                <i data-lucide="sparkles" class="w-4 h-4 text-indigo-500"></i>
                                <span>Kỹ Năng & Tự Học</span>
                                <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-150" :class="{'rotate-180 text-rose-600': activeDropdown === 'skills'}"></i>
                            </button>

                            <!-- Submenu Panel 2 -->
                            <div x-show="activeDropdown === 'skills'" 
                                 x-cloak 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-1"
                                 class="absolute top-full left-0 w-80 bg-white rounded-2xl shadow-dropdown border border-slate-200/90 p-2.5 space-y-1 z-50">
                                
                                <a href="{{ route('dictation.index') }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-indigo-50/70 group transition">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition">
                                        <i data-lucide="headphones" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-indigo-600 transition">Nghe Chép Chính Tả (Dictation)</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Luyện tai bắt âm, sửa bẫy nuốt & nối âm</p>
                                    </div>
                                </a>

                                <a href="{{ route('samples.writing.index') }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-rose-50/70 group transition">
                                    <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-600 group-hover:text-white transition">
                                        <i data-lucide="file-check-2" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-rose-600 transition">Kho Bài Mẫu Writing Band 8.0+</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Dàn bài logic nòng cốt Linearthinking</p>
                                    </div>
                                </a>

                                <a href="{{ route('samples.speaking.index') }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-amber-50/70 group transition">
                                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition">
                                        <i data-lucide="mic" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-amber-600 transition">Kho Bài Mẫu Speaking Part 1-2-3</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Phát âm IPA và từ vựng mở rộng theo chủ đề</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Dropdown 3: AI & Từ Vựng -->
                        <div class="relative" @mouseenter="activeDropdown = 'ai_tools'" @mouseleave="activeDropdown = null">
                            <button class="flex items-center space-x-1 px-3 py-2 text-xs xl:text-sm font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('flashcards.*') || request()->routeIs('ai.*') ? 'text-rose-600 bg-rose-50' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100/80' }}">
                                <i data-lucide="layers" class="w-4 h-4 text-amber-500"></i>
                                <span>Công Cụ & AI</span>
                                <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform duration-150" :class="{'rotate-180 text-rose-600': activeDropdown === 'ai_tools'}"></i>
                            </button>

                            <!-- Submenu Panel 3 -->
                            <div x-show="activeDropdown === 'ai_tools'" 
                                 x-cloak 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-1"
                                 class="absolute top-full left-0 w-80 bg-white rounded-2xl shadow-dropdown border border-slate-200/90 p-2.5 space-y-1 z-50">
                                
                                <a href="{{ route('ai.writing.index') }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-purple-50/70 group transition">
                                    <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-600 group-hover:text-white transition">
                                        <i data-lucide="wand-2" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-purple-600 transition">AI Chấm Bài Writing 4 Tiêu Chí</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Chấm TR, CC, LR, GRA và sửa lỗi chi tiết</p>
                                    </div>
                                </a>

                                <a href="{{ route('flashcards.index') }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-amber-50/70 group transition">
                                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition">
                                        <i data-lucide="layers" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-amber-600 transition">Sổ Từ Vựng Flashcard SM-2</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Thuật toán lặp lại ngắt quãng Spaced Repetition</p>
                                    </div>
                                </a>

                                <a href="{{ route('tools.converter') }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-emerald-50/70 group transition">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition">
                                        <i data-lucide="award" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-emerald-600 transition">Bảng Quy Đổi Điểm IELTS / TOEIC</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Quy đổi Raw score sang Band 9.0, TOEIC 990 & CEFR</p>
                                    </div>
                                </a>

                                <a href="{{ route('tools.ipa') }}" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-rose-50/70 group transition">
                                    <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-600 group-hover:text-white transition">
                                        <i data-lucide="mic" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-rose-600 transition">Bảng 44 Âm IPA Tương Tác</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Luyện phát âm chuẩn nguyên âm, phụ âm Oxford</p>
                                    </div>
                                </a>

                                <button @click="openQuickDictionary(); activeDropdown = null;" class="w-full flex items-start space-x-3 p-2.5 rounded-xl hover:bg-slate-100 group transition text-left">
                                    <div class="w-8 h-8 rounded-lg bg-slate-200 text-slate-700 flex items-center justify-center flex-shrink-0 group-hover:bg-slate-900 group-hover:text-white transition">
                                        <i data-lucide="search" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 group-hover:text-slate-900 transition">Tra Cứu Từ Điển 1-Chạm</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Tra nhanh nghĩa, IPA và nghe audio US/UK</p>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <!-- Single Link: Dashboard -->
                        <a href="{{ route('dashboard') }}" 
                           class="px-3 py-2 text-xs xl:text-sm font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('dashboard') ? 'text-rose-600 bg-rose-50' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <span>Dashboard & Radar</span>
                        </a>
                    </nav>
                </div>

                <!-- Right: Quick Tools, Gamification & Profile (Auth / Guest States) -->
                <div class="flex items-center space-x-2 sm:space-x-3 flex-shrink-0">
                    
                    <!-- Quick Dictionary Button -->
                    <button @click="openQuickDictionary()" 
                            aria-label="Tra cứu từ điển nhanh"
                            class="hidden md:inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition whitespace-nowrap flex-shrink-0">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-slate-600"></i>
                        <span>Tra từ</span>
                    </button>

                    @auth
                    <!-- Interactive Streak Widget -->
                    <button @click="showStreakModal = true" 
                            aria-label="Xem chi tiết chuỗi ngày học Streak {{ $currentUser->streak_count ?? 7 }} ngày"
                            class="flex items-center space-x-1.5 px-2.5 sm:px-3 py-1.5 rounded-xl bg-amber-100 border border-amber-300 text-amber-950 font-extrabold text-xs shadow-2xs hover:bg-amber-200 transition whitespace-nowrap flex-shrink-0 cursor-pointer" 
                            title="Nhấp để xem chi tiết chuỗi ngày học">
                        <span class="text-sm animate-pulse leading-none" aria-hidden="true">🔥</span>
                        <span x-text="`${streak}d`">{{ $currentUser->streak_count ?? 7 }}d</span>
                    </button>

                    <!-- Interactive XP Widget -->
                    <button @click="showXpModal = true"
                            aria-label="Xem cấp bậc và điểm thưởng {{ $currentUser->xp_points ?? 820 }} XP"
                            class="flex items-center space-x-1 px-2.5 sm:px-3 py-1.5 rounded-xl bg-indigo-100 border border-indigo-300 text-indigo-950 font-extrabold text-xs shadow-2xs hover:bg-indigo-200 transition whitespace-nowrap flex-shrink-0 cursor-pointer"
                            title="Nhấp để xem cấp bậc và điểm thưởng">
                        <i data-lucide="award" class="w-3.5 h-3.5 text-indigo-700" aria-hidden="true"></i>
                        <span x-text="`${xp} XP`">{{ $currentUser->xp_points ?? 820 }} XP</span>
                    </button>

                    <!-- User Profile Dropdown -->
                    <div class="relative flex-shrink-0" x-data="{ openProfile: false }" @click.outside="openProfile = false">
                        <button @click="openProfile = !openProfile" 
                                aria-label="Mở menu tài khoản cá nhân"
                                aria-expanded="openProfile"
                                class="flex items-center space-x-1.5 p-1 rounded-2xl hover:bg-slate-100 transition focus:outline-none ring-2 ring-transparent focus:ring-rose-500/30">
                            <div class="relative">
                                <img src="{{ $currentUser->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80' }}" 
                                     alt="Ảnh đại diện của {{ $currentUser->name }}" 
                                     width="36" 
                                     height="36" 
                                     class="w-9 h-9 rounded-xl object-cover ring-2 ring-rose-500/20 shadow-2xs">
                                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full" aria-hidden="true"></span>
                            </div>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-600 hidden sm:block transition-transform duration-150" :class="{'rotate-180 text-rose-600': openProfile}" aria-hidden="true"></i>
                        </button>

                        <!-- Profile Dropdown Menu Card -->
                        <div x-show="openProfile" 
                             x-cloak 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                             class="absolute right-0 mt-2 w-72 bg-white rounded-3xl shadow-2xl border border-slate-200/90 py-2.5 z-50 animate-pop overflow-hidden">
                            
                            <!-- User Header Card -->
                            <div class="px-4 py-3 bg-gradient-to-r from-slate-50 to-rose-50/40 border-b border-slate-100 flex items-center space-x-3">
                                <img src="{{ $currentUser->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80' }}" 
                                     alt="{{ $currentUser->name }}"
                                     width="40"
                                     height="40"
                                     class="w-10 h-10 rounded-2xl object-cover ring-2 ring-rose-500/30 flex-shrink-0">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center space-x-1.5">
                                        <p class="text-xs font-black text-slate-900 truncate">{{ $currentUser->name }}</p>
                                        @if($currentUser->isAdmin())
                                        <span class="px-1.5 py-0.2 rounded bg-amber-500/20 text-amber-800 text-[9px] font-black uppercase flex-shrink-0">👑 Admin</span>
                                        @endif
                                    </div>
                                    <p class="text-[11px] text-slate-600 font-mono truncate">{{ $currentUser->email }}</p>
                                    <span class="inline-block mt-0.5 text-[10px] font-extrabold text-rose-700">Target: Band {{ $currentUser->target_band ?? '7.5' }}</span>
                                </div>
                            </div>

                            <!-- Quick Stats Row -->
                            <div class="grid grid-cols-3 gap-1 px-3 py-2 border-b border-slate-100 text-center text-xs">
                                <div class="p-1.5 rounded-xl bg-amber-100/70">
                                    <span class="block text-[10px] font-bold text-slate-600">Streak</span>
                                    <span class="font-black text-amber-900">🔥 {{ $currentUser->streak_count }}d</span>
                                </div>
                                <div class="p-1.5 rounded-xl bg-indigo-100/70">
                                    <span class="block text-[10px] font-bold text-slate-600">XP</span>
                                    <span class="font-black text-indigo-900">⚡ {{ $currentUser->xp_points }}</span>
                                </div>
                                <div class="p-1.5 rounded-xl bg-rose-100/70">
                                    <span class="block text-[10px] font-bold text-slate-600">Mục Tiêu</span>
                                    <span class="font-black text-rose-900">🎯 {{ $currentUser->target_band }}</span>
                                </div>
                            </div>
                            
                            <!-- Main Links List -->
                            <div class="p-2 space-y-1 text-xs font-bold text-slate-800">
                                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2.5 px-3 py-2 rounded-xl hover:bg-slate-100/80 hover:text-rose-700 transition">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-slate-600" aria-hidden="true"></i>
                                    <span>Bảng điều khiển & Radar</span>
                                </a>
                                <a href="{{ route('flashcards.index') }}" class="flex items-center space-x-2.5 px-3 py-2 rounded-xl hover:bg-slate-100/80 hover:text-rose-700 transition">
                                    <i data-lucide="bookmark" class="w-4 h-4 text-slate-600" aria-hidden="true"></i>
                                    <span>Sổ từ vựng cá nhân</span>
                                </a>

                                @if($currentUser->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-rose-700 text-white font-extrabold shadow-glow hover:opacity-95 transition">
                                    <i data-lucide="shield-check" class="w-4 h-4" aria-hidden="true"></i>
                                    <span>Trung Tâm Quản Trị Admin CMS →</span>
                                </a>
                                @endif
                            </div>

                            <!-- Footer Actions -->
                            <div class="mt-1 pt-2 px-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold">
                                <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-700 transition">Đổi tài khoản</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" aria-label="Đăng xuất khỏi tài khoản" class="text-rose-700 hover:text-rose-800 flex items-center space-x-1 transition font-bold">
                                        <i data-lucide="log-out" class="w-3.5 h-3.5" aria-hidden="true"></i>
                                        <span>Đăng Xuất</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Guest Action Buttons (Desktop & Tablet) -->
                    <div class="hidden sm:flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-800 hover:text-rose-700 hover:bg-slate-100 transition">
                            Đăng Nhập
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-gradient-to-r from-rose-700 to-rose-600 text-white text-xs font-extrabold shadow-glow hover:opacity-95 transition">
                            Đăng Ký Miễn Phí
                        </a>
                    </div>
                    <!-- Compact Mobile Login Button -->
                    <a href="{{ route('login') }}" class="sm:hidden px-2.5 py-1.5 rounded-xl text-xs font-bold text-slate-800 hover:bg-slate-100 border border-slate-200">
                        Đăng Nhập
                    </a>
                    @endauth

                    <!-- Mobile Hamburger Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            aria-label="Mở hoặc đóng menu điều hướng trên thiết bị di động"
                            aria-expanded="mobileMenuOpen"
                            class="lg:hidden p-2 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-slate-100 focus:outline-none transition flex-shrink-0">
                        <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen" aria-hidden="true"></i>
                        <i data-lucide="x" class="w-6 h-6" x-show="mobileMenuOpen" style="display: none;" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Multi-Level Accordion Menu -->
        <div x-show="mobileMenuOpen" 
             x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-3 shadow-xl max-h-[85vh] overflow-y-auto"
             x-data="{ openSub: null }">

            @guest
            <div class="grid grid-cols-2 gap-2 p-2 bg-slate-50 rounded-2xl border border-slate-100">
                <a href="{{ route('login') }}" class="py-2.5 text-center text-xs font-bold rounded-xl bg-white border border-slate-200 text-slate-800">
                    Đăng Nhập
                </a>
                <a href="{{ route('register') }}" class="py-2.5 text-center text-xs font-bold rounded-xl bg-rose-600 text-white shadow-glow">
                    Đăng Ký
                </a>
            </div>
            @endguest
            
            <div class="border-b border-slate-100 pb-2">
                <a href="{{ route('roadmaps.index') }}" class="w-full flex items-center space-x-2.5 px-3 py-2.5 rounded-xl text-sm font-bold text-slate-800 hover:bg-slate-50 hover:text-rose-600">
                    <i data-lucide="compass" class="w-4 h-4 text-rose-600"></i>
                    <span>Lộ Trình Học Cá Nhân Hóa</span>
                </a>
            </div>

            <div class="border-b border-slate-100 pb-2">
                <button @click="openSub = (openSub === 'ielts' ? null : 'ielts')" 
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-bold text-slate-800 hover:bg-slate-50">
                    <div class="flex items-center space-x-2.5">
                        <i data-lucide="book-open" class="w-4 h-4 text-rose-600"></i>
                        <span>Luyện Đề & Thi Thử</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition transform" :class="{'rotate-180 text-rose-600': openSub === 'ielts'}"></i>
                </button>
                <div x-show="openSub === 'ielts'" x-cloak class="pl-7 pr-2 py-1 space-y-1 text-xs font-semibold">
                    <a href="{{ route('ielts.index', ['category' => 'ielts-academic']) }}" class="block py-2 text-slate-600 hover:text-rose-600">IELTS Academic (Cam 10 - 19)</a>
                    <a href="{{ route('ielts.index', ['category' => 'toeic-reading-listening']) }}" class="block py-2 text-slate-600 hover:text-rose-600">TOEIC ETS 2024 (Reading & Listening)</a>
                    <a href="{{ route('ielts.index', ['category' => 'ielts-general-training']) }}" class="block py-2 text-slate-600 hover:text-rose-600">IELTS General Training (Định Cư)</a>
                    <a href="{{ route('ielts.index', ['category' => 'ielts-recent-actual-tests']) }}" class="block py-2 text-slate-600 hover:text-rose-600">IELTS Forecast Actual Tests 2025</a>
                    <a href="{{ route('ielts.take', ['slug' => 'cambridge-19-test-1-reading', 'mode' => 'full_test']) }}" class="block py-2 text-rose-600 font-bold">Vào Phòng Thi Thử Full Test 60p →</a>
                </div>
            </div>

            <div class="border-b border-slate-100 pb-2">
                <button @click="openSub = (openSub === 'skills' ? null : 'skills')" 
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-bold text-slate-800 hover:bg-slate-50">
                    <div class="flex items-center space-x-2.5">
                        <i data-lucide="sparkles" class="w-4 h-4 text-indigo-600"></i>
                        <span>Kỹ Năng & Tự Học</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition transform" :class="{'rotate-180 text-rose-600': openSub === 'skills'}"></i>
                </button>
                <div x-show="openSub === 'skills'" x-cloak class="pl-7 pr-2 py-1 space-y-1 text-xs font-semibold">
                    <a href="{{ route('dictation.index') }}" class="block py-2 text-slate-600 hover:text-rose-600">Nghe Chép Chính Tả (Dictation)</a>
                    <a href="{{ route('samples.writing.index') }}" class="block py-2 text-slate-600 hover:text-rose-600">Kho Bài Mẫu Writing Band 8.0+</a>
                    <a href="{{ route('samples.speaking.index') }}" class="block py-2 text-slate-600 hover:text-rose-600">Kho Bài Mẫu Speaking Part 1-2-3</a>
                </div>
            </div>

            <div class="border-b border-slate-100 pb-2">
                <button @click="openSub = (openSub === 'tools' ? null : 'tools')" 
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-bold text-slate-800 hover:bg-slate-50">
                    <div class="flex items-center space-x-2.5">
                        <i data-lucide="layers" class="w-4 h-4 text-amber-600"></i>
                        <span>Công Cụ & AI</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition transform" :class="{'rotate-180 text-rose-600': openSub === 'tools'}"></i>
                </button>
                <div x-show="openSub === 'tools'" x-cloak class="pl-7 pr-2 py-1 space-y-1 text-xs font-semibold">
                    <a href="{{ route('tools.converter') }}" class="block py-2 text-slate-600 hover:text-rose-600">Bảng Quy Đổi Điểm IELTS / TOEIC</a>
                    <a href="{{ route('tools.ipa') }}" class="block py-2 text-slate-600 hover:text-rose-600">Bảng 44 Âm IPA Tương Tác</a>
                    <a href="{{ route('ai.writing.index') }}" class="block py-2 text-slate-600 hover:text-rose-600">AI Chấm Bài Writing 4 Tiêu Chí</a>
                    <a href="{{ route('flashcards.index') }}" class="block py-2 text-slate-600 hover:text-rose-600">Sổ Từ Vựng Flashcard SM-2</a>
                </div>
            </div>

            <div>
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl text-sm font-bold text-slate-800 hover:bg-slate-50">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-slate-500"></i>
                    <span>Dashboard & Radar Điểm Yếu</span>
                </a>
            </div>

            <div class="pt-3">
                <button @click="openQuickDictionary(); mobileMenuOpen = false;" class="w-full py-2.5 bg-slate-100 text-slate-800 font-bold text-xs rounded-xl flex items-center justify-center space-x-2">
                    <i data-lucide="search" class="w-4 h-4 text-slate-500"></i>
                    <span>Tra Cứu Từ Điển Nhanh</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Body Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-12 mt-16">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-xl bg-rose-600 flex items-center justify-center text-white">
                        <i data-lucide="zap" class="w-4 h-4 fill-current"></i>
                    </div>
                    <span class="text-lg font-black font-display text-slate-900">EduLearn English</span>
                    <span class="text-xs text-slate-400">© 2026</span>
                </div>
                <div class="text-xs font-semibold text-slate-500 text-center md:text-right space-y-1">
                    <p>Nền tảng tự học IELTS ứng dụng phương pháp <strong class="text-slate-800">DOL Linearthinking</strong></p>
                    <p class="text-slate-400">Kiến trúc Senior+ DDD • Clean Architecture • CQRS • Zero Race Conditions</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Streak Tracker Modal -->
    <div x-show="showStreakModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200 space-y-6 animate-pop text-center" @click.outside="showStreakModal = false">
            <div class="w-20 h-20 mx-auto rounded-3xl bg-amber-50 border-2 border-amber-200 flex items-center justify-center text-4xl shadow-inner animate-bounce">
                🔥
            </div>

            <div class="space-y-1">
                <h3 class="text-2xl font-black font-display text-slate-900">
                    <span x-text="streak">{{ $currentUser->streak_count ?? 7 }}</span> Ngày Liên Tục!
                </h3>
                <p class="text-xs text-slate-500">Bạn đang duy trì thói quen học tập xuất sắc mỗi ngày.</p>
            </div>

            <!-- Weekly Tracker Grid -->
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Tiến Độ Tuần Này</span>
                <div class="grid grid-cols-7 gap-1.5 text-center">
                    @php
                        $days = ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'];
                    @endphp
                    @foreach($days as $idx => $d)
                    <div class="space-y-1">
                        <div class="w-9 h-9 mx-auto rounded-xl flex items-center justify-center text-xs font-bold {{ $idx <= 5 ? 'bg-amber-400 text-white shadow-2xs' : 'bg-slate-200 text-slate-500' }}">
                            {{ $idx <= 5 ? '✓' : '' }}
                        </div>
                        <span class="text-[10px] font-bold text-slate-400">{{ $d }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="p-3 bg-rose-50 border border-rose-100 rounded-xl text-xs text-rose-800 font-medium">
                💡 <strong>Mẹo:</strong> Hoàn thành ít nhất 1 bài thi, 1 bài nghe hoặc ôn 5 thẻ từ vựng mỗi ngày để duy trì chuỗi Streak!
            </div>

            <button @click="showStreakModal = false" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition">
                Tuyệt Vời, Tiếp Tục Học!
            </button>
        </div>
    </div>

    <!-- Interactive XP Progress Modal -->
    <div x-show="showXpModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200 space-y-6 animate-pop text-center" @click.outside="showXpModal = false">
            <div class="w-20 h-20 mx-auto rounded-3xl bg-indigo-50 border-2 border-indigo-200 flex items-center justify-center text-3xl text-indigo-600 shadow-inner">
                ⚡
            </div>

            <div class="space-y-1">
                <span class="px-3 py-0.5 rounded-full bg-indigo-100 text-indigo-700 text-[10px] font-extrabold uppercase">Cấp Độ 5 • Hạng Vàng 🏆</span>
                <h3 class="text-2xl font-black font-display text-slate-900">
                    <span x-text="xp">{{ $currentUser->xp_points ?? 820 }}</span> Điểm XP
                </h3>
                <p class="text-xs text-slate-500">Tích lũy điểm kinh nghiệm để thăng hạng học viên xuất sắc.</p>
            </div>

            <!-- XP Progress Bar -->
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-2 text-left">
                <div class="flex items-center justify-between text-xs font-bold">
                    <span class="text-slate-600">Tiến độ lên Cấp Độ 6:</span>
                    <span class="text-indigo-600 font-mono">820 / 1000 XP</span>
                </div>
                <div class="w-full h-3 bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-500 to-rose-500 rounded-full transition-all duration-500" style="width: 82%"></div>
                </div>
                <p class="text-[10px] text-slate-400 text-right">Còn 180 XP để thăng hạng tiếp theo</p>
            </div>

            <!-- XP Reward Rules -->
            <div class="text-left space-y-2 text-xs">
                <span class="font-bold text-slate-700 uppercase tracking-wider text-[10px]">Cách kiếm thêm điểm XP:</span>
                <div class="space-y-1.5 font-medium text-slate-600 text-xs">
                    <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                        <span>Hoàn thành 1 bài thi IELTS:</span>
                        <strong class="text-emerald-600">+50 XP</strong>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                        <span>Hoàn thành bài Dictation:</span>
                        <strong class="text-indigo-600">+20 XP</strong>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                        <span>Ôn tập 1 phiên Flashcard SM-2:</span>
                        <strong class="text-amber-600">+10 XP</strong>
                    </div>
                </div>
            </div>

            <button @click="showXpModal = false" class="w-full py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-glow transition">
                Đã Hiểu, Tiếp Tục Tích Lũy!
            </button>
        </div>
    </div>

    <!-- Global 1-Click In-Text Dictionary Popup -->
    <div x-show="showPopup" 
         x-cloak 
         @click.away="showPopup = false"
         :style="`top: ${popupTop}px; left: ${popupLeft}px;`"
         class="fixed z-50 w-80 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-slate-200/90 p-4 transition-all duration-200 animate-pop">
        <div class="flex items-start justify-between">
            <div>
                <h4 class="text-lg font-black font-display text-slate-900" x-text="selectedWord"></h4>
                <p class="text-xs text-rose-600 font-mono" x-text="phonetic"></p>
            </div>
            <button @click="showPopup = false" aria-label="Đóng bảng tra từ vựng" class="text-slate-500 hover:text-slate-800">
                <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
            </button>
        </div>
        
        <div class="mt-2.5 text-xs text-slate-800 bg-slate-100 rounded-xl p-2.5 border border-slate-200 font-medium" x-text="definitionVi"></div>
        
        <div class="mt-3 flex items-center justify-between">
            <button @click="playAudio()" x-show="selectedWord" aria-label="Phát âm từ vựng" class="inline-flex items-center space-x-1 text-xs font-bold text-indigo-700 hover:text-indigo-900 cursor-pointer">
                <i data-lucide="volume-2" class="w-3.5 h-3.5" aria-hidden="true"></i>
                <span>Phát âm</span>
            </button>
            <button @click="saveToNotebook()" aria-label="Lưu từ vào sổ từ vựng cá nhân" class="ml-auto inline-flex items-center space-x-1.5 px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-bold text-xs transition shadow-sm cursor-pointer">
                <i data-lucide="bookmark-plus" class="w-3.5 h-3.5" aria-hidden="true"></i>
                <span x-text="isSaved ? '✓ Đã Lưu' : '+ Lưu vào sổ'"></span>
            </button>
        </div>
    </div>

    <!-- Quick Search Dictionary Modal -->
    <div x-show="showSearchModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-200 space-y-4 animate-pop" @click.outside="showSearchModal = false">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-black font-display text-slate-900">Tra Cứu Từ Điển Nhanh</h3>
                <button @click="showSearchModal = false" aria-label="Đóng hộp thoại tra cứu từ điển" class="text-slate-500 hover:text-slate-800 cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5" aria-hidden="true"></i>
                </button>
            </div>
            <div class="relative">
                <input type="text" 
                       x-model="searchQuery" 
                       aria-label="Nhập từ vựng tiếng Anh để tra cứu"
                       @keydown.enter.prevent="lookupWord(searchQuery); showSearchModal = false;"
                       placeholder="Nhập từ vựng tiếng Anh (VD: compelling, crucial)..." 
                       class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-rose-500 text-sm font-medium">
            </div>
            <button @click="lookupWord(searchQuery); showSearchModal = false;" class="w-full py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm rounded-xl transition cursor-pointer">
                Tra Cứu & Lưu Từ
            </button>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')

    <script>
        function globalApp(initialUser) {
            return {
                mobileMenuOpen: false,
                showSearchModal: false,
                showStreakModal: false,
                showXpModal: false,
                streak: initialUser.streak,
                xp: initialUser.xp,
                searchQuery: '',
                showPopup: false,
                popupTop: 0,
                popupLeft: 0,
                selectedWord: '',
                phonetic: '',
                definitionVi: '',
                audioUrl: '',
                contextSentence: '',
                isSaved: false,

                init() {
                    document.addEventListener('mouseup', (e) => {
                        const selection = window.getSelection();
                        const text = selection.toString().trim();
                        if (text && text.length >= 2 && text.length <= 35 && !text.includes('\n')) {
                            const range = selection.getRangeAt(0);
                            const rect = range.getBoundingClientRect();
                            this.popupTop = Math.max(10, rect.bottom + window.scrollY + 8);
                            this.popupLeft = Math.min(window.innerWidth - 340, Math.max(10, rect.left + window.scrollX - 50));
                            this.lookupWord(text);
                        }
                    });
                },

                openQuickDictionary() {
                    this.showSearchModal = true;
                    this.searchQuery = '';
                },

                async lookupWord(word) {
                    if (!word || !word.trim()) return;
                    this.selectedWord = word.trim();
                    this.isSaved = false;
                    this.definitionVi = 'Đang tra cứu từ điển...';
                    this.phonetic = '';
                    this.audioUrl = '';
                    this.showPopup = true;

                    try {
                        const res = await fetch('/api/dictionary/lookup', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ word: this.selectedWord })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.phonetic = data.phonetic || '';
                            this.definitionVi = data.definition_vi;
                            this.audioUrl = data.audio || '';
                        }
                    } catch (e) {
                        this.definitionVi = 'Không thể tải nghĩa từ điển.';
                    }
                },

                playAudio() {
                    if (this.audioUrl) {
                        new Audio(this.audioUrl).play();
                    } else if ('speechSynthesis' in window) {
                        window.speechSynthesis.cancel();
                        const utter = new SpeechSynthesisUtterance(this.selectedWord);
                        utter.lang = 'en-US';
                        window.speechSynthesis.speak(utter);
                    }
                },

                async saveToNotebook() {
                    try {
                        const res = await fetch('/api/dictionary/save-word', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                word: this.selectedWord,
                                definition_vi: this.definitionVi,
                                phonetic: this.phonetic,
                                audio: this.audioUrl,
                                context_sentence: this.contextSentence
                            })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.isSaved = true;
                        }
                    } catch (e) {}
                }
            };
        }
    </script>
</body>
</html>
