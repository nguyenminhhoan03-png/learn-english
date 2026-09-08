@extends('layouts.app')

@section('title', 'Thư Viện Bài Mẫu IELTS Writing Band 8.0+ - LearnEnglish')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <div class="bg-gradient-to-r from-slate-900 via-rose-950 to-slate-900 text-white rounded-3xl p-8 shadow-xl">
        <span class="px-3 py-1 bg-rose-500/20 border border-rose-400/40 text-rose-300 rounded-full text-xs font-bold uppercase">Linearthinking Writing Bank</span>
        <h1 class="text-3xl font-extrabold mt-2">Kho Bài Mẫu IELTS Writing Chuẩn Band 8.0+</h1>
        <p class="text-sm text-slate-300 mt-1">Dàn bài tư duy logic rõ ràng, bóc tách cấu trúc đoạn và bộ từ vựng đắt giá.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($samples as $sample)
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs hover:shadow-md transition flex flex-col justify-between space-y-4">
            <div class="space-y-3">
                <div class="flex items-center justify-between text-xs font-bold">
                    <span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 uppercase">{{ $sample->task_type }}</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700">Band {{ $sample->band_score }}</span>
                </div>
                <h3 class="font-bold text-slate-900 text-base leading-snug line-clamp-2">{{ $sample->title }}</h3>
                <p class="text-xs text-slate-500 line-clamp-3 italic">"{{ $sample->prompt }}"</p>
            </div>
            <a href="{{ route('samples.writing.show', ['slug' => $sample->slug]) }}" class="w-full py-2.5 bg-slate-900 hover:bg-rose-600 text-white font-bold text-xs rounded-xl text-center block transition">
                Xem Dàn Ý & Bài Mẫu →
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
