@extends('layouts.app')

@section('title', $testSet->title . ' - Chi Tiết Bộ Đề')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <a href="{{ route('ielts.index') }}" class="inline-flex items-center space-x-2 text-sm font-bold text-slate-600 hover:text-slate-900">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Về kho đề thi</span>
    </a>

    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col md:flex-row gap-8 items-center">
        <img src="{{ $testSet->thumbnail ?: 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $testSet->title }}" class="w-full md:w-64 h-48 rounded-2xl object-cover">
        <div class="space-y-3">
            <span class="px-3 py-1 bg-rose-50 text-rose-700 font-bold text-xs rounded-full uppercase">{{ $testSet->category->name }}</span>
            <h1 class="text-2xl font-black text-slate-900">{{ $testSet->title }}</h1>
            <p class="text-sm text-slate-600 leading-relaxed">{{ $testSet->description }}</p>
        </div>
    </div>

    <!-- Tests List in Set -->
    <div class="space-y-4">
        <h2 class="text-xl font-extrabold text-slate-900">Danh Sách Bài Thi Trong Bộ Đề ({{ $testSet->tests->count() }})</h2>
        <div class="grid grid-cols-1 gap-4">
            @foreach($testSet->tests as $test)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xs hover:shadow-sm transition">
                <div>
                    <span class="px-2.5 py-0.5 rounded-md bg-rose-50 text-rose-600 text-xs font-bold uppercase">{{ $test->type }}</span>
                    <h3 class="text-lg font-bold text-slate-900 mt-1">{{ $test->title }}</h3>
                    <p class="text-xs text-slate-400">⏱ {{ $test->duration_minutes }} phút • {{ $test->total_questions }} câu hỏi • Lời giải Linearthinking</p>
                </div>
                <div class="flex items-center space-x-3 w-full sm:w-auto">
                    <a href="{{ route('ielts.take', ['slug' => $test->slug, 'mode' => 'practice']) }}" class="flex-1 sm:flex-none px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition text-center">
                        Luyện tập
                    </a>
                    <a href="{{ route('ielts.take', ['slug' => $test->slug, 'mode' => 'full_test']) }}" class="flex-1 sm:flex-none px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-glow transition text-center">
                        Vào Thi Thử
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
