@extends('layouts.app')

@section('title', $test->title . ' - Phòng Thi Trực Tuyến')

@section('content')
@php
    $actualTotalQuestions = $test->sections->flatMap(fn($s) => $s->questionGroups->flatMap(fn($g) => $g->questions))->count();
    $totalQuestionsDisplay = $actualTotalQuestions > 0 ? $actualTotalQuestions : $test->total_questions;
@endphp

<div x-data="examRoom()" x-init="initTimer()" class="flex flex-col h-[calc(100vh-4rem)] sm:h-[calc(100vh-5rem)] overflow-hidden bg-slate-100 font-sans">
    <!-- Top Fixed Exam Control Bar -->
    <div class="bg-white border-b border-slate-200 px-4 sm:px-6 py-2.5 sm:py-3 flex flex-wrap items-center justify-between gap-3 shadow-xs z-30 flex-shrink-0">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <a href="{{ route('ielts.index') }}" class="p-1.5 sm:p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition" title="Thoát phòng thi">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-sm sm:text-base font-bold font-display text-slate-900 leading-tight">{{ $test->title }}</h1>
                <div class="flex items-center space-x-2 text-[11px] sm:text-xs font-semibold text-slate-500">
                    <span class="text-rose-600 uppercase font-extrabold">{{ $test->type }}</span>
                    <span>•</span>
                    <span>{{ $totalQuestionsDisplay }} Câu hỏi</span>
                    <span class="hidden sm:inline">•</span>
                    <span class="hidden sm:inline text-indigo-600 font-bold">{{ $mode === 'practice' ? 'Luyện Tập' : 'Thi Thử 60p' }}</span>
                </div>
            </div>
        </div>

        <!-- Mobile Tab Switcher (Visible only on < lg) -->
        <div class="flex lg:hidden items-center bg-slate-100 p-1 rounded-xl text-xs font-bold w-full sm:w-auto order-3 sm:order-2 justify-center">
            <button @click="mobileTab = 'passage'" 
                    :class="mobileTab === 'passage' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500'" 
                    class="flex-1 sm:flex-none px-4 py-1.5 rounded-lg transition flex items-center justify-center space-x-1.5">
                <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                <span>Bài Đọc</span>
            </button>
            <button @click="mobileTab = 'questions'" 
                    :class="mobileTab === 'questions' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500'" 
                    class="flex-1 sm:flex-none px-4 py-1.5 rounded-lg transition flex items-center justify-center space-x-1.5">
                <i data-lucide="help-circle" class="w-3.5 h-3.5"></i>
                <span>Câu Hỏi</span>
            </button>
        </div>

        <!-- Timer & Submit Actions -->
        <div class="flex items-center space-x-3 sm:space-x-4 order-2 sm:order-3">
            <!-- Countdown Clock -->
            <div class="flex items-center space-x-1.5 sm:space-x-2 px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl bg-slate-900 text-white font-mono font-bold text-sm sm:text-base shadow-sm">
                <i data-lucide="clock" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rose-400"></i>
                <span x-text="formattedTime">60:00</span>
            </div>

            <!-- Submit Button -->
            <button @click="confirmSubmit()" :disabled="isSubmitting" class="px-4 py-1.5 sm:px-5 sm:py-2 bg-rose-600 hover:bg-rose-700 disabled:bg-rose-400 text-white font-extrabold text-xs sm:text-sm rounded-xl shadow-glow transition flex items-center space-x-1.5">
                <i data-lucide="send" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                <span x-text="isSubmitting ? 'Đang Nộp...' : 'Nộp Bài'"></span>
            </button>
        </div>
    </div>

    <!-- Section Tabs Bar (If test has multiple sections) -->
    @if($test->sections->count() > 1)
    <div class="bg-white border-b border-slate-200 px-4 sm:px-6 py-2 flex items-center space-x-2 overflow-x-auto z-20 flex-shrink-0">
        <span class="text-xs font-bold text-slate-400 uppercase mr-2 flex-shrink-0">Phần thi:</span>
        @foreach($test->sections as $index => $sec)
        @php
            $secQCount = $sec->questionGroups->flatMap(fn($g) => $g->questions)->count();
            $firstQ = $sec->questionGroups->flatMap(fn($g) => $g->questions)->first()?->question_number;
            $lastQ = $sec->questionGroups->flatMap(fn($g) => $g->questions)->last()?->question_number;
        @endphp
        <button type="button" 
                @click="activeSection = {{ $sec->id }}; scrollToQuestion({{ $firstQ ?? 1 }})"
                :class="activeSection === {{ $sec->id }} ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 flex-shrink-0">
            <span>{{ Str::limit($sec->title, 28) }}</span>
            @if($firstQ && $lastQ)
            <span class="text-[10px] px-1.5 py-0.5 rounded-md font-mono" :class="activeSection === {{ $sec->id }} ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600'">
                Câu {{ $firstQ }}-{{ $lastQ }}
            </span>
            @endif
        </button>
        @endforeach
    </div>
    @endif

    <!-- Main Workspace -->
    <div class="flex-1 flex overflow-hidden relative" id="split-container">
        <!-- Left Panel: Reading Passage / Audio Player -->
        <div :class="{'hidden lg:block': mobileTab !== 'passage'}" 
             class="h-full overflow-y-auto p-4 sm:p-8 bg-white border-r border-slate-200 transition-all duration-75 w-full lg:w-1/2" id="left-panel">
            <div class="max-w-3xl mx-auto space-y-8">
                @foreach($test->sections as $section)
                <div class="space-y-5" x-show="activeSection === {{ $section->id }} || {{ $test->sections->count() }} === 1">
                    <div class="border-b border-slate-200 pb-3">
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-[11px] font-black uppercase tracking-wider">
                                Section {{ $section->section_number }}
                            </span>
                        </div>
                        <h2 class="text-base sm:text-xl font-black font-display text-slate-900 mt-2">{{ $section->title }}</h2>
                    </div>

                    @if($section->audio_url)
                    <div class="p-4 bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-2xl shadow-md space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i data-lucide="headphones" class="w-4 h-4 text-rose-400"></i>
                                <span class="text-xs font-bold">Audio Luyện Nghe Bản Xứ (Standard Audio Track)</span>
                            </div>
                            <span class="text-[11px] font-bold text-slate-300 bg-white/10 px-2 py-0.5 rounded-md">HQ Audio</span>
                        </div>
                        <audio controls class="w-full rounded-xl">
                            <source src="{{ $section->audio_url }}" type="audio/mpeg">
                            Trình duyệt của bạn không hỗ trợ phát audio.
                        </audio>
                    </div>
                    @endif

                    <div class="passage-content text-slate-800 leading-relaxed space-y-4 selection:bg-rose-200 font-sans text-sm sm:text-base">
                        {!! $section->passage_text !!}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Panel: Questions Form -->
        <div :class="{'hidden lg:block': mobileTab !== 'questions'}" 
             class="h-full overflow-y-auto p-4 sm:p-8 bg-slate-50 w-full lg:w-1/2" id="right-panel">
            <div class="max-w-2xl mx-auto space-y-8 pb-32">
                <form id="exam-form" @submit.prevent="submitExam">
                    @foreach($test->sections as $section)
                        @foreach($section->questionGroups as $group)
                        <div class="bg-white rounded-3xl p-5 sm:p-7 border border-slate-200 shadow-card space-y-6 mb-8" id="sec-group-{{ $section->id }}">
                            <!-- Group Instruction -->
                            <div class="bg-rose-50/80 border-l-4 border-rose-500 p-4 rounded-r-2xl">
                                <h3 class="font-bold text-xs uppercase tracking-wider text-rose-700">Hướng Dẫn Làm Bài</h3>
                                <p class="text-sm font-semibold text-slate-800 mt-1">{{ $group->instruction }}</p>
                            </div>

                            <!-- Questions List -->
                            <div class="space-y-6">
                                @foreach($group->questions as $q)
                                <div class="space-y-3 pt-4 border-t border-slate-100" id="question-box-{{ $q->question_number }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-3">
                                            <span class="w-7 h-7 rounded-xl bg-slate-900 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5 shadow-xs">
                                                {{ $q->question_number }}
                                            </span>
                                            <p class="text-sm font-semibold text-slate-800 leading-relaxed">{{ $q->content }}</p>
                                        </div>
                                        <button type="button" @click="toggleFlag({{ $q->question_number }})" class="text-slate-400 hover:text-amber-500 p-1 transition" :class="{'text-amber-500': flagged.includes({{ $q->question_number }})}" title="Đánh dấu xem lại">
                                            <i data-lucide="flag" class="w-4 h-4"></i>
                                        </button>
                                    </div>

                                    <!-- Answer Input Controls -->
                                    <div class="pl-10">
                                        @if(in_array($group->question_type, ['multiple_choice_single', 'true_false_not_given', 'yes_no_not_given']))
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                                @php
                                                    $rawOptions = $q->options ?: ['TRUE', 'FALSE', 'NOT GIVEN'];
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
                                                @foreach($normalizedOptions as $opt)
                                                <label class="flex items-center space-x-3 p-3.5 rounded-2xl border border-slate-200 hover:border-rose-400 hover:bg-rose-50/60 cursor-pointer transition select-none text-xs font-semibold"
                                                       :class="answers[{{ $q->id }}] === '{{ $opt['key'] }}' ? 'border-rose-600 bg-rose-50/90 text-rose-950 font-bold shadow-xs' : 'text-slate-800'">
                                                    <input type="radio" 
                                                           name="question_{{ $q->id }}" 
                                                           value="{{ $opt['key'] }}" 
                                                           @change="setAnswer({{ $q->id }}, '{{ $opt['key'] }}', {{ $q->question_number }})"
                                                           class="text-rose-600 focus:ring-rose-500 h-4 w-4">
                                                    <span>{{ $opt['text'] }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="max-w-md">
                                                <input type="text" 
                                                       @input="setAnswer({{ $q->id }}, $event.target.value, {{ $q->question_number }})"
                                                       placeholder="Nhập từ cần điền vào ô trống..." 
                                                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-rose-500 text-sm font-semibold text-slate-800">
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

    <!-- Bottom Question Matrix Bar -->
    <div class="bg-white/95 backdrop-blur-md border-t border-slate-200 px-4 sm:px-6 py-3 fixed bottom-0 left-0 right-0 z-30 shadow-lg" x-data="{ matrixExpanded: false }">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="text-xs font-black font-display uppercase tracking-wider text-slate-500 hidden sm:inline">Ma Trận Câu Hỏi</span>
                    <span class="text-xs font-extrabold text-rose-600 bg-rose-50 px-2.5 py-0.5 rounded-full" x-text="`Đã làm: ${answeredCount}/${totalQuestions}`"></span>
                </div>
                <button @click="matrixExpanded = !matrixExpanded" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center space-x-1 sm:hidden">
                    <span x-text="matrixExpanded ? 'Thu gọn' : 'Xem ma trận'"></span>
                    <i data-lucide="chevron-up" class="w-4 h-4 transition transform" :class="{'rotate-180': matrixExpanded}"></i>
                </button>
            </div>

            <!-- Matrix Number Grid -->
            <div :class="{'hidden sm:flex': !matrixExpanded, 'flex': matrixExpanded}" 
                 class="flex-wrap gap-1.5 sm:gap-2 mt-2 max-h-24 sm:max-h-16 overflow-y-auto py-1">
                @foreach($test->sections as $sec)
                    @foreach($sec->questionGroups as $grp)
                        @foreach($grp->questions as $qst)
                        <button @click="scrollToQuestion({{ $qst->question_number }})"
                                :class="{
                                    'bg-rose-600 text-white font-bold': answeredList.includes({{ $qst->question_number }}),
                                    'bg-amber-400 text-white font-bold': flagged.includes({{ $qst->question_number }}),
                                    'bg-slate-100 text-slate-700 hover:bg-slate-200': !answeredList.includes({{ $qst->question_number }}) && !flagged.includes({{ $qst->question_number }})
                                }"
                                class="w-8 h-8 rounded-lg text-xs font-bold flex items-center justify-center transition flex-shrink-0">
                            {{ $qst->question_number }}
                        </button>
                        @endforeach
                    @endforeach
                @endforeach
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
        activeSection: {{ $test->sections->first()?->id ?? 'null' }},
        totalQuestions: {{ $totalQuestionsDisplay }},
        durationMinutes: {{ $test->duration_minutes }},
        mode: '{{ $mode }}',
        remainingSeconds: {{ $test->duration_minutes * 60 }},
        timerInterval: null,
        mobileTab: 'questions',
        answers: {},
        flagged: [],
        answeredList: [],
        isSubmitting: false,

        get formattedTime() {
            const m = Math.floor(this.remainingSeconds / 60);
            const s = this.remainingSeconds % 60;
            return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        },

        get answeredCount() {
            return this.answeredList.length;
        },

        initTimer() {
            this.timerInterval = setInterval(() => {
                if (this.remainingSeconds > 0) {
                    this.remainingSeconds--;
                } else {
                    clearInterval(this.timerInterval);
                    alert('Hết giờ làm bài! Hệ thống đang tự động nộp bài.');
                    this.submitExam();
                }
            }, 1000);
        },

        setAnswer(qId, val, qNum) {
            if (val && val.trim()) {
                this.answers[qId] = val.trim();
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

        scrollToQuestion(qNum) {
            this.mobileTab = 'questions';
            const el = document.getElementById(`question-box-${qNum}`);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        },

        confirmSubmit() {
            const unanswered = this.totalQuestions - this.answeredCount;
            let msg = 'Bạn có chắc chắn muốn nộp bài thi?';
            if (unanswered > 0) {
                msg = `Bạn còn ${unanswered} câu chưa làm. Bạn vẫn muốn nộp bài chứ?`;
            }
            if (confirm(msg)) {
                this.submitExam();
            }
        },

        async submitExam() {
            if (this.isSubmitting) return;
            this.isSubmitting = true;
            clearInterval(this.timerInterval);

            const timeSpent = (this.durationMinutes * 60) - this.remainingSeconds;

            try {
                const res = await fetch(`/api/luyen-thi-ielts/submit/${this.testId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        mode: this.mode,
                        time_spent_seconds: timeSpent,
                        answers: this.answers
                    })
                });

                const data = await res.json();
                if (data.success) {
                    window.location.href = `/luyen-thi-ielts/result/${data.submission_id}`;
                } else {
                    alert(data.message || 'Lỗi khi nộp bài.');
                    this.isSubmitting = false;
                }
            } catch (err) {
                alert('Có lỗi xảy ra khi nộp bài thi.');
                this.isSubmitting = false;
            }
        }
    };
}
</script>
@endpush
