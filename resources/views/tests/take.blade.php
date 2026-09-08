@extends('layouts.app')

@section('title', $test->title . ' - Phòng Luyện Đề Chuẩn Quốc Tế')

@section('content')
@php
    $partsParam = $parts ?? request()->query('parts');
    $selectedPartNums = $partsParam ? array_filter(array_map('intval', explode(',', (string)$partsParam))) : [];
    
    // Sort and filter sections based on user's selected parts
    $allSections = $test->sections->sortBy('section_number');
    if (!empty($selectedPartNums)) {
        $filteredSections = $allSections->filter(function($sec) use ($selectedPartNums) {
            $hasNum = in_array((int)$sec->section_number, $selectedPartNums);
            $hasMatchInTitle = preg_match('/(?:part|section|passage)\s*(\d+)/i', $sec->title, $m) && in_array((int)$m[1], $selectedPartNums);
            return $hasNum || $hasMatchInTitle;
        });
        $sections = $filteredSections->isNotEmpty() ? $filteredSections : $allSections;
    } else {
        $sections = $allSections;
    }

    // Flatten all questions within active sections
    $allQuestionsList = $sections->flatMap(function($sec) {
        return $sec->questionGroups->flatMap(function($grp) use ($sec) {
            return $grp->questions->map(function($q) use ($sec, $grp) {
                $q->section_id = $sec->id;
                $q->group_instruction = $grp->instruction;
                $q->group_type = $grp->question_type;
                return $q;
            });
        });
    })->sortBy('question_number')->values();

    $totalQuestionsDisplay = $allQuestionsList->count();
    $totalTestQuestions = $totalQuestionsDisplay > 0 ? $totalQuestionsDisplay : ($test->total_questions ?: 10);
    
    // Check if any section has a passage text
    $hasAnyPassage = $sections->some(fn($s) => !empty(trim(strip_tags($s->passage_text ?? ''))));
    $hasAnyAudio = $sections->some(fn($s) => !empty($s->audio_url));
    
    // Duration
    if ($mode === 'practice' && !empty($selectedPartNums)) {
        $durationMinutes = max(10, (int)ceil($totalTestQuestions * 1.8));
    } else {
        $durationMinutes = $test->duration_minutes ?: 60;
    }
    
    $isToeic = str_contains(strtolower($test->type ?? ''), 'toeic') || str_contains(strtolower($test->title ?? ''), 'toeic');
    $categoryLabel = $isToeic ? 'TOEIC ' . strtoupper($test->type) : 'IELTS ' . strtoupper($test->type);
@endphp

