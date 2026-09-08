@extends('layouts.app')

@section('title', 'Thư Viện Bài Mẫu IELTS Speaking Band 8.0+ - LearnEnglish')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <div class="bg-gradient-to-r from-amber-600 via-rose-600 to-indigo-900 text-white rounded-3xl p-8 shadow-xl space-y-2">
        <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-extrabold uppercase tracking-wider">Linearthinking Speaking Bank</span>
        <h1 class="text-3xl sm:text-4xl font-black font-display tracking-tight">Kho Bài Mẫu IELTS Speaking Chuẩn Band 8.0+</h1>
        <p class="text-sm text-amber-100">Bóc tách tư duy phát triển ý Part 1, 2, 3 kèm phát âm mẫu và bộ Collocations đắt giá.</p>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center space-x-2 border-b border-slate-200 pb-4">
        <a href="{{ route('samples.speaking.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !$part ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100' }}">Tất Cả</a>
        <a href="{{ route('samples.speaking.index', ['part' => 'part1']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $part === 'part1' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100' }}">Speaking Part 1</a>
        <a href="{{ route('samples.speaking.index', ['part' => 'part2']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $part === 'part2' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100' }}">Speaking Part 2</a>
        <a href="{{ route('samples.speaking.index', ['part' => 'part3']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $part === 'part3' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100' }}">Speaking Part 3</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($samples as $sample)
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs hover:shadow-lg transition flex flex-col justify-between space-y-4">
            <div class="space-y-3">
                <div class="flex items-center justify-between text-xs font-bold">
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 uppercase font-extrabold">{{ $sample->part }}</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-extrabold">Band {{ $sample->band_score }}</span>
                </div>
                <h3 class="font-bold font-display text-slate-900 text-lg leading-snug line-clamp-2">{{ $sample->topic }}</h3>
                <p class="text-xs text-slate-500 line-clamp-3 italic">"{{ $sample->cue_card_or_question }}"</p>
            </div>
            <a href="{{ route('samples.speaking.show', ['slug' => $sample->slug]) }}" class="w-full py-3 bg-slate-900 hover:bg-rose-600 text-white font-extrabold text-xs rounded-xl text-center block transition shadow-xs">
                Xem Câu Trả Lời Mẫu & Từ Vựng →
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
