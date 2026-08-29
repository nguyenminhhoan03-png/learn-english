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

        <!-- Test Sets Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($testSets as $index => $set)
            <article class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-xl transition duration-200 flex flex-col justify-between group">
                <div>
                    <div class="relative overflow-hidden h-48 bg-slate-100">
                        <img src="{{ $set->thumbnail ?: 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=400&q=75&fm=webp' }}" 
                             alt="Ảnh bìa bộ đề {{ $set->title }}" 
                             width="400" 
                             height="192"
                             @if($index === 0) fetchpriority="high" @else loading="lazy" decoding="async" @endif
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 to-transparent" aria-hidden="true"></div>
                        <div class="absolute top-3 left-3 flex items-center space-x-1.5">
                            <span class="px-2.5 py-1 rounded-xl bg-slate-900/90 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wide">
                                {{ $set->category->name }}
                            </span>
                        </div>
                        <div class="absolute bottom-3 left-3 right-3 text-white">
                            <span class="text-xs font-bold opacity-95">📚 {{ $set->tests->count() }} Bài Thi Đã Sẵn Sàng</span>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 space-y-2.5">
                        <h3 class="text-base sm:text-lg font-black font-display text-slate-900 leading-snug group-hover:text-rose-700 transition">
                            <a href="{{ route('ielts.show_set', ['slug' => $set->slug]) }}" aria-label="Xem chi tiết bộ đề {{ $set->title }}">{{ $set->title }}</a>
                        </h3>
                        <p class="text-xs text-slate-700 line-clamp-2 leading-relaxed">{{ $set->description }}</p>
                    </div>
                </div>

                <!-- Tests In Set Compact List (Zero line-wrapping) -->
                <div class="p-5 sm:p-6 pt-0 space-y-2.5">
                    <div class="border-t border-slate-100 pt-3 space-y-2">
                        @forelse($set->tests as $test)
                        <div class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50 border border-slate-200/80 gap-2 hover:bg-slate-100/80 transition">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold text-slate-900 truncate" title="{{ $test->title }}">{{ $test->title }}</p>
                                <span class="text-[10px] font-semibold text-slate-700 block uppercase">{{ $test->type }} • {{ $test->duration_minutes }}p</span>
                            </div>
                            <div class="flex items-center space-x-1.5 flex-shrink-0">
                                <a href="{{ route('ielts.take', ['slug' => $test->slug, 'mode' => 'practice']) }}" 
                                   aria-label="Luyện tập có giải thích đề {{ $test->title }}"
                                   class="px-2.5 py-1.5 bg-white hover:bg-slate-200 text-indigo-800 font-extrabold text-[11px] rounded-xl border border-slate-300 transition shadow-2xs whitespace-nowrap flex-shrink-0" 
                                   title="Luyện tập có giải thích">
                                    Luyện tập
                                </a>
                                <a href="{{ route('ielts.take', ['slug' => $test->slug, 'mode' => 'full_test']) }}" 
                                   aria-label="Thi thử bấm giờ 60 phút đề {{ $test->title }}"
                                   class="px-2.5 py-1.5 bg-rose-700 hover:bg-rose-800 text-white font-extrabold text-[11px] rounded-xl transition shadow-glow whitespace-nowrap flex-shrink-0" 
                                   title="Thi thử bấm giờ 60p">
                                    Thi thử
                                </a>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-slate-700 text-center py-2">Đang cập nhật thêm đề thi...</p>
                        @endforelse
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-slate-200">
                <p class="text-sm font-bold text-slate-700">Chưa có đề thi nào trong danh mục này.</p>
            </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
