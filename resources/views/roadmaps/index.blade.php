@extends('layouts.app')

@section('title', 'Lộ Trình Tự Học IELTS, TOEIC & Tiếng Anh Toàn Diện - EduLearn')
@section('meta_description', 'Khám phá các lộ trình tự học tiếng Anh bài bản từ mất gốc lên IELTS 7.0+, TOEIC 800+ và Tiếng Anh Giao Tiếp Doanh Nghiệp theo phương pháp tư duy Linearthinking.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    
    <!-- Hero Header -->
    <div class="bg-gradient-to-r from-slate-900 via-rose-950 to-slate-900 text-white rounded-3xl p-8 sm:p-12 shadow-2xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-rose-500/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="relative z-10 space-y-4 max-w-3xl">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-rose-500/20 border border-rose-400/40 text-rose-300 text-xs font-extrabold uppercase tracking-wide">
                <span>🗺️ Personalized Learning Pathways</span>
                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                <span>DOL Linearthinking</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-black font-display tracking-tight leading-tight">
                Lộ Trình Tự Học Bài Bản <br>
                <span class="bg-gradient-to-r from-rose-400 via-rose-300 to-amber-300 bg-clip-text text-transparent">Chinh Phục Mọi Mục Tiêu</span>
            </h1>
            <p class="text-sm sm:text-base text-slate-300 font-medium leading-relaxed">
                Được thiết kế khoa học theo từng tuần, tích hợp phòng thi Cambridge, nghe chép chính tả 4 bước, flashcard SM-2 và AI chấm bài chuyên sâu.
            </p>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    <div class="flex items-center space-x-2 overflow-x-auto pb-2 border-b border-slate-200" role="tablist">
        <a href="{{ route('roadmaps.index') }}" 
           class="px-4 py-2.5 rounded-xl text-xs font-bold transition whitespace-nowrap {{ !$category ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100' }}">
            Tất Cả Lộ Trình
        </a>
        <a href="{{ route('roadmaps.index', ['category' => 'ielts']) }}" 
           class="px-4 py-2.5 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $category === 'ielts' ? 'bg-rose-700 text-white shadow-glow' : 'bg-white text-slate-700 hover:bg-slate-100' }}">
            🎓 IELTS Academic (0 - 8.5+)
        </a>
        <a href="{{ route('roadmaps.index', ['category' => 'toeic']) }}" 
           class="px-4 py-2.5 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $category === 'toeic' ? 'bg-indigo-700 text-white shadow-glow' : 'bg-white text-slate-700 hover:bg-slate-100' }}">
            🏢 TOEIC 4 Kỹ Năng (450 - 900+)
        </a>
        <a href="{{ route('roadmaps.index', ['category' => 'communication']) }}" 
           class="px-4 py-2.5 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $category === 'communication' ? 'bg-amber-700 text-white shadow-glow' : 'bg-white text-slate-700 hover:bg-slate-100' }}">
            🗣️ Giao Tiếp & Thuyết Trình TED
        </a>
    </div>

    <!-- Roadmap Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($roadmaps as $roadmap)
        <div class="bg-white rounded-3xl border border-slate-200/90 p-7 shadow-xs hover:shadow-xl transition-all duration-200 flex flex-col justify-between space-y-6 group hover:-translate-y-1">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider
                        @if($roadmap->color_theme === 'rose') bg-rose-50 text-rose-700 border border-rose-200
                        @elseif($roadmap->color_theme === 'indigo') bg-indigo-50 text-indigo-700 border border-indigo-200
                        @elseif($roadmap->color_theme === 'amber') bg-amber-50 text-amber-800 border border-amber-200
                        @else bg-emerald-50 text-emerald-800 border border-emerald-200 @endif">
                        {{ $roadmap->badge_title ?: $roadmap->target_level }}
                    </span>
                    <span class="text-xs font-bold text-slate-500">⏱️ {{ $roadmap->duration_weeks }} Tuần</span>
                </div>

                <h3 class="text-xl font-black font-display text-slate-900 group-hover:text-rose-600 transition leading-snug">
                    {{ $roadmap->title }}
                </h3>

                <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed line-clamp-3">
                    {{ $roadmap->description }}
                </p>

                <!-- Roadmap Phases Preview List -->
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Các Giai Đoạn Trọng Tâm:</span>
                    @foreach($roadmap->phases as $phase)
                    <div class="flex items-center space-x-2 text-xs font-bold text-slate-800">
                        <span class="w-5 h-5 rounded-md bg-white border border-slate-200 flex items-center justify-center text-[10px] text-slate-600 flex-shrink-0">
                            {{ $phase->phase_number }}
                        </span>
                        <span class="truncate">{{ $phase->title }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('roadmaps.show', ['slug' => $roadmap->slug]) }}" 
               class="w-full py-3.5 bg-slate-900 hover:bg-rose-600 text-white font-extrabold text-xs sm:text-sm rounded-2xl text-center block transition shadow-md group-hover:shadow-glow">
                Xem Chi Tiết Lộ Trình →
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
