<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <div class="flex items-center justify-between h-18 sm:h-20">
                
                <!-- Left: Brand Logo -->
                <div class="flex items-center space-x-6 lg:space-x-8 flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2.5 group whitespace-nowrap">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-tr from-rose-600 via-rose-500 to-rose-400 flex items-center justify-center text-white shadow-glow transform group-hover:scale-105 transition duration-200 flex-shrink-0">
                            <i data-lucide="zap" class="w-5 h-5 fill-current"></i>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center space-x-1.5">
                                <span class="text-xl sm:text-[22px] font-black font-display tracking-tight text-slate-900 leading-none">EduLearn</span>
                                <span class="px-1.5 py-0.5 text-[9px] font-extrabold uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-200/80 rounded-md">DOL</span>
                            </div>
                            <span class="text-[9.5px] font-bold text-slate-400 tracking-wider uppercase hidden sm:block mt-0.5">Linearthinking Method</span>
                        </div>
                    </a>

                    <!-- Desktop Multi-Level Navigation -->
                    <nav class="hidden lg:flex items-center space-x-1">
                        
                        <!-- Link 0: Lộ Trình Học -->
                        <a href="{{ route('roadmaps.index') }}" class="flex items-center space-x-1.5 px-3.5 py-2.5 text-xs xl:text-sm font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('roadmaps.*') ? 'text-rose-700 bg-rose-50' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <i data-lucide="compass" class="w-4 h-4 text-rose-600" aria-hidden="true"></i>
                            <span>Lộ Trình Học</span>
                        </a>

                        <!-- Dropdown 1: Luyện Đề & Thi Thử (IELTS • TOEIC) -->
                        <div class="relative" @mouseenter="activeDropdown = 'ielts'" @mouseleave="activeDropdown = null">
                            <button class="flex items-center space-x-1.5 px-3.5 py-2.5 text-xs xl:text-sm font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('ielts.*') ? 'text-rose-600 bg-rose-50' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100/80' }}">
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
                            <button class="flex items-center space-x-1.5 px-3.5 py-2.5 text-xs xl:text-sm font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('dictation.*') || request()->routeIs('samples.*') ? 'text-rose-600 bg-rose-50' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100/80' }}">
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
                            <button class="flex items-center space-x-1.5 px-3.5 py-2.5 text-xs xl:text-sm font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('flashcards.*') || request()->routeIs('ai.*') ? 'text-rose-600 bg-rose-50' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100/80' }}">
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
                           class="px-3.5 py-2.5 text-xs xl:text-sm font-bold rounded-xl transition whitespace-nowrap {{ request()->routeIs('dashboard') ? 'text-rose-600 bg-rose-50' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <span>Dashboard & Radar</span>
                        </a>
                    </nav>
                </div>

                <!-- Right: Quick Tools, Gamification & Profile (Auth / Guest States) -->
                <div class="flex items-center space-x-2 sm:space-x-3 flex-shrink-0">
                    
                    <!-- Quick Dictionary Button -->
                    <button @click="openQuickDictionary()" 
                            aria-label="Tra cứu từ điển nhanh"
                            class="hidden md:inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition whitespace-nowrap flex-shrink-0">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-slate-600"></i>
                        <span>Tra từ</span>
                    </button>

                    @auth
                    <!-- Interactive Streak Widget -->
                    <button @click="showStreakModal = true" 
                            aria-label="Xem chi tiết chuỗi ngày học Streak {{ $currentUser->streak_count ?? 7 }} ngày"
                            class="flex items-center space-x-1.5 px-3 py-2 rounded-xl bg-amber-100 border border-amber-300 text-amber-950 font-extrabold text-xs shadow-2xs hover:bg-amber-200 transition whitespace-nowrap flex-shrink-0 cursor-pointer" 
                            title="Nhấp để xem chi tiết chuỗi ngày học">
                        <span class="text-sm animate-pulse leading-none" aria-hidden="true">🔥</span>
                        <span x-text="`${streak}d`">{{ $currentUser->streak_count ?? 7 }}d</span>
                    </button>

                    <!-- Interactive XP Widget -->
                    <button @click="showXpModal = true"
                            aria-label="Xem cấp bậc và điểm thưởng {{ $currentUser->xp_points ?? 820 }} XP"
                            class="flex items-center space-x-1 px-3 py-2 rounded-xl bg-indigo-100 border border-indigo-300 text-indigo-950 font-extrabold text-xs shadow-2xs hover:bg-indigo-200 transition whitespace-nowrap flex-shrink-0 cursor-pointer"
                            title="Nhấp để xem cấp bậc và điểm thưởng">
                        <i data-lucide="award" class="w-3.5 h-3.5 text-indigo-700" aria-hidden="true"></i>
                        <span x-text="`${xp} XP`">{{ $currentUser->xp_points ?? 820 }} XP</span>
                    </button>

                    <!-- User Profile Dropdown -->
                    <div class="relative flex-shrink-0" x-data="{ openProfile: false }" @click.outside="openProfile = false">
                        <button @click="openProfile = !openProfile" 
                                aria-label="Mở menu tài khoản cá nhân"
                                :aria-expanded="openProfile ? 'true' : 'false'"
                                class="flex items-center space-x-1.5 p-1 rounded-2xl hover:bg-slate-100 transition focus:outline-none ring-2 ring-transparent focus:ring-rose-500/30">
                            <div class="relative">
                                <img src="{{ $currentUser->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80' }}" 
                                     alt="Ảnh đại diện của {{ $currentUser->name }}" 
                                     width="40" 
                                     height="40" 
                                     class="w-10 h-10 rounded-xl object-cover ring-2 ring-rose-500/20 shadow-2xs">
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
                    <div class="hidden sm:flex items-center space-x-2.5">
                        <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-800 hover:text-rose-700 hover:bg-slate-100 transition">
                            Đăng Nhập
                        </a>
                        <a href="{{ route('register') }}" class="px-4.5 py-2.5 rounded-xl bg-gradient-to-r from-rose-700 to-rose-600 text-white text-xs sm:text-sm font-extrabold shadow-glow hover:opacity-95 transition">
                            Đăng Ký Miễn Phí
                        </a>
                    </div>
                    <!-- Compact Mobile Login Button -->
                    <a href="{{ route('login') }}" class="sm:hidden px-3 py-2 rounded-xl text-xs font-bold text-slate-800 hover:bg-slate-100 border border-slate-200">
                        Đăng Nhập
                    </a>
                    @endauth

                    <!-- Mobile Hamburger Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            aria-label="Mở hoặc đóng menu điều hướng trên thiết bị di động"
                            :aria-expanded="mobileMenuOpen ? 'true' : 'false'"
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

    <!-- Main Footer - Full SEO, E-E-A-T & Semantic Structure -->
    <footer class="bg-white border-t border-slate-200 mt-20 pt-16 pb-12 text-slate-700" itemscope itemtype="https://schema.org/WPFooter">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top Footer: 4 Multi-Column Information Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pb-14 border-b border-slate-200">
                
                <!-- Column 1: Brand, Mission, Organization Info & Contact (Lg: col-span-4) -->
                <div class="lg:col-span-4 space-y-5">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-rose-600 to-rose-700 flex items-center justify-center text-white shadow-glow">
                            <i data-lucide="zap" class="w-5 h-5 fill-current" aria-hidden="true"></i>
                        </div>
                        <div>
                            <span class="text-xl font-black font-display text-slate-900 tracking-tight block">EduLearn English</span>
                            <span class="text-[11px] font-bold text-rose-600 uppercase tracking-wider block font-mono">DOL Linearthinking Method</span>
                        </div>
                    </div>
                    
                    <p class="text-sm text-slate-600 leading-relaxed font-medium">
                        Hệ thống tự học và luyện thi IELTS, TOEIC trực tuyến ứng dụng độc quyền phương pháp tư duy <strong>Linearthinking</strong>. Tối ưu 50% thời gian làm bài, nhớ từ vựng sâu qua ngữ cảnh và bứt phá band điểm 8.0+.
                    </p>

                    <!-- Contact & Entity Details (Local SEO & Authority) -->
                    <div class="space-y-2.5 pt-2 text-xs font-semibold text-slate-700">
                        <div class="flex items-center space-x-2.5">
                            <i data-lucide="phone-call" class="w-4 h-4 text-rose-600 flex-shrink-0" aria-hidden="true"></i>
                            <span>Hotline tư vấn: <a href="tel:19008668" class="font-bold text-slate-900 hover:text-rose-600 transition">1900 8668</a> (8:00 - 21:30 hàng ngày)</span>
                        </div>
                        <div class="flex items-center space-x-2.5">
                            <i data-lucide="mail" class="w-4 h-4 text-rose-600 flex-shrink-0" aria-hidden="true"></i>
                            <span>Email hỗ trợ: <a href="mailto:support@edulearn.edu.vn" class="font-bold text-slate-900 hover:text-rose-600 transition">support@edulearn.edu.vn</a></span>
                        </div>
                        <div class="flex items-start space-x-2.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" aria-hidden="true"></i>
                            <span class="leading-relaxed">Cơ sở học thuật: Tòa nhà EduLearn Innovation, Đống Đa, Hà Nội & Quận 1, TP. Hồ Chí Minh</span>
                        </div>
                    </div>

                    <!-- Social Channels -->
                    <div class="flex items-center space-x-3 pt-2">
                        <span class="text-xs font-bold text-slate-900 mr-1">Kết nối:</span>
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Fanpage Facebook EduLearn English" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 flex items-center justify-center transition border border-slate-200 hover:border-rose-300">
                            <i data-lucide="facebook" class="w-4 h-4" aria-hidden="true"></i>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="Kênh Youtube Học IELTS DOL" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 flex items-center justify-center transition border border-slate-200 hover:border-rose-300">
                            <i data-lucide="youtube" class="w-4 h-4" aria-hidden="true"></i>
                        </a>
                        <a href="https://tiktok.com" target="_blank" rel="noopener noreferrer" aria-label="Kênh TikTok Luyện Thi IELTS" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 flex items-center justify-center transition border border-slate-200 hover:border-rose-300">
                            <i data-lucide="video" class="w-4 h-4" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Luyện Thi & Bộ Đề (Lg: col-span-3) -->
                <div class="lg:col-span-3 space-y-4">
                    <p class="text-sm font-black font-display uppercase tracking-wider text-slate-900 border-l-4 border-rose-600 pl-2.5">
                        Kho Đề & Luyện Thi
                    </p>
                    <ul class="space-y-2.5 text-xs font-semibold text-slate-600">
                        <li>
                            <a href="{{ route('ielts.index') }}" class="hover:text-rose-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-rose-500" aria-hidden="true"></i>
                                <span>IELTS Academic (Cambridge 10-19)</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ielts.index') }}?category=ielts-general-training" class="hover:text-rose-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-rose-500" aria-hidden="true"></i>
                                <span>IELTS General Training Mới Nhất</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ielts.index') }}?category=toeic-reading-listening" class="hover:text-rose-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-rose-500" aria-hidden="true"></i>
                                <span>Luyện Thi TOEIC 7 Part Chuẩn ETS</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ielts.index') }}?category=ielts-recent-actual-tests" class="hover:text-rose-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-rose-500" aria-hidden="true"></i>
                                <span>Đề Thi Thật Forecast & Actual 2025</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('roadmaps.index') }}" class="hover:text-rose-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-rose-500" aria-hidden="true"></i>
                                <span>Lộ Trình Học Cá Nhân Hóa Theo Band</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ielts.take', 'cambridge-19-test-1-reading') }}" class="hover:text-rose-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-rose-500" aria-hidden="true"></i>
                                <span>Phòng Thi Thử Full 40 Câu (Miễn Phí)</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Kỹ Năng & Công Cụ Học Tập (Lg: col-span-3) -->
                <div class="lg:col-span-3 space-y-4">
                    <p class="text-sm font-black font-display uppercase tracking-wider text-slate-900 border-l-4 border-indigo-600 pl-2.5">
                        Kỹ Năng & Công Cụ
                    </p>
                    <ul class="space-y-2.5 text-xs font-semibold text-slate-600">
                        <li>
                            <a href="{{ route('dictation.index') }}" class="hover:text-indigo-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-indigo-500" aria-hidden="true"></i>
                                <span>Nghe Chép Chính Tả (Dictation Studio)</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('flashcards.index') }}" class="hover:text-indigo-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-indigo-500" aria-hidden="true"></i>
                                <span>Sổ Từ Vựng & Flashcard Lặp Lại SM-2</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ai.writing.index') }}" class="hover:text-indigo-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-indigo-500" aria-hidden="true"></i>
                                <span>AI Chấm Writing Chuẩn 4 Tiêu Chí IELTS</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('samples.writing.index') }}" class="hover:text-indigo-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-indigo-500" aria-hidden="true"></i>
                                <span>Ngân Hàng Bài Mẫu Writing Band 8.0+</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('samples.speaking.index') }}" class="hover:text-indigo-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-indigo-500" aria-hidden="true"></i>
                                <span>Bài Mẫu Speaking Part 1, 2, 3 Audio</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tools.converter') }}" class="hover:text-indigo-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-indigo-500" aria-hidden="true"></i>
                                <span>Bảng Quy Đổi Điểm IELTS & TOEIC</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tools.ipa') }}" class="hover:text-indigo-600 hover:translate-x-1 inline-flex items-center space-x-1.5 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-indigo-500" aria-hidden="true"></i>
                                <span>Bảng Phiên Âm Quốc Tế IPA Tương Tác</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: Về EduLearn & Cam Kết Chất Lượng (Lg: col-span-2) -->
                <div class="lg:col-span-2 space-y-4">
                    <p class="text-sm font-black font-display uppercase tracking-wider text-slate-900 border-l-4 border-emerald-600 pl-2.5">
                        Về EduLearn
                    </p>
                    <ul class="space-y-2.5 text-xs font-semibold text-slate-600">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-slate-900 hover:underline transition">
                                Phương pháp Linearthinking
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard') }}" class="hover:text-slate-900 hover:underline transition">
                                Radar Phân Tích Kỹ Năng
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-slate-900 hover:underline transition">
                                Đội Ngũ Giảng Viên 8.5+
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-slate-900 hover:underline transition">
                                Điều Khoản Dịch Vụ
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-slate-900 hover:underline transition">
                                Chính Sách Bảo Mật
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-slate-900 hover:underline transition">
                                Hướng Dẫn Tự Học Hiệu Quả
                            </a>
                        </li>
                    </ul>

                    <!-- Trust Seal Badges -->
                    <div class="pt-2 space-y-2">
                        <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-[10px] font-extrabold text-emerald-800">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600" aria-hidden="true"></i>
                            <span>Bảo Mật SSL 256-Bit</span>
                        </span>
                        <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-[10px] font-extrabold text-slate-700">
                            <i data-lucide="award" class="w-3.5 h-3.5 text-slate-600" aria-hidden="true"></i>
                            <span>Chuẩn Học Thuật CEFR</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Bottom Legal, Copyright & Badges -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-semibold text-slate-600">
                <p>
                    © 2026 <strong class="text-slate-900">EduLearn English</strong>. Hệ thống tự học tiếng Anh trực tuyến ứng dụng phương pháp Linearthinking.
                </p>
                <div class="flex items-center space-x-4 text-slate-600">
                    <a href="{{ route('home') }}" class="hover:text-rose-600 transition">Quy chế hoạt động</a>
                    <span>•</span>
                    <a href="{{ route('home') }}" class="hover:text-rose-600 transition">Chính sách bảo mật</a>
                    <span>•</span>
                    <a href="{{ route('home') }}" class="hover:text-rose-600 transition">Điều khoản sử dụng</a>
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

    <!-- Global 1-Click In-Text Dictionary Popover -->
    <div x-show="showPopup" 
         x-cloak 
         @click.away="showPopup = false"
         :style="`top: ${popupTop}px; left: ${popupLeft}px;`"
         class="fixed z-50 w-84 bg-white/95 backdrop-blur-xl rounded-2xl shadow-dropdown border border-slate-200/90 p-4 transition-all duration-200 animate-pop">
        <div class="flex items-start justify-between">
            <div>
                <div class="flex items-center space-x-2">
                    <h4 class="text-base font-black font-display text-slate-900" x-text="selectedWord"></h4>
                    <span x-show="selectedPos" class="px-1.5 py-0.2 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded text-[9px] font-black uppercase" x-text="selectedPos"></span>
                </div>
                <p class="text-xs text-rose-600 font-mono font-bold mt-0.5" x-text="phonetic"></p>
            </div>
            <button @click="showPopup = false" aria-label="Đóng bảng tra từ vựng" class="text-slate-400 hover:text-slate-700 p-0.5">
                <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
            </button>
        </div>
        
        <div class="mt-2.5 text-xs text-slate-800 bg-rose-50/80 rounded-xl p-3 border border-rose-200/70 font-semibold leading-relaxed" x-text="definitionVi"></div>
        
        <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between gap-2">
            <button @click="playAudio('us')" x-show="selectedWord" aria-label="Phát âm từ vựng" class="inline-flex items-center space-x-1 text-xs font-extrabold text-indigo-600 hover:text-indigo-800 cursor-pointer">
                <i data-lucide="volume-2" class="w-3.5 h-3.5" aria-hidden="true"></i>
                <span>Phát âm</span>
            </button>
            <div class="flex items-center space-x-1.5 ml-auto">
                <button @click="openQuickDictionary(selectedWord)" class="text-[11px] font-bold text-slate-500 hover:text-slate-900 px-2 py-1 rounded-lg hover:bg-slate-100 transition">
                    Chi tiết →
                </button>
                <button @click="saveToNotebook()" aria-label="Lưu từ vào sổ từ vựng" class="inline-flex items-center space-x-1 px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-bold text-xs transition shadow-2xs cursor-pointer">
                    <i data-lucide="bookmark-plus" class="w-3.5 h-3.5" aria-hidden="true"></i>
                    <span x-text="isSaved ? '✓ Đã Lưu' : '+ Lưu'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Search Dictionary Slide-over Drawer -->
    <div x-show="showSearchModal" x-cloak class="fixed inset-0 z-50 overflow-hidden bg-slate-950/60 backdrop-blur-xs flex justify-end transition-opacity duration-200">
        <div class="bg-white w-full max-w-lg h-full shadow-2xl flex flex-col transform transition-transform duration-300 overflow-hidden" 
             @click.outside="showSearchModal = false">
             
            <!-- Drawer Header -->
            <div class="px-6 py-4.5 border-b border-slate-200 flex items-center justify-between bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white flex-shrink-0">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-600 flex items-center justify-center text-white shadow-glow">
                        <i data-lucide="book-open" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black font-display tracking-tight text-white leading-tight">Từ Điển Tra Cứu Thông Minh</h3>
                        <p class="text-[11px] text-slate-300 font-medium mt-0.5">Phiên âm IPA • Audio US/UK • Nghĩa Linearthinking</p>
                    </div>
                </div>
                <button @click="showSearchModal = false" class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-white/10 transition cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Search Input & Suggested Keywords -->
            <div class="p-5 border-b border-slate-100 bg-slate-50/70 space-y-3 flex-shrink-0">
                <div class="relative flex items-center">
                    <i data-lucide="search" class="w-5 h-5 text-slate-400 absolute left-4 pointer-events-none"></i>
                    <input type="text" 
                           x-model="searchQuery" 
                           x-ref="dictInput"
                           @keydown.enter.prevent="searchDictionary(searchQuery)"
                           placeholder="Nhập từ vựng tiếng Anh (crucial, compelling, reimburse...)" 
                           class="w-full pl-12 pr-10 py-3 rounded-2xl bg-white border border-slate-300 focus:border-rose-500 focus:ring-3 focus:ring-rose-500/15 text-sm font-semibold text-slate-900 shadow-2xs transition">
                    <button x-show="searchQuery" @click="searchQuery = ''; $refs.dictInput.focus()" class="absolute right-3.5 text-slate-400 hover:text-slate-600 p-1">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- High-Frequency Academic Suggestion Tags -->
                <div class="flex items-center space-x-1.5 overflow-x-auto pb-1 text-xs">
                    <span class="text-[11px] font-bold text-slate-400 flex-shrink-0">Gợi ý:</span>
                    <template x-for="tag in ['crucial', 'compelling', 'autonomous', 'feasible', 'mitigate', 'reimburse', 'warranty']" :key="tag">
                        <button @click="searchQuery = tag; searchDictionary(tag)" 
                                class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 hover:border-rose-300 hover:bg-rose-50 text-slate-700 hover:text-rose-700 text-[11px] font-bold transition flex-shrink-0">
                            <span x-text="tag"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Drawer Results Area -->
            <div class="flex-1 overflow-y-auto p-6 space-y-5">
                <!-- Loading State -->
                <div x-show="dictLoading" class="py-16 text-center space-y-3">
                    <div class="w-10 h-10 border-3 border-rose-600 border-t-transparent rounded-full animate-spin mx-auto"></div>
                    <p class="text-xs font-bold text-slate-500">Đang tra cứu cơ sở dữ liệu từ điển...</p>
                </div>

                <!-- Initial Empty State -->
                <div x-show="!dictLoading && !dictResult" class="py-16 text-center space-y-3">
                    <div class="w-14 h-14 rounded-3xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto shadow-2xs">
                        <i data-lucide="sparkles" class="w-7 h-7"></i>
                    </div>
                    <h4 class="text-sm font-black text-slate-800">Tra cứu nhanh từ vựng bất kỳ</h4>
                    <p class="text-xs text-slate-500 max-w-xs mx-auto leading-relaxed">
                        Gõ từ vựng tiếng Anh vào ô tìm kiếm hoặc bôi đen trực tiếp từ vựng trong bài đọc thi IELTS / TOEIC để tra nghĩa tức thì.
                    </p>
                </div>

                <!-- Active Result Display Card -->
                <div x-show="!dictLoading && dictResult" class="space-y-5 animate-pop">
                    <!-- Word & Pronunciation Card -->
                    <div class="bg-gradient-to-br from-slate-50 via-white to-rose-50/40 rounded-3xl p-6 border border-slate-200/90 shadow-2xs space-y-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center space-x-2">
                                    <h2 class="text-2xl font-black font-display text-slate-900 tracking-tight" x-text="dictResult?.word"></h2>
                                    <span x-show="dictResult?.part_of_speech" 
                                          class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200/80" 
                                          x-text="dictResult?.part_of_speech"></span>
                                </div>
                                <p class="text-sm text-rose-600 font-mono font-bold mt-1" x-text="dictResult?.phonetic || '/.../'"></p>
                            </div>

                            <!-- Save to Flashcard Button -->
                            <button @click="saveFromDrawer()" 
                                    class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 shadow-2xs cursor-pointer"
                                    :class="dictResult?.isSaved ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-rose-600 hover:bg-rose-700 text-white shadow-glow'">
                                <i data-lucide="bookmark-check" class="w-4 h-4" x-show="dictResult?.isSaved"></i>
                                <i data-lucide="bookmark-plus" class="w-4 h-4" x-show="!dictResult?.isSaved"></i>
                                <span x-text="dictResult?.isSaved ? '✓ Đã Lưu' : '+ Lưu Flashcard'"></span>
                            </button>
                        </div>

                        <!-- Pronunciation Buttons (US & UK) -->
                        <div class="flex items-center space-x-2.5 pt-3 border-t border-slate-200/70">
                            <button @click="playPronunciation('us')" 
                                    class="flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:border-indigo-400 hover:bg-indigo-50/50 text-slate-800 text-xs font-extrabold transition shadow-2xs cursor-pointer">
                                <i data-lucide="volume-2" class="w-3.5 h-3.5 text-indigo-600"></i>
                                <span>Phát âm US (Mỹ)</span>
                            </button>
                            <button @click="playPronunciation('uk')" 
                                    class="flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:border-rose-400 hover:bg-rose-50/50 text-slate-800 text-xs font-extrabold transition shadow-2xs cursor-pointer">
                                <i data-lucide="volume-2" class="w-3.5 h-3.5 text-rose-600"></i>
                                <span>Phát âm UK (Anh)</span>
                            </button>
                        </div>
                    </div>

                    <!-- Vietnamese Definition -->
                    <div class="space-y-2">
                        <h5 class="text-xs font-black uppercase tracking-wider text-slate-400 flex items-center space-x-1.5">
                            <i data-lucide="flag" class="w-3.5 h-3.5 text-rose-500"></i>
                            <span>Nghĩa Tiếng Việt (Linearthinking)</span>
                        </h5>
                        <div class="p-4 rounded-2xl bg-rose-50/80 border border-rose-200/80 text-sm font-bold text-slate-900 leading-relaxed" 
                             x-text="dictResult?.definition_vi"></div>
                    </div>

                    <!-- English Definition -->
                    <div class="space-y-2" x-show="dictResult?.definition_en">
                        <h5 class="text-xs font-black uppercase tracking-wider text-slate-400 flex items-center space-x-1.5">
                            <i data-lucide="book" class="w-3.5 h-3.5 text-indigo-500"></i>
                            <span>Định Nghĩa Tiếng Anh Chuẩn</span>
                        </h5>
                        <div class="p-4 rounded-2xl bg-white border border-slate-200 text-xs font-medium text-slate-700 leading-relaxed italic" 
                             x-text="dictResult?.definition_en"></div>
                    </div>

                    <!-- Contextual Example -->
                    <div class="space-y-2" x-show="dictResult?.example">
                        <h5 class="text-xs font-black uppercase tracking-wider text-slate-400 flex items-center space-x-1.5">
                            <i data-lucide="quote" class="w-3.5 h-3.5 text-amber-500"></i>
                            <span>Ví Dụ Trong Ngữ Cảnh</span>
                        </h5>
                        <div class="p-4 rounded-2xl bg-slate-100/90 border border-slate-200/80 text-xs font-semibold text-slate-800 leading-relaxed" 
                             x-text="dictResult?.example"></div>
                    </div>
                </div>
            </div>

            <!-- Drawer Footer -->
            <div class="p-4 border-t border-slate-200 bg-white flex items-center justify-between text-xs font-bold flex-shrink-0">
                <a href="{{ route('flashcards.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center space-x-1 transition">
                    <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                    <span>Mở Sổ Từ Vựng Flashcard SM-2 →</span>
                </a>
                <button @click="showSearchModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition cursor-pointer">
                    Đóng
                </button>
            </div>
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
                dictLoading: false,
                dictResult: null,

                // Popup in-text lookup
                showPopup: false,
                popupTop: 0,
                popupLeft: 0,
                selectedWord: '',
                selectedPos: '',
                phonetic: '',
                definitionVi: '',
                audioUrl: '',
                audioUs: '',
                audioUk: '',
                contextSentence: '',
                isSaved: false,

                init() {
                    // Document mouseup for in-text selection lookup
                    document.addEventListener('mouseup', (e) => {
                        // Skip if selecting inside drawer or input
                        if (e.target.closest('input') || e.target.closest('textarea') || e.target.closest('.fixed')) return;
                        
                        const selection = window.getSelection();
                        const text = selection.toString().trim();
                        if (text && text.length >= 2 && text.length <= 35 && !text.includes('\n')) {
                            const range = selection.getRangeAt(0);
                            const rect = range.getBoundingClientRect();
                            this.popupTop = Math.max(10, rect.bottom + window.scrollY + 8);
                            this.popupLeft = Math.min(window.innerWidth - 350, Math.max(10, rect.left + window.scrollX - 50));
                            this.lookupWord(text);
                        }
                    });

                    // Shortcut Ctrl+K to open Dictionary
                    document.addEventListener('keydown', (e) => {
                        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                            e.preventDefault();
                            this.openQuickDictionary();
                        }
                    });

                    // Listen to global open-quick-dict event
                    window.addEventListener('open-quick-dict', (e) => {
                        this.openQuickDictionary(e.detail?.word || '');
                    });
                },

                openQuickDictionary(prefillWord = '') {
                    this.showSearchModal = true;
                    this.showPopup = false;
                    if (prefillWord) {
                        this.searchQuery = prefillWord;
                        this.searchDictionary(prefillWord);
                    } else {
                        setTimeout(() => {
                            if (this.$refs.dictInput) this.$refs.dictInput.focus();
                        }, 100);
                    }
                },

                async searchDictionary(word) {
                    if (!word || !word.trim()) return;
                    this.dictLoading = true;
                    const cleanWord = word.trim();

                    try {
                        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
                        const res = await fetch('/api/dictionary/lookup', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify({ word: cleanWord })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.dictResult = {
                                word: data.word,
                                phonetic: data.phonetic || '',
                                audio_us: data.audio_us || data.audio || '',
                                audio_uk: data.audio_uk || data.audio || '',
                                part_of_speech: data.part_of_speech || '',
                                definition_vi: data.definition_vi || '',
                                definition_en: data.definition_en || '',
                                example: data.example || '',
                                isSaved: false
                            };
                        } else {
                            this.dictResult = {
                                word: cleanWord,
                                phonetic: '',
                                audio_us: '',
                                audio_uk: '',
                                part_of_speech: '',
                                definition_vi: data.message || 'Không tìm thấy kết quả phù hợp trong từ điển.',
                                definition_en: '',
                                example: '',
                                isSaved: false
                            };
                        }
                    } catch (e) {
                        this.dictResult = {
                            word: cleanWord,
                            phonetic: '',
                            audio_us: '',
                            audio_uk: '',
                            part_of_speech: '',
                            definition_vi: 'Không thể tải kết quả từ điển.',
                            definition_en: '',
                            example: '',
                            isSaved: false
                        };
                    } finally {
                        this.dictLoading = false;
                        this.$nextTick(() => {
                            if (window.lucide) window.lucide.createIcons();
                        });
                    }
                },

                async lookupWord(word) {
                    if (!word || !word.trim()) return;
                    this.selectedWord = word.trim();
                    this.isSaved = false;
                    this.definitionVi = 'Đang tra cứu từ điển...';
                    this.phonetic = '';
                    this.selectedPos = '';
                    this.audioUrl = '';
                    this.audioUs = '';
                    this.audioUk = '';
                    this.showPopup = true;

                    try {
                        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
                        const res = await fetch('/api/dictionary/lookup', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify({ word: this.selectedWord })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.phonetic = data.phonetic || '';
                            this.selectedPos = data.part_of_speech || '';
                            this.definitionVi = data.definition_vi;
                            this.audioUs = data.audio_us || data.audio || '';
                            this.audioUk = data.audio_uk || data.audio || '';
                            this.audioUrl = this.audioUs || this.audioUk;
                        } else {
                            this.definitionVi = data.message || 'Không tìm thấy định nghĩa cho từ này.';
                        }
                    } catch (e) {
                        this.definitionVi = 'Không thể tải nghĩa từ điển.';
                    } finally {
                        this.$nextTick(() => {
                            if (window.lucide) window.lucide.createIcons();
                        });
                    }
                },

                playPronunciation(accent = 'us') {
                    const audioUrl = (accent === 'uk') ? (this.dictResult?.audio_uk || this.dictResult?.audio_us) : (this.dictResult?.audio_us || this.dictResult?.audio_uk);
                    const word = this.dictResult?.word || this.searchQuery;

                    if (audioUrl) {
                        new Audio(audioUrl).play().catch(() => this.speakWord(word, accent));
                    } else {
                        this.speakWord(word, accent);
                    }
                },

                playAudio(accent = 'us') {
                    const audioUrl = (accent === 'uk') ? (this.audioUk || this.audioUrl) : (this.audioUs || this.audioUrl);
                    if (audioUrl) {
                        new Audio(audioUrl).play().catch(() => this.speakWord(this.selectedWord, accent));
                    } else {
                        this.speakWord(this.selectedWord, accent);
                    }
                },

                speakWord(word, accent = 'us') {
                    if ('speechSynthesis' in window && word) {
                        window.speechSynthesis.cancel();
                        const utter = new SpeechSynthesisUtterance(word);
                        utter.lang = (accent === 'uk') ? 'en-GB' : 'en-US';
                        utter.rate = 0.9;
                        window.speechSynthesis.speak(utter);
                    }
                },

                async saveFromDrawer() {
                    if (!this.dictResult || this.dictResult.isSaved) return;

                    try {
                        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
                        const res = await fetch('/api/dictionary/save-word', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify({
                                word: this.dictResult.word,
                                definition_vi: this.dictResult.definition_vi,
                                phonetic: this.dictResult.phonetic,
                                audio: this.dictResult.audio_us || this.dictResult.audio_uk,
                                part_of_speech: this.dictResult.part_of_speech,
                                context_sentence: this.dictResult.example
                            })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.dictResult.isSaved = true;
                        }
                    } catch (e) {}
                },

                async saveToNotebook() {
                    try {
                        const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
                        const res = await fetch('/api/dictionary/save-word', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify({
                                word: this.selectedWord,
                                definition_vi: this.definitionVi,
                                phonetic: this.phonetic,
                                audio: this.audioUrl,
                                part_of_speech: this.selectedPos,
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