<div x-data="examRoom()" x-init="initRoom()" class="flex flex-col h-[calc(100vh-4.5rem)] sm:h-[calc(100vh-5rem)] overflow-hidden bg-slate-100 font-sans select-text">
    <!-- Top Fixed Exam Control Bar -->
    <header class="bg-white border-b border-slate-200 shadow-xs z-30 flex-shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5 flex items-center justify-between gap-2.5 sm:gap-4 relative w-full">
            <!-- Left: Back + Test Title & Badges -->
            <div class="flex items-center space-x-2.5 sm:space-x-3.5 min-w-0 max-w-[32%] lg:max-w-[36%] z-10">
                <button @click="exitTest()" class="p-1.5 sm:p-2 rounded-xl text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition flex-shrink-0 cursor-pointer" title="Thoát phòng thi">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </button>
                <div class="min-w-0">
                    <div class="flex items-center space-x-2 flex-wrap">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ $isToeic ? 'bg-amber-100 text-amber-900 border border-amber-200' : 'bg-rose-100 text-rose-900 border border-rose-200' }}">
                            {{ $categoryLabel }}
                        </span>
                        @if($mode === 'practice')
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-100 text-indigo-800 border border-indigo-200">
                            @if(!empty($selectedPartNums))
                                Luyện phần: {{ implode(', ', $selectedPartNums) }}
                            @else
                                Luyện tập tự do
                            @endif
                        </span>
                        @else
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-900 text-white">
                            Thi Thử Chuẩn ({{ $durationMinutes }}p)
                        </span>
                        @endif
                        <span class="text-xs font-semibold text-slate-400 hidden md:inline">•</span>
                        <span class="text-xs font-bold text-slate-500 hidden md:inline">{{ $totalTestQuestions }} câu hỏi</span>
                    </div>
                    <h1 class="text-xs sm:text-sm md:text-base font-bold font-display text-slate-900 truncate leading-tight mt-0.5" title="{{ $test->title }}">
                        {{ $test->title }}
                    </h1>
                </div>
            </div>

            <!-- Center Tools: Layout Switcher, Font Size, Quick Dictionary (Strictly Centered) -->
            <div class="hidden md:flex items-center space-x-2 absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 z-20">
                <!-- View Mode Switcher -->
                @if($hasAnyPassage)
                <div class="flex items-center bg-slate-100 p-0.5 rounded-xl border border-slate-200 text-xs font-bold">
                    <button type="button" 
                            @click="layoutMode = 'split'" 
                            :class="layoutMode === 'split' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800'"
                            class="px-2.5 py-1.5 rounded-lg transition flex items-center space-x-1.5 cursor-pointer" 
                            title="Chia đôi màn hình: Bài đọc & Câu hỏi song song">
                        <i data-lucide="columns-2" class="w-3.5 h-3.5"></i>
                        <span class="hidden lg:inline">Chia Đôi</span>
                    </button>
                    <button type="button" 
                            @click="layoutMode = 'single'" 
                            :class="layoutMode === 'single' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800'"
                            class="px-2.5 py-1.5 rounded-lg transition flex items-center space-x-1.5 cursor-pointer" 
                            title="Một cột rộng: Tập trung câu hỏi">
                        <i data-lucide="maximize-2" class="w-3.5 h-3.5"></i>
                        <span class="hidden lg:inline">Toàn Cột</span>
                    </button>
                </div>
                @endif

                <!-- Font Size Adjuster -->
                <div class="flex items-center bg-slate-100 p-0.5 rounded-xl border border-slate-200 text-xs font-bold">
                    <button @click="setFontSize('sm')" :class="fontSize === 'sm' ? 'bg-white text-slate-900 shadow-xs font-black' : 'text-slate-500'" class="px-2 py-1 rounded-lg transition text-[11px] cursor-pointer" title="Cỡ chữ nhỏ">A-</button>
                    <button @click="setFontSize('md')" :class="fontSize === 'md' ? 'bg-white text-slate-900 shadow-xs font-black' : 'text-slate-500'" class="px-2 py-1 rounded-lg transition text-[11px] cursor-pointer" title="Cỡ chữ vừa">A</button>
                    <button @click="setFontSize('lg')" :class="fontSize === 'lg' ? 'bg-white text-slate-900 shadow-xs font-black' : 'text-slate-500'" class="px-2 py-1 rounded-lg transition text-[11px] cursor-pointer" title="Cỡ chữ to">A+</button>
                </div>

                <!-- Quick Dictionary Trigger Button -->
                <button type="button" 
                        @click="openDictionary()" 
                        class="px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 text-xs font-bold transition flex items-center space-x-1.5 shadow-2xs group cursor-pointer">
                    <i data-lucide="book-open" class="w-3.5 h-3.5 text-indigo-600 group-hover:scale-110 transition-transform"></i>
                    <span>Tra từ điển</span>
                    <span class="text-[10px] bg-indigo-200/70 text-indigo-800 px-1.5 py-0.2 rounded font-mono font-bold hidden xl:inline">Ctrl+K</span>
                </button>
            </div>

            <!-- Right: Countdown Timer & Submit Exam Button -->
            <div class="flex items-center space-x-2 sm:space-x-3 ml-auto z-10">
                <!-- Mobile View Switcher Tab (Only on small screens when passage exists) -->
                @if($hasAnyPassage)
                <div class="flex md:hidden items-center bg-slate-100 p-0.5 rounded-xl border border-slate-200 text-xs font-bold">
                    <button @click="mobileTab = 'passage'" :class="mobileTab === 'passage' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500'" class="px-2.5 py-1 rounded-lg">
                        Bài đọc
                    </button>
                    <button @click="mobileTab = 'questions'" :class="mobileTab === 'questions' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500'" class="px-2.5 py-1 rounded-lg">
                        Câu hỏi
                    </button>
                </div>
                @endif

                <!-- Timer Badge -->
                <div class="flex items-center space-x-1.5 px-3 py-1.5 rounded-xl font-mono font-bold text-xs sm:text-sm shadow-2xs transition"
                     :class="remainingSeconds <= 300 ? 'bg-rose-600 text-white animate-pulse' : 'bg-slate-900 text-white'">
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-rose-400"></i>
                    <span x-text="formattedTime">--:--</span>
                    @if($mode === 'practice')
                    <button @click="toggleTimerPause()" class="ml-1 text-slate-400 hover:text-white p-0.5 rounded transition" :title="isTimerPaused ? 'Tiếp tục đếm giờ' : 'Tạm dừng'">
                        <i :data-lucide="isTimerPaused ? 'play' : 'pause'" class="w-3 h-3"></i>
                    </button>
                    @endif
                </div>

                <!-- Submit Button -->
                <button @click="openSubmitModal()" 
                        :disabled="isSubmitting" 
                        class="px-3.5 sm:px-5 py-1.5 sm:py-2 bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-700 hover:to-rose-800 disabled:opacity-50 text-white font-extrabold text-xs sm:text-sm rounded-xl shadow-glow transition flex items-center space-x-1.5 cursor-pointer">
                    <i data-lucide="send" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                    <span x-text="isSubmitting ? 'Đang nộp...' : 'Nộp Bài'"></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Part / Section Switcher Tabs -->
    @if($sections->count() > 1)
    <div class="bg-white border-b border-slate-200 z-20 flex-shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex items-center space-x-2 overflow-x-auto scrollbar-none">
            <span class="text-[11px] font-black uppercase tracking-wider text-slate-400 flex-shrink-0 mr-1 flex items-center">
                <i data-lucide="layers" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>
                Phần thi:
            </span>
            @foreach($sections as $sec)
            @php
                $secQuestions = $sec->questionGroups->flatMap(fn($g) => $g->questions);
                $secCount = $secQuestions->count();
                $secQNums = $secQuestions->pluck('question_number')->toArray();
                $firstQ = $secQuestions->first()?->question_number;
                $lastQ = $secQuestions->last()?->question_number;
            @endphp
            <button type="button" 
                    @click="switchSection({{ $sec->id }}, {{ $firstQ ?? 1 }})"
                    :class="activeSection === {{ $sec->id }} 
                        ? 'bg-slate-900 text-white shadow-sm ring-2 ring-slate-900/20' 
                        : 'bg-slate-100 hover:bg-slate-200 text-slate-700'"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition flex items-center space-x-2 flex-shrink-0">
                <span>{{ Str::limit($sec->title, 34) }}</span>
                @if($firstQ && $lastQ)
                <span class="text-[10px] px-1.5 py-0.5 rounded-md font-mono"
                      :class="activeSection === {{ $sec->id }} ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600'">
                    Câu {{ $firstQ }}-{{ $lastQ }}
                </span>
                @endif
                <!-- Section Progress Pill -->
                <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold"
                      :class="getSectionAnsweredCount(@json($secQNums)) === {{ $secCount }} 
                        ? 'bg-emerald-500 text-white' 
                        : (activeSection === {{ $sec->id }} ? 'bg-rose-500 text-white' : 'bg-slate-300 text-slate-700')">
                    <span x-text="getSectionAnsweredCount(@json($secQNums))">0</span>/{{ $secCount }}
                </span>
            </button>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Main Exam Workspace -->
    <div class="flex-1 flex overflow-hidden relative w-full bg-slate-200/50" id="exam-split-workspace">
        <div class="max-w-7xl mx-auto w-full h-full flex overflow-hidden bg-white border-x border-slate-200/80 shadow-xs">
        
        <!-- Left Panel: Reading Passage / Audio Player / Translation / Highlighting (When Split View Active) -->
        @if($hasAnyPassage || $hasAnyAudio)
        <div x-show="layoutMode === 'split' && (window.innerWidth >= 1024 || mobileTab === 'passage')"
             :class="{
                 'w-full lg:w-1/2 block': layoutMode === 'split',
                 'hidden': layoutMode === 'single'
             }" 
             class="h-full overflow-y-auto p-4 sm:p-7 md:p-9 bg-white border-r border-slate-200 transition-all duration-150 relative select-text" 
             id="passage-scroll-panel">
            
            <div class="max-w-3xl mx-auto space-y-6 pb-28">
                <!-- Sticky Passage Control Subheader -->
                <div class="sticky top-0 bg-white/95 backdrop-blur-md py-2.5 border-b border-slate-100 flex items-center justify-between z-10">
                    <div class="flex items-center space-x-2">
                        <span class="px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-200 text-[11px] font-black uppercase tracking-wider">
                            Văn bản bài thi
                        </span>
                        <span class="text-xs text-slate-400 font-semibold">• Chọn từ bất kỳ để tra nghĩa & nghe phát âm</span>
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <button type="button" @click="highlightSelected('yellow')" class="px-2 py-1 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded-lg text-[11px] font-bold transition flex items-center space-x-1" title="Đánh dấu highlight vàng">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span>
                            <span>Highlight</span>
                        </button>
                        <button type="button" @click="clearHighlights()" class="p-1 text-slate-400 hover:text-slate-600 rounded-lg transition" title="Xóa tất cả highlight">
                            <i data-lucide="eraser" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                </div>

                @foreach($sections as $section)
                <div class="space-y-6" x-show="activeSection === {{ $section->id }} || {{ $sections->count() }} === 1" id="section-passage-{{ $section->id }}">
                    <!-- Section Title & Meta -->
                    <div>
                        <span class="text-xs font-black text-rose-600 uppercase tracking-widest font-mono">
                            Section {{ $section->section_number }}
                        </span>
                        <h2 class="text-lg sm:text-2xl font-black font-display text-slate-900 tracking-tight mt-1 leading-snug">
                            {{ $section->title }}
                        </h2>
                    </div>

                    <!-- Audio Player (For Listening Sections) -->
                    @if($section->audio_url)
                    <div class="p-4 bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 text-white rounded-2xl shadow-lg border border-slate-800 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-xl bg-rose-600/30 border border-rose-500/40 flex items-center justify-center text-rose-300">
                                    <i data-lucide="headphones" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-white">Audio Bản Xứ Chất Lượng Cao (HQ)</p>
                                    <p class="text-[10px] text-slate-300">Nghe cẩn thận và trả lời các câu hỏi bên phải</p>
                                </div>
                            </div>
                            <!-- Playback Speed Control -->
                            <div class="flex items-center space-x-1 bg-white/10 p-1 rounded-xl text-[11px] font-mono font-bold">
                                <button type="button" @click="setAudioSpeed(0.8)" :class="playbackRate === 0.8 ? 'bg-rose-600 text-white' : 'text-slate-300 hover:text-white'" class="px-1.5 py-0.5 rounded-md">0.8x</button>
                                <button type="button" @click="setAudioSpeed(1.0)" :class="playbackRate === 1.0 ? 'bg-rose-600 text-white' : 'text-slate-300 hover:text-white'" class="px-1.5 py-0.5 rounded-md">1.0x</button>
                                <button type="button" @click="setAudioSpeed(1.25)" :class="playbackRate === 1.25 ? 'bg-rose-600 text-white' : 'text-slate-300 hover:text-white'" class="px-1.5 py-0.5 rounded-md">1.25x</button>
                            </div>
                        </div>
                        <audio x-ref="sectionAudio{{ $section->id }}" controls class="w-full rounded-xl bg-slate-900/60">
                            <source src="{{ $section->audio_url }}" type="audio/mpeg">
                            Trình duyệt của bạn không hỗ trợ phát audio.
                        </audio>
                    </div>
                    @endif

                    <!-- Reading Passage Content -->
                    @if(!empty(trim(strip_tags($section->passage_text ?? ''))))
                    <div class="passage-render-body text-slate-800 space-y-4 font-sans border-t border-slate-100 pt-4"
                         :class="{
                             'text-sm leading-relaxed': fontSize === 'sm',
                             'text-base leading-relaxed': fontSize === 'md',
                             'text-lg leading-loose': fontSize === 'lg'
                         }">
                        {!! $section->passage_text !!}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Right / Full Panel: Question Groups & Interactive Cards -->
        <div :class="{
                 'w-full lg:w-1/2': layoutMode === 'split' && {{ $hasAnyPassage || $hasAnyAudio ? 'true' : 'false' }},
                 'w-full max-w-5xl mx-auto': layoutMode === 'single' || !{{ $hasAnyPassage || $hasAnyAudio ? 'true' : 'false' }},
                 'hidden lg:block': mobileTab !== 'questions' && {{ $hasAnyPassage ? 'true' : 'false' }}
             }"
             class="h-full overflow-y-auto p-3 sm:p-6 md:p-8 bg-slate-50 relative" 
             id="questions-scroll-panel">
             
            <div class="max-w-3xl mx-auto space-y-6 pb-44">
                
                <!-- If in Single Column Mode and Section has a Passage, show a sleek toggleable summary bar -->
                @if($hasAnyPassage)
                <div x-show="layoutMode === 'single'" class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs mb-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 flex items-center justify-center">
                            <i data-lucide="book-open" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Đang ở chế độ xem Toàn Cột (Tập trung câu hỏi)</p>
                            <p class="text-[11px] text-slate-500">Muốn đọc văn bản song song bên trái, hãy bấm nút Chuyển Chia Đôi.</p>
                        </div>
                    </div>
                    <button type="button" @click="layoutMode = 'split'" class="px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition flex items-center space-x-1.5 shadow-2xs">
                        <i data-lucide="columns-2" class="w-3.5 h-3.5"></i>
                        <span>Mở Chia Đôi</span>
                    </button>
                </div>
                @endif

                <form id="exam-form" @submit.prevent="openSubmitModal()">
                    @foreach($sections as $section)
                        @foreach($section->questionGroups as $group)
                        <div class="space-y-5 mb-8" 
                             x-show="activeSection === {{ $section->id }} || {{ $sections->count() }} === 1" 
                             id="group-container-{{ $group->id }}">
                             
                            <!-- Group Instruction Card -->
                            <div class="bg-white rounded-2xl border-l-4 border-rose-600 p-4 sm:p-5 shadow-xs flex items-start space-x-3">
                                <div class="w-7 h-7 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i data-lucide="info" class="w-4 h-4"></i>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-rose-600 font-mono">
                                        Hướng Dẫn Làm Bài • {{ strtoupper(str_replace('_', ' ', $group->question_type)) }}
                                    </span>
                                    <p class="text-xs sm:text-sm font-semibold text-slate-800 leading-relaxed">
                                        {{ $group->instruction }}
                                    </p>
                                </div>
                            </div>

                            <!-- Questions in this group -->
                            <div class="space-y-4">
                                @foreach($group->questions as $q)
                                <div class="bg-white rounded-3xl p-5 sm:p-6 border transition-all duration-200 space-y-4 relative shadow-2xs hover:shadow-xs"
                                     :class="{
                                         'border-amber-400 bg-amber-50/20': flagged.includes({{ $q->question_number }}),
                                         'border-slate-200 hover:border-slate-300': !flagged.includes({{ $q->question_number }}),
                                         'ring-2 ring-rose-500/30': currentFocusQuestion === {{ $q->question_number }}
                                     }"
                                     id="question-box-{{ $q->question_number }}">
                                     
                                    <!-- Question Header: Number, Stem, Flag Action -->
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start space-x-3">
                                            <!-- Question Number Badge -->
                                            <span class="w-8 h-8 rounded-xl font-mono font-bold text-xs flex items-center justify-center flex-shrink-0 transition-colors shadow-2xs"
                                                  :class="answeredList.includes({{ $q->question_number }}) ? 'bg-rose-600 text-white' : 'bg-slate-900 text-white'">
                                                {{ $q->question_number }}
                                            </span>
                                            <!-- Question Stem -->
                                            <div class="space-y-1 pt-0.5">
                                                <p class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                                                    {{ $q->content }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Flag for Review Button -->
                                        <button type="button" 
                                                @click="toggleFlag({{ $q->question_number }})" 
                                                class="p-1.5 rounded-xl transition flex items-center space-x-1 flex-shrink-0"
                                                :class="flagged.includes({{ $q->question_number }}) ? 'bg-amber-100 text-amber-700 font-bold' : 'text-slate-400 hover:text-amber-500 hover:bg-slate-100'"
                                                title="Đánh dấu câu hỏi để xem lại sau">
                                            <i data-lucide="flag" class="w-4 h-4" :class="{'fill-amber-500 text-amber-500': flagged.includes({{ $q->question_number }})}"></i>
                                            <span class="text-[11px] hidden sm:inline" x-text="flagged.includes({{ $q->question_number }}) ? 'Đã ghim' : 'Ghim'"></span>
                                        </button>
                                    </div>

                                    <!-- Answer Input Controls -->
                                    <div class="sm:pl-11 pt-1">
                                        @if(in_array($group->question_type, ['multiple_choice_single', 'true_false_not_given', 'yes_no_not_given']))
                                            @php
                                                $rawOptions = $q->options ?: ($group->question_type === 'true_false_not_given' ? ['TRUE', 'FALSE', 'NOT GIVEN'] : ['YES', 'NO', 'NOT GIVEN']);
                                                $normalizedOptions = [];
                                                foreach($rawOptions as $k => $item) {
                                                    if (is_array($item)) {
                                                        $normalizedOptions[] = [
                                                            'key' => $item['key'] ?? (string)$k,
                                                            'text' => $item['text'] ?? $item['key'] ?? '',
                                                        ];
                                                    } else {
                                                        $normalizedOptions[] = [
                                                            'key' => (string)$item,
                                                            'text' => (string)$item,
                                                        ];
                                                    }
                                                }
                                            @endphp
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                                @foreach($normalizedOptions as $opt)
                                                <label class="flex items-center space-x-3 p-3.5 rounded-2xl border transition cursor-pointer select-none text-xs sm:text-sm font-semibold"
                                                       :class="answers[{{ $q->id }}] === '{{ $opt['key'] }}' 
                                                           ? 'border-rose-600 bg-rose-50/80 text-rose-950 font-bold shadow-xs ring-1 ring-rose-500/20' 
                                                           : 'border-slate-200 hover:border-rose-300 hover:bg-rose-50/30 bg-white text-slate-800'">
                                                    <input type="radio" 
                                                           name="question_{{ $q->id }}" 
                                                           value="{{ $opt['key'] }}" 
                                                           @change="setAnswer({{ $q->id }}, '{{ $opt['key'] }}', {{ $q->question_number }})"
                                                           class="sr-only">
                                                    
                                                    <!-- Custom Radio Indicator Pill -->
                                                    <span class="w-6 h-6 rounded-lg font-mono text-xs font-bold flex items-center justify-center flex-shrink-0 transition-all"
                                                          :class="answers[{{ $q->id }}] === '{{ $opt['key'] }}' 
                                                              ? 'bg-rose-600 text-white shadow-xs' 
                                                              : 'bg-slate-100 text-slate-600 border border-slate-200'">
                                                        {{ $opt['key'] }}
                                                    </span>
                                                    <span class="flex-1 leading-snug">{{ $opt['text'] }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        @else
                                            <!-- Fill in the Blank Input -->
                                            <div class="max-w-md">
                                                <div class="relative">
                                                    <input type="text" 
                                                           @input="setAnswer({{ $q->id }}, $event.target.value, {{ $q->question_number }})"
                                                           placeholder="Nhập câu trả lời của bạn vào đây..." 
                                                           class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:border-rose-500 focus:ring-3 focus:ring-rose-500/15 text-sm font-semibold text-slate-900 bg-white shadow-2xs transition">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </form>
            </div>
        </div>
        </div>
    </div>

    <!-- Enhanced Bottom Question Matrix Dock -->
    <div class="bg-white/95 backdrop-blur-md border-t border-slate-200 px-4 sm:px-6 lg:px-8 py-2.5 fixed bottom-0 left-0 right-0 z-30 shadow-xl transition-all duration-300"
         :class="matrixExpanded ? 'max-h-96' : 'max-h-24'">
        <div class="max-w-7xl mx-auto space-y-2">
            <!-- Matrix Header & Stats Toolbar -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 sm:space-x-3 overflow-x-auto">
                    <span class="text-xs font-black font-display uppercase tracking-wider text-slate-600 flex items-center space-x-1 flex-shrink-0">
                        <i data-lucide="layout-grid" class="w-3.5 h-3.5 text-rose-600"></i>
                        <span class="hidden sm:inline">Ma Trận Câu Hỏi</span>
                    </span>
                    
                    <!-- Done Count -->
                    <span class="text-[11px] sm:text-xs font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded-full flex-shrink-0">
                        Đã làm: <strong class="font-extrabold" x-text="answeredCount">0</strong>/{{ $totalTestQuestions }}
                    </span>

                    <!-- Remaining Count -->
                    <span class="text-[11px] sm:text-xs font-bold text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-0.5 rounded-full hidden sm:inline flex-shrink-0">
                        Chưa làm: <strong class="font-extrabold" x-text="totalTestQuestions - answeredCount">0</strong>
                    </span>

                    <!-- Flagged Count -->
                    <span x-show="flagged.length > 0" class="text-[11px] sm:text-xs font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-0.5 rounded-full flex-shrink-0">
                        Ghim: <strong class="font-extrabold" x-text="flagged.length">0</strong>
                    </span>
                </div>

                <!-- Matrix Quick Filters & Expand Toggle -->
                <div class="flex items-center space-x-2">
                    <!-- Filter Chips -->
                    <div class="hidden md:flex items-center space-x-1 bg-slate-100 p-0.5 rounded-xl border border-slate-200 text-[11px] font-bold">
                        <button type="button" @click="matrixFilter = 'all'" :class="matrixFilter === 'all' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900'" class="px-2 py-0.5 rounded-lg transition">Tất cả</button>
                        <button type="button" @click="matrixFilter = 'unanswered'" :class="matrixFilter === 'unanswered' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900'" class="px-2 py-0.5 rounded-lg transition">Chưa làm</button>
                        <button type="button" @click="matrixFilter = 'flagged'" :class="matrixFilter === 'flagged' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900'" class="px-2 py-0.5 rounded-lg transition">Đã ghim</button>
                    </div>

                    <!-- Expand / Collapse Button -->
                    <button type="button" @click="matrixExpanded = !matrixExpanded" class="p-1 sm:px-2.5 sm:py-1 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center space-x-1">
                        <span class="hidden sm:inline" x-text="matrixExpanded ? 'Thu gọn' : 'Mở rộng'"></span>
                        <i data-lucide="chevron-up" class="w-4 h-4 transition transform duration-200" :class="{'rotate-180': matrixExpanded}"></i>
                    </button>
                </div>
            </div>

            <!-- Matrix Number Badges Grid -->
            <div class="flex flex-wrap gap-1.5 sm:gap-2 overflow-y-auto py-1"
                 :class="matrixExpanded ? 'max-h-72' : 'max-h-12'">
                <template x-for="q in filteredMatrixQuestions" :key="q.number">
                    <button type="button" 
                            @click="scrollToQuestion(q.number, q.section_id)"
                            :class="{
                                'bg-rose-600 text-white font-extrabold shadow-2xs': answeredList.includes(q.number) && !flagged.includes(q.number),
                                'bg-amber-400 text-amber-950 font-black ring-2 ring-amber-500/40': flagged.includes(q.number),
                                'bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200': !answeredList.includes(q.number) && !flagged.includes(q.number)
                            }"
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl text-xs font-mono font-bold flex items-center justify-center transition flex-shrink-0 relative group cursor-pointer hover:scale-105">
                        <span x-text="q.number"></span>
                        <!-- Small Flag Dot Indicator if both answered and flagged -->
                        <span x-show="answeredList.includes(q.number) && flagged.includes(q.number)" class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-rose-600 rounded-full border-2 border-white"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- Exam Submission Confirmation Modal -->
    <div x-show="submitModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all animate-pop" 
             @click.outside="submitModalOpen = false">
             
            <!-- Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-900 to-slate-800 text-white">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-2xl bg-rose-600 flex items-center justify-center text-white shadow-glow">
                        <i data-lucide="help-circle" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black font-display text-white leading-tight">Xác Nhận Nộp Bài Thi</h3>
                        <p class="text-[11px] text-slate-300">Vui lòng rà soát lại trước khi kết thúc bài làm</p>
                    </div>
                </div>
                <button @click="submitModalOpen = false" class="p-1.5 rounded-xl text-slate-400 hover:text-white hover:bg-white/10 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Content Body -->
            <div class="p-6 space-y-5">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-3">
                        <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Đã hoàn thành</span>
                        <p class="text-2xl font-black text-emerald-800 mt-0.5" x-text="answeredCount">0</p>
                    </div>
                    <div class="bg-rose-50 border border-rose-200 rounded-2xl p-3">
                        <span class="text-[10px] font-bold text-rose-700 uppercase tracking-wider">Chưa trả lời</span>
                        <p class="text-2xl font-black text-rose-800 mt-0.5" x-text="totalTestQuestions - answeredCount">0</p>
                    </div>
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-3">
                        <span class="text-[10px] font-bold text-amber-700 uppercase tracking-wider">Đã gắn cờ</span>
                        <p class="text-2xl font-black text-amber-800 mt-0.5" x-text="flagged.length">0</p>
                    </div>
                </div>

                <!-- Unanswered Warning & Jump Pills -->
                <template x-if="unansweredQuestions.length > 0">
                    <div class="p-4 bg-rose-50/80 rounded-2xl border border-rose-200 space-y-2.5">
                        <div class="flex items-center space-x-2 text-rose-800 font-bold text-xs">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
                            <span>Bạn vẫn còn <span x-text="unansweredQuestions.length"></span> câu chưa chọn đáp án:</span>
                        </div>
                        <div class="flex flex-wrap gap-1.5 max-h-24 overflow-y-auto pr-1">
                            <template x-for="q in unansweredQuestions" :key="q.number">
                                <button type="button" 
                                        @click="submitModalOpen = false; scrollToQuestion(q.number, q.section_id)"
                                        class="w-7 h-7 rounded-lg bg-white border border-rose-300 text-rose-700 hover:bg-rose-600 hover:text-white font-mono text-xs font-bold transition flex items-center justify-center">
                                    <span x-text="q.number"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="unansweredQuestions.length === 0">
                    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 flex items-center space-x-3 text-emerald-800 text-xs font-bold">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 flex-shrink-0"></i>
                        <span>Tuyệt vời! Bạn đã trả lời đầy đủ tất cả câu hỏi trong bài thi.</span>
                    </div>
                </template>

                <p class="text-xs text-slate-500 text-center">
                    Sau khi nộp bài, hệ thống sẽ tự động chấm điểm chi tiết và hiển thị phân tích tư duy Linearthinking.
                </p>
            </div>

            <!-- Footer Action Buttons -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end space-x-3">
                <button type="button" 
                        @click="submitModalOpen = false" 
                        class="px-4 py-2 rounded-xl text-slate-700 hover:bg-slate-200 text-xs font-bold transition">
                    Làm tiếp bài
                </button>
                <button type="button" 
                        @click="submitExam()" 
                        :disabled="isSubmitting"
                        class="px-5 py-2 rounded-xl bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-700 hover:to-rose-800 disabled:opacity-50 text-white text-xs font-extrabold transition shadow-glow flex items-center space-x-1.5">
                    <span x-text="isSubmitting ? 'Đang chấm điểm...' : 'Xác nhận nộp bài'"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function examRoom() {
    return {
        testId: {{ $test->id }},
        activeSection: {{ $sections->first()?->id ?? 'null' }},
        totalTestQuestions: {{ $totalTestQuestions }},
        durationMinutes: {{ $durationMinutes }},
        remainingSeconds: {{ $durationMinutes * 60 }},
        mode: '{{ $mode }}',
        parts: '{{ $partsParam ?? '' }}',
        isSubmitting: false,
        submitModalOpen: false,
        timerInterval: null,
        isTimerPaused: false,

        // Layout & UI
        layoutMode: '{{ $hasAnyPassage ? "split" : "single" }}',
        fontSize: 'md',
        mobileTab: 'questions',
        playbackRate: 1.0,

        // Question matrix & answers
        answers: {},
        flagged: [],
        answeredList: [],
        matrixFilter: 'all',
        matrixExpanded: false,
        currentFocusQuestion: null,

        // Full questions array for reactive operations
        questions: @json($allQuestionsList->map(fn($q) => [
            'id' => $q->id,
            'number' => $q->question_number,
            'section_id' => $q->section_id
        ])),

        get formattedTime() {
            const m = Math.floor(this.remainingSeconds / 60);
            const s = this.remainingSeconds % 60;
            return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        },

        get answeredCount() {
            return this.answeredList.length;
        },

        get unansweredQuestions() {
            return this.questions.filter(q => !this.answeredList.includes(q.number));
        },

        get filteredMatrixQuestions() {
            if (this.matrixFilter === 'unanswered') {
                return this.questions.filter(q => !this.answeredList.includes(q.number));
            }
            if (this.matrixFilter === 'flagged') {
                return this.questions.filter(q => this.flagged.includes(q.number));
            }
            return this.questions;
        },

        initRoom() {
            this.initTimer();
            this.$nextTick(() => {
                if (window.lucide) window.lucide.createIcons();
            });
        },

        initTimer() {
            this.timerInterval = setInterval(() => {
                if (this.isTimerPaused) return;

                if (this.remainingSeconds > 0) {
                    this.remainingSeconds--;
                } else {
                    clearInterval(this.timerInterval);
                    alert('Hết giờ làm bài! Hệ thống đang tự động nộp bài thi của bạn.');
                    this.submitExam();
                }
            }, 1000);
        },

        toggleTimerPause() {
            this.isTimerPaused = !this.isTimerPaused;
        },

        setFontSize(size) {
            this.fontSize = size;
        },

        openDictionary() {
            window.dispatchEvent(new CustomEvent('open-quick-dict'));
        },

        switchSection(secId, firstQNum) {
            this.activeSection = secId;
            this.scrollToQuestion(firstQNum, secId);
        },

        getSectionAnsweredCount(qNums) {
            if (!Array.isArray(qNums)) return 0;
            return qNums.filter(n => this.answeredList.includes(n)).length;
        },

        setAnswer(qId, val, qNum) {
            if (val && String(val).trim()) {
                this.answers[qId] = String(val).trim();
                if (!this.answeredList.includes(qNum)) {
                    this.answeredList.push(qNum);
                }
            } else {
                delete this.answers[qId];
                this.answeredList = this.answeredList.filter(n => n !== qNum);
            }
        },

        toggleFlag(qNum) {
            if (this.flagged.includes(qNum)) {
                this.flagged = this.flagged.filter(n => n !== qNum);
            } else {
                this.flagged.push(qNum);
            }
        },

        scrollToQuestion(qNum, sectionId = null) {
            if (sectionId && this.activeSection !== sectionId) {
                this.activeSection = sectionId;
            }
            this.mobileTab = 'questions';
            this.currentFocusQuestion = qNum;

            this.$nextTick(() => {
                const el = document.getElementById(`question-box-${qNum}`);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        this.currentFocusQuestion = null;
                    }, 1800);
                }
            });
        },

        setAudioSpeed(rate) {
            this.playbackRate = rate;
            const audios = document.querySelectorAll('audio');
            audios.forEach(a => a.playbackRate = rate);
        },

        highlightSelected(color = 'yellow') {
            const selection = window.getSelection();
            if (!selection || selection.rangeCount === 0 || selection.toString().trim() === '') return;
            const range = selection.getRangeAt(0);
            const span = document.createElement('mark');
            span.style.backgroundColor = color === 'yellow' ? '#fef08a' : '#bbf7d0';
            span.style.borderRadius = '4px';
            span.style.padding = '1px 3px';
            try {
                range.surroundContents(span);
            } catch (e) {}
            selection.removeAllRanges();
        },

        clearHighlights() {
            const marks = document.querySelectorAll('#passage-scroll-panel mark');
            marks.forEach(m => {
                const parent = m.parentNode;
                while (m.firstChild) parent.insertBefore(m.firstChild, m);
                parent.removeChild(m);
            });
        },

        exitTest() {
            if (this.answeredCount > 0) {
                if (!confirm('Bạn có chắc chắn muốn thoát? Bài làm hiện tại chưa nộp sẽ không được lưu.')) {
                    return;
                }
            }
            window.location.href = "{{ route('ielts.index') }}";
        },

        openSubmitModal() {
            this.submitModalOpen = true;
            this.$nextTick(() => {
                if (window.lucide) window.lucide.createIcons();
            });
        },

        async submitExam() {
            if (this.isSubmitting) return;
            this.isSubmitting = true;
            clearInterval(this.timerInterval);

            const timeSpent = (this.durationMinutes * 60) - this.remainingSeconds;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                const res = await fetch("{{ route('ielts.submit', $test->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        mode: this.mode,
                        time_spent_seconds: timeSpent,
                        answers: this.answers
                    })
                });

                const data = await res.json();
                if (data.success && data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else if (data.success && data.submission_id) {
                    window.location.href = `/luyen-thi-ielts/result/${data.submission_id}`;
                } else {
                    alert(data.message || 'Lỗi khi nộp bài thi.');
                    this.isSubmitting = false;
                }
            } catch (err) {
                alert('Có lỗi kết nối khi nộp bài thi. Vui lòng kiểm tra lại đường truyền mạng.');
                this.isSubmitting = false;
            }
        }
    };
}
</script>
@endpush
