@extends('layouts.app')

@section('title', 'Thư Viện Đề Thi IELTS Academic & General - EduLearn')
@section('meta_description', 'Luyện thi trọn bộ Cambridge IELTS 10 đến 19 Academic & General Training có giải thích chi tiết phương pháp Linearthinking, bấm giờ thi thử tự động chấm điểm Band 9.0.')

@push('styles')
<link rel="preload" as="image" href="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=400&q=75&fm=webp" fetchpriority="high">
@endpush

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    
    <!-- Hero Header -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 bg-gradient-to-r from-slate-900 via-rose-950 to-slate-900 p-8 sm:p-10 rounded-3xl text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-rose-500/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="space-y-2 relative z-10 max-w-2xl">
            <span class="px-3 py-1 bg-rose-500/30 text-rose-200 font-extrabold text-[10px] uppercase tracking-wider rounded-full border border-rose-400/40">
                Cambridge IELTS 10 - 19 & Actual Tests
            </span>
            <h1 class="text-2xl sm:text-3xl font-black font-display tracking-tight text-white">Thư Viện Đề Thi Chuẩn Quốc Tế</h1>
            <p class="text-xs sm:text-sm text-slate-100 font-medium leading-relaxed">
                Hệ thống đề thi chuẩn hóa có chú giải tư duy logic nòng cốt <strong class="text-white">Linearthinking</strong>, phân tích manh mối và bảng từ đồng nghĩa Paraphrase.
            </p>
        </div>

        <div class="flex items-center space-x-3 relative z-10">
            <a href="{{ route('ielts.take', ['slug' => 'cambridge-19-test-1-reading', 'mode' => 'full_test']) }}" 
               aria-label="Vào phòng thi thử ngay với đề thi Cambridge 19 Test 1 Reading"
               class="px-5 py-3 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-glow transition flex items-center space-x-2">
                <i data-lucide="play" class="w-4 h-4 fill-current" aria-hidden="true"></i>
                <span>Thi Thử Ngay (Cam 19)</span>
            </a>
        </div>
    </div>

    <!-- Category Filter Tabs Navigation -->
    <nav class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none" aria-label="Bộ lọc danh mục đề thi">
        <a href="{{ route('ielts.index') }}" 
           aria-label="Xem tất cả bộ đề thi"
           class="px-4 py-2.5 rounded-2xl text-xs font-bold transition whitespace-nowrap {{ !request('category') ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-800 hover:text-slate-950 hover:bg-slate-100 border border-slate-300' }}">
            Tất Cả Bộ Đề ({{ $testSets->count() }})
        </a>
        @foreach($categories as $category)
        <a href="{{ route('ielts.index', ['category' => $category->slug]) }}" 
           aria-label="Lọc đề thi theo danh mục {{ $category->name }}"
           class="px-4 py-2.5 rounded-2xl text-xs font-bold transition whitespace-nowrap {{ request('category') === $category->slug ? 'bg-rose-700 text-white shadow-glow' : 'bg-white text-slate-800 hover:text-slate-950 hover:bg-slate-100 border border-slate-300' }}">
            {{ $category->name }}
        </a>
        @endforeach
    </nav>

    <!-- Main Section Heading for Sequential Hierarchy -->
    <section class="space-y-6" aria-labelledby="section-test-sets-heading">
        <div class="flex items-center justify-between">
            <h2 id="section-test-sets-heading" class="text-xl sm:text-2xl font-black font-display text-slate-900">
                Danh Sách Bộ Đề Thi Cambridge & Forecast
            </h2>
            <span class="text-xs font-bold text-slate-700">{{ $testSets->total() }} bộ đề có sẵn</span>
        </div>

        <!-- Test Sets Grid (Balanced, Premium Equal Heights) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($testSets as $index => $set)
            <article class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-2xl hover:border-rose-200 transition-all duration-300 flex flex-col group h-full">
                <!-- Thumbnail Cover -->
                <div class="relative overflow-hidden h-52 bg-slate-100 flex-shrink-0">
                    <img src="{{ $set->thumbnail ?: 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80' }}" 
                         alt="Ảnh bìa bộ đề {{ $set->title }}" 
                         width="600" 
                         height="208"
                         @if($index === 0) fetchpriority="high" @else loading="lazy" decoding="async" @endif
                         class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/30 to-transparent" aria-hidden="true"></div>
                    
                    <!-- Badges -->
                    <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                        <span class="px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white text-[11px] font-black uppercase tracking-wider border border-white/10 shadow-sm">
                            {{ $set->category->name }}
                        </span>
                        <span class="px-2.5 py-1 rounded-full bg-rose-500/90 backdrop-blur-md text-white text-[10px] font-black tracking-wide shadow-sm flex items-center space-x-1">
                            <i data-lucide="sparkles" class="w-3 h-3"></i>
                            <span>Linearthinking</span>
                        </span>
                    </div>

                    <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between text-white">
                        <span class="px-2.5 py-1 rounded-xl bg-white/20 backdrop-blur-md text-white text-xs font-black flex items-center space-x-1.5 border border-white/20">
                            <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                            <span>{{ $set->tests->count() }} Bài Thi</span>
                        </span>
                        <span class="text-xs font-semibold text-slate-200 flex items-center space-x-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-rose-300"></i>
                            <span>Thời gian chuẩn</span>
                        </span>
                    </div>
                </div>

                <!-- Card Content Body -->
                <div class="p-6 flex flex-col flex-grow justify-between space-y-4">
                    <div class="space-y-2.5">
                        <h3 class="text-lg font-black font-display text-slate-900 leading-snug group-hover:text-rose-600 transition-colors">
                            <a href="{{ route('ielts.show_set', ['slug' => $set->slug]) }}" aria-label="Xem chi tiết bộ đề {{ $set->title }}">
                                {{ $set->title }}
                            </a>
                        </h3>
                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-medium">
                            {{ $set->description }}
                        </p>
                    </div>

                    <!-- Test Items Preview (Limit to 3 items to maintain clean grid layout) -->
                    <div class="space-y-2 border-t border-slate-100 pt-3">
                        <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                            <span>Danh sách đề thi</span>
                            <span>{{ $set->tests->count() }} Đề</span>
                        </div>

                        @forelse($set->tests->take(3) as $test)
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50/80 border border-slate-200/60 hover:bg-rose-50/50 hover:border-rose-200 transition group/item">
                            <div class="min-w-0 flex-1 pr-2">
                                <div class="flex items-center space-x-2">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase {{ str_contains(strtolower($test->type), 'reading') ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $test->type }}
                                    </span>
                                    <p class="text-xs font-bold text-slate-800 truncate" title="{{ $test->title }}">{{ $test->title }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-1.5 flex-shrink-0">
                                <a href="{{ route('ielts.take', ['slug' => $test->slug, 'mode' => 'practice']) }}" 
                                   class="px-2 py-1 bg-white hover:bg-slate-100 text-slate-700 font-bold text-[10px] rounded-lg border border-slate-200 transition shadow-2xs whitespace-nowrap">
                                    Luyện tập
                                </a>
                                <a href="{{ route('ielts.take', ['slug' => $test->slug, 'mode' => 'full_test']) }}" 
                                   class="px-2.5 py-1 bg-rose-600 hover:bg-rose-700 text-white font-bold text-[10px] rounded-lg transition shadow-xs whitespace-nowrap">
                                    Thi thử
                                </a>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-slate-400 text-center py-2 italic">Đang cập nhật đề thi...</p>
                        @endforelse

                        @if($set->tests->count() > 3)
                        <a href="{{ route('ielts.show_set', ['slug' => $set->slug]) }}" 
                           class="flex items-center justify-center space-x-1.5 py-1.5 text-xs font-bold text-slate-500 hover:text-rose-600 hover:bg-rose-50/50 rounded-xl transition">
                            <span>+{{ $set->tests->count() - 3 }} bài thi khác trong bộ này</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </a>
                        @endif
                    </div>

                    <!-- Footer CTA Button -->
                    <div class="pt-2">
                        <a href="{{ route('ielts.show_set', ['slug' => $set->slug]) }}" 
                           class="w-full py-3 px-4 rounded-2xl bg-gradient-to-r from-slate-900 to-slate-800 hover:from-rose-600 hover:to-rose-700 text-white font-black text-xs transition-all duration-300 shadow-sm hover:shadow-lg flex items-center justify-center space-x-2 group-hover:shadow-rose-500/20">
                            <i data-lucide="book-open" class="w-4 h-4"></i>
                            <span>Xem Trọn Bộ Đề ({{ $set->tests->count() }} Bài)</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-slate-200">
                <p class="text-sm font-bold text-slate-500">Chưa có đề thi nào trong danh mục này.</p>
            </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
