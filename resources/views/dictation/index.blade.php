@extends('layouts.app')

@section('title', 'Luyện Nghe Chép Chính Tả - LearnEnglish')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-indigo-900 via-slate-900 to-slate-950 text-white rounded-3xl p-8 shadow-xl relative overflow-hidden">
        <div class="relative z-10 max-w-2xl space-y-3">
            <span class="px-3 py-1 bg-indigo-500/30 border border-indigo-400/40 text-indigo-300 rounded-full text-xs font-bold uppercase tracking-wider">
                Dictation Mastery Studio
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Luyện Nghe Chép Chính Tả 4 Bước</h1>
            <p class="text-sm text-slate-300 leading-relaxed">
                Phương pháp rèn luyện thính giác, khắc phục triệt để bẫy nuốt âm, nối âm và biến âm trong bài thi IELTS Listening.
            </p>
        </div>
    </div>

    <!-- Topics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($topics as $topic)
        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-lg transition duration-200 flex flex-col justify-between">
            <div>
                <img src="{{ $topic->thumbnail ?: 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $topic->title }}" class="w-full h-48 object-cover">
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 uppercase">{{ $topic->level }}</span>
                        <span class="text-slate-400">⏱ {{ $topic->duration_seconds }}s • {{ $topic->total_sentences }} câu</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 line-clamp-2 leading-snug">{{ $topic->title }}</h3>
                    <p class="text-xs text-slate-500">Chủ đề: {{ $topic->category }}</p>
                </div>
            </div>
            <div class="p-6 pt-0">
                <a href="{{ route('dictation.practice', ['slug' => $topic->slug]) }}" class="w-full py-3 bg-slate-900 hover:bg-rose-600 text-white font-bold text-sm rounded-xl text-center block transition shadow-sm">
                    Bắt Đầu Luyện Nghe →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
