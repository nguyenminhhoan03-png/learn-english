@extends('layouts.app')

@section('title', $roadmap->title . ' - LearnEnglish')
@section('meta_description', $roadmap->description)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    
    <!-- Breadcrumb & Back -->
    <div>
        <a href="{{ route('roadmaps.index') }}" class="inline-flex items-center space-x-2 text-xs sm:text-sm font-bold text-slate-600 hover:text-slate-900 transition">
            <i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i>
            <span>Tất cả các lộ trình</span>
        </a>
    </div>

    <!-- Header Roadmap Card -->
    <div class="bg-gradient-to-r from-slate-900 via-rose-950 to-slate-900 text-white rounded-3xl p-8 sm:p-10 shadow-2xl space-y-6 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-rose-500/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="relative z-10 space-y-3 max-w-3xl">
            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-1 bg-rose-500/30 text-rose-200 border border-rose-400/40 text-xs font-black rounded-full uppercase">
                    Mục Tiêu: {{ $roadmap->target_level }}
                </span>
                <span class="px-3 py-1 bg-white/10 text-slate-200 text-xs font-bold rounded-full">
                    ⏱️ Thời Lượng: {{ $roadmap->duration_weeks }} Tuần
                </span>
            </div>

            <h1 class="text-2xl sm:text-4xl font-black font-display tracking-tight text-white leading-tight">
                {{ $roadmap->title }}
            </h1>

            <p class="text-xs sm:text-sm text-slate-300 font-medium leading-relaxed">
                {{ $roadmap->description }}
            </p>
        </div>
    </div>

    <!-- Interactive Phase Milestones Vertical Stepper -->
    <div class="space-y-8">
        <div class="border-b border-slate-200 pb-4">
            <h2 class="text-xl sm:text-2xl font-black font-display text-slate-900">
                Chi Tiết Từng Giai Đoạn & Nhiệm Vụ Hàng Tuần
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 font-medium mt-1">
                Hoàn thành lần lượt các bài tập và phòng thi để mở khóa giai đoạn tiếp theo.
            </p>
        </div>

        <div class="space-y-6">
            @foreach($roadmap->phases as $index => $phase)
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-8 space-y-6 relative overflow-hidden" x-data="{ expanded: true }">
                
                <!-- Phase Title Header -->
                <div class="flex items-start sm:items-center justify-between gap-4 cursor-pointer select-none" @click="expanded = !expanded">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-rose-600 to-rose-700 text-white font-black font-display text-lg flex items-center justify-center shadow-glow flex-shrink-0">
                            {{ $phase->phase_number }}
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2.5 py-0.5 rounded-md bg-rose-50 text-rose-700 text-[11px] font-extrabold uppercase">{{ $phase->duration_text }}</span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-black font-display text-slate-900 mt-1">{{ $phase->title }}</h3>
                        </div>
                    </div>

                    <button type="button" class="p-2 rounded-xl text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition">
                        <i data-lucide="chevron-down" class="w-5 h-5 transition-transform" :class="{'rotate-180': expanded}"></i>
                    </button>
                </div>

                <!-- Phase Content -->
                <div x-show="expanded" x-collapse class="space-y-6 pt-4 border-t border-slate-100">
                    
                    <!-- Goal Description -->
                    <div class="p-4 bg-indigo-50/70 border border-indigo-100 rounded-2xl space-y-1">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-indigo-900 block">🎯 Mục Tiêu Đầu Ra Giai Đoạn Này:</span>
                        <p class="text-xs sm:text-sm text-slate-800 leading-relaxed font-medium">
                            {{ $phase->goal_description }}
                        </p>
                    </div>

                    <!-- Actionable Milestones / Tasks -->
                    <div class="space-y-3">
                        <span class="text-xs font-black uppercase tracking-wider text-slate-500 block">Nhiệm Vụ Thực Hành Cụ Thể:</span>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            @foreach($phase->milestones ?? [] as $milestone)
                            <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 hover:bg-white hover:shadow-md transition flex flex-col justify-between space-y-3">
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between text-[11px] font-bold">
                                        <span class="px-2 py-0.5 rounded bg-slate-200 text-slate-800 uppercase">{{ $milestone['type'] ?? 'Thực hành' }}</span>
                                        <span class="text-emerald-700 font-extrabold">{{ $milestone['reward'] ?? '+30 XP' }}</span>
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-sm leading-snug">{{ $milestone['title'] ?? '' }}</h4>
                                    <p class="text-xs text-slate-600 line-clamp-2">{{ $milestone['description'] ?? '' }}</p>
                                </div>

                                @if(!empty($milestone['action_url']))
                                <a href="{{ $milestone['action_url'] }}" class="w-full py-2.5 bg-slate-900 hover:bg-rose-600 text-white font-extrabold text-xs rounded-xl text-center block transition shadow-xs">
                                    {{ $milestone['action_text'] ?? 'Bắt Đầu Làm Ngay →' }}
                                </a>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
