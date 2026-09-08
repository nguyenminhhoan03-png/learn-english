@extends('layouts.app')

@section('title', 'Kết Quả Bài Thi - ' . $submission->test->title)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Top Score Overview Card -->
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-950 text-white rounded-3xl p-8 shadow-2xl border border-slate-800 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-rose-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
            <div class="md:col-span-8 space-y-4">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-rose-500/20 border border-rose-500/40 text-rose-300 text-xs font-bold uppercase tracking-wider">
                    <span>Kết Quả Đã Chấm Điểm</span>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight">{{ $submission->test->title }}</h1>
                <p class="text-sm text-slate-300">
                    Thời gian làm bài: <span class="font-bold text-white">{{ gmdate("i:s", $submission->time_spent_seconds) }}</span> • 
                    Nộp lúc: {{ $submission->created_at->format('H:i - d/m/Y') }}
                </p>
                <div class="flex items-center space-x-3 pt-2">
                    <a href="{{ route('ielts.take', $submission->test->slug) }}" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-extrabold transition shadow-glow flex items-center space-x-1.5">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        <span>Làm lại đề này</span>
                    </a>
                    @if($submission->test->testSet)
                    <a href="{{ route('ielts.show_set', $submission->test->testSet->slug) }}" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition flex items-center space-x-1.5">
                        <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                        <span>Chọn phần luyện khác</span>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Score Badge (IELTS or TOEIC) -->
            @php
                $isToeic = str_contains(strtolower($submission->test->type ?? ''), 'toeic') || str_contains(strtolower($submission->test->title ?? ''), 'toeic');
                $totalQ = $submission->test->total_questions ?: 10;
            @endphp
            <div class="md:col-span-4 flex flex-col items-center justify-center p-6 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10 text-center">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-300">
                    {{ $isToeic ? 'TOEIC ESTIMATED SCORE' : 'IELTS BAND SCORE' }}
                </span>
                <span class="text-5xl font-black text-rose-400 my-1">
                    @if($isToeic)
                        {{ round(($submission->score_raw / max(1, $totalQ)) * 495) }}
                        <span class="text-xs text-slate-300 font-bold block mt-0.5">/ 495 điểm</span>
                    @else
                        {{ number_format($submission->band_score, 1) }}
                    @endif
                </span>
                <span class="text-xs font-semibold text-emerald-400 bg-emerald-950/60 px-3 py-1 rounded-full mt-1">
                    Đúng {{ $submission->score_raw }}/{{ $totalQ }} câu ({{ round(($submission->score_raw / max(1, $totalQ)) * 100) }}%)
                </span>
            </div>
        </div>
    </div>

    <!-- Answers & Linearthinking Explanation List -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Chi Tiết Từng Câu & Lời Giải Linearthinking</h2>
            <div class="flex items-center space-x-4 text-xs font-bold">
                <span class="flex items-center space-x-1.5 text-emerald-600"><span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span> <span>Chính xác</span></span>
                <span class="flex items-center space-x-1.5 text-rose-600"><span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span> <span>Chưa đúng</span></span>
            </div>
        </div>

        <div class="space-y-6">
            @foreach($submission->answers as $ans)
            @php $q = $ans->question; @endphp
            <div class="bg-white rounded-2xl border {{ $ans->is_correct ? 'border-emerald-200' : 'border-rose-200' }} p-6 shadow-xs space-y-5">
                <!-- Question Header -->
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <span class="w-7 h-7 rounded-lg {{ $ans->is_correct ? 'bg-emerald-600' : 'bg-rose-600' }} text-white font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                            {{ $q->question_number }}
                        </span>
                        <div>
                            <p class="text-base font-bold text-slate-900">{{ $q->content }}</p>
                            <div class="flex flex-wrap gap-4 text-xs font-semibold mt-2">
                                <span class="text-slate-600">Câu trả lời của bạn: <strong class="{{ $ans->is_correct ? 'text-emerald-700 font-bold' : 'text-rose-700 font-bold' }}">{{ $ans->user_answer ?: '(Bỏ trống)' }}</strong></span>
                                <span class="text-slate-600">Đáp án chuẩn: <strong class="text-emerald-700 font-bold">{{ $q->correct_answer }}</strong></span>
                            </div>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $ans->is_correct ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                        {{ $ans->is_correct ? '✓ ĐÚNG' : '✕ SAI' }}
                    </span>
                </div>

                <!-- Linearthinking Explanation Box -->
                <div class="bg-indigo-50/70 border border-indigo-200/80 rounded-2xl p-5 space-y-4">
                    <div class="flex items-center space-x-2 text-indigo-900 font-bold text-xs uppercase tracking-wider">
                        <i data-lucide="sparkles" class="w-4 h-4 text-indigo-600"></i>
                        <span>Phân Tích Tư Duy Linearthinking</span>
                        @if($q->evidence_paragraph)
                        <span class="ml-auto text-[11px] font-mono text-indigo-700 bg-indigo-100/80 px-2.5 py-0.5 rounded-full">
                            📍 Vị trí manh mối: {{ $q->evidence_paragraph }}
                        </span>
                        @endif
                    </div>

                    <!-- Grammar Simplification -->
                    @if($q->linearthinking_structure)
                    <div class="text-xs text-slate-700 space-y-1">
                        <span class="font-bold text-indigo-950">1. Đơn giản hóa cấu trúc nòng cốt (S-V-O):</span>
                        <p class="pl-3 border-l-2 border-indigo-300 text-slate-800 leading-relaxed">{{ $q->linearthinking_structure }}</p>
                    </div>
                    @endif

                    <!-- Logic Connection -->
                    @if($q->linearthinking_logic)
                    <div class="text-xs text-slate-700 space-y-1">
                        <span class="font-bold text-indigo-950">2. Phân tích liên kết logic ý nghĩa:</span>
                        <p class="pl-3 border-l-2 border-indigo-300 text-slate-800 leading-relaxed">{{ $q->linearthinking_logic }}</p>
                    </div>
                    @endif

                    <!-- Paraphrase Table -->
                    @if(!empty($q->paraphrase_table))
                    <div class="space-y-1.5">
                        <span class="font-bold text-xs text-indigo-950">3. Bảng đối chiếu từ đồng nghĩa (Paraphrase Table):</span>
                        <div class="grid grid-cols-2 gap-2 text-xs bg-white rounded-xl p-3 border border-indigo-100">
                            @foreach($q->paraphrase_table as $item)
                            <div class="font-semibold text-rose-700">Từ trong đề: <span class="font-mono text-slate-900">{{ $item['question_word'] ?? '' }}</span></div>
                            <div class="font-semibold text-emerald-700">Từ trong bài đọc: <span class="font-mono text-slate-900">{{ $item['passage_word'] ?? '' }}</span></div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
