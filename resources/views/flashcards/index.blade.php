@extends('layouts.app')

@section('title', 'Sổ Từ Vựng & Flashcard SM-2 - EduLearn')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Header Stats -->
    <div class="bg-gradient-to-r from-amber-600 via-rose-600 to-indigo-900 text-white rounded-3xl p-8 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2">
            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wider">SuperMemo SM-2 Spaced Repetition</span>
            <h1 class="text-3xl font-extrabold tracking-tight">Sổ Từ Vựng Thông Minh</h1>
            <p class="text-sm text-amber-100">Ghi nhớ từ vựng vĩnh viễn với thuật toán ôn tập ngắt quãng khoa học.</p>
        </div>

        <div class="flex items-center space-x-4">
            <div class="text-right">
                <p class="text-xs font-bold text-amber-200 uppercase">Cần Ôn Hôm Nay</p>
                <p class="text-4xl font-black text-white">{{ $dueCardsCount }} Thẻ</p>
            </div>
            @if($dueCardsCount > 0)
            <a href="{{ route('flashcards.study') }}" class="px-6 py-3.5 bg-white hover:bg-slate-100 text-slate-900 font-extrabold text-sm rounded-2xl shadow-lg transition transform hover:scale-105">
                Bắt Đầu Ôn Tập →
            </a>
            @else
            <div class="flex items-center space-x-2">
                <span class="px-4 py-3 bg-white/20 text-white font-bold text-xs rounded-xl">
                    ✓ Đã Hoàn Thành Hôm Nay
                </span>
                <a href="{{ route('flashcards.study') }}" class="px-5 py-3 bg-white hover:bg-slate-100 text-slate-900 font-extrabold text-xs rounded-xl shadow-md transition">
                    Luyện Tập Tự Do →
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Cards Catalog -->
    <div class="space-y-6">
        <h2 class="text-2xl font-extrabold text-slate-900">Danh Sách Từ Đã Lưu ({{ $totalCards }})</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentCards as $card)
            @php $v = $card->vocabulary; @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs hover:shadow-md transition space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xl font-black text-slate-900">{{ $v->word }}</h3>
                        <p class="text-xs font-mono text-rose-600">{{ $v->phonetic_us ?: $v->phonetic_uk }}</p>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 uppercase">
                        {{ $v->part_of_speech ?: 'word' }}
                    </span>
                </div>

                <p class="text-sm font-semibold text-slate-800">{{ $v->definition_vi }}</p>

                @if($card->context_sentence)
                <div class="bg-slate-50 rounded-xl p-3 text-xs text-slate-600 border border-slate-100 italic">
                    "{{ $card->context_sentence }}"
                </div>
                @endif

                <div class="flex items-center justify-between text-xs font-semibold text-slate-400 pt-2 border-t border-slate-100">
                    <span>Lặp lại: <strong>{{ $card->repetitions }} lần</strong></span>
                    <span>Ôn tiếp: <strong class="text-rose-600">{{ $card->next_review_at->format('d/m/Y') }}</strong></span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
