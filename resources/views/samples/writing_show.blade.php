@extends('layouts.app')

@section('title', $sample->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <a href="{{ route('samples.writing.index') }}" class="inline-flex items-center space-x-2 text-sm font-bold text-slate-600 hover:text-slate-900">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Về kho bài mẫu Writing</span>
    </a>

    <!-- Prompt Header Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <span class="px-3 py-1 bg-rose-50 text-rose-700 font-bold text-xs rounded-full uppercase">{{ $sample->task_type }}</span>
            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Band Score: {{ $sample->band_score }}</span>
        </div>
        <h1 class="text-2xl font-black text-slate-900 leading-tight">{{ $sample->title }}</h1>
        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 text-sm font-medium text-slate-800">
            <strong>Đề bài:</strong> {{ $sample->prompt }}
        </div>
    </div>

    <!-- Linearthinking Outline -->
    <div class="bg-indigo-50/80 rounded-3xl p-8 border border-indigo-200/80 space-y-4">
        <div class="flex items-center space-x-2 text-indigo-900 font-extrabold text-sm uppercase tracking-wider">
            <i data-lucide="sparkles" class="w-4 h-4 text-indigo-600"></i>
            <span>Dàn Bài Tư Duy Tuyến Tính (Linearthinking Outline)</span>
        </div>
        <div class="text-sm text-slate-800 leading-relaxed space-y-2 whitespace-pre-line">
            {!! nl2br(e($sample->outline_linearthinking)) !!}
        </div>
    </div>

    <!-- Sample Essay -->
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
        <h2 class="text-xl font-extrabold text-slate-900">Bài Luận Hoàn Chỉnh (Sample Essay)</h2>
        <div class="passage-content text-slate-800 leading-relaxed whitespace-pre-line border-l-4 border-rose-500 pl-6">
            {!! nl2br(e($sample->sample_essay)) !!}
        </div>
    </div>

    <!-- Key Vocabulary -->
    @if(!empty($sample->key_vocab_list))
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-lg font-extrabold text-slate-900">Từ Vựng & Collocation Ăn Điểm</h3>
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
