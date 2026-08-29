@extends('layouts.app')

@section('title', $sample->topic . ' - Bài Mẫu Speaking Band ' . $sample->band_score)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <a href="{{ route('samples.speaking.index') }}" class="inline-flex items-center space-x-2 text-sm font-bold text-slate-600 hover:text-slate-900">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Về kho bài mẫu Speaking</span>
    </a>

    <!-- Topic & Cue Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <span class="px-3 py-1 bg-amber-50 text-amber-700 font-extrabold text-xs rounded-full uppercase">{{ $sample->part }}</span>
            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Band Score: {{ $sample->band_score }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black font-display text-slate-900 leading-tight">{{ $sample->topic }}</h1>
        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-sm font-medium text-slate-800 italic">
            <strong>Câu hỏi / Cue card:</strong> "{{ $sample->cue_card_or_question }}"
        </div>
    </div>

    <!-- Sample Answer -->
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
        <h2 class="text-xl font-black font-display text-slate-900">Câu Trả Lời Mẫu (Sample Transcript)</h2>
        <div class="passage-content text-slate-800 leading-relaxed whitespace-pre-line border-l-4 border-amber-500 pl-6 font-serif">
            {!! nl2br(e($sample->sample_transcript)) !!}
        </div>
    </div>

    <!-- Key Vocabulary -->
    @if(!empty($sample->key_vocab_list))
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-lg font-black font-display text-slate-900">Bộ Từ Vựng & Cụm Diễn Đạt Tự Nhiên</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($sample->key_vocab_list as $vocab)
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs">
                <span class="font-bold text-rose-600">{{ $vocab['word'] ?? '' }}</span>: 
                <span class="text-slate-700">{{ $vocab['meaning'] ?? '' }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
