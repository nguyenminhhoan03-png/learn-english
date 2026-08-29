@extends('admin.layouts.admin')

@section('title', 'Thêm Bài Mẫu Speaking - Admin CMS')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" x-data="{ vocabs: [{word: '', meaning: ''}] }">
    <div>
        <a href="{{ route('admin.samples.index') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-400 hover:text-white mb-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Về kho bài mẫu</span>
        </a>
        <h1 class="text-2xl font-black font-display text-white">Thêm Bài Mẫu IELTS Speaking Band 8.0+</h1>
        <p class="text-xs text-slate-400 mt-1">Soạn thảo câu trả lời tự nhiên kèm phát âm và từ vựng mở rộng theo chủ đề.</p>
    </div>

    <form action="{{ route('admin.samples.store_speaking') }}" method="POST" class="space-y-8">
        @csrf

        <div class="p-6 sm:p-8 rounded-3xl bg-slate-900 border border-slate-800 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Chủ Đề (Topic):</label>
                    <input type="text" name="topic" required placeholder="VD: Describe a memorable journey you took" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Phần Thi & Band:</label>
                    <div class="grid grid-cols-2 gap-2">
                        <select name="part" class="px-3 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-bold">
                            <option value="part2">Part 2</option>
                            <option value="part1">Part 1</option>
                            <option value="part3">Part 3</option>
                        </select>
                        <input type="number" step="0.5" name="band_score" value="8.0" min="5.0" max="9.0" class="px-3 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-emerald-400 font-bold text-xs">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Câu Hỏi / Cue Card:</label>
                <textarea name="cue_card_or_question" required rows="3" placeholder="You should say: Where you went, Who you went with..." class="w-full p-4 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Audio URL Bài Nói Mẫu (Tùy chọn):</label>
                <input type="url" name="audio_url" placeholder="https://example.com/speaking-audio.mp3" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs">
            </div>

            <div>
                <label class="block text-xs font-bold text-amber-400 uppercase mb-2">Câu Trả Lời Mẫu (Sample Transcript):</label>
                <textarea name="sample_transcript" required rows="8" placeholder="Dán nội dung bài nói mẫu tự nhiên..." class="w-full p-4 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs leading-relaxed font-serif"></textarea>
            </div>

            <!-- Key Vocab Adders -->
            <div class="space-y-3 pt-3 border-t border-slate-800">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-bold text-amber-400 uppercase">Bộ Từ Vựng & Cụm Diễn Đạt Tự Nhiên:</label>
                    <button type="button" @click="vocabs.push({word:'', meaning:''})" class="text-xs font-bold text-slate-300 hover:text-white">+ Thêm từ</button>
                </div>
                <template x-for="(v, idx) in vocabs" :key="idx">
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="vocab_words[]" placeholder="Từ / Cụm từ tiếng Anh" class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs">
                        <input type="text" name="vocab_meanings[]" placeholder="Ý nghĩa tiếng Việt" class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs">
                    </div>
                </template>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-4 bg-amber-600 hover:bg-amber-700 text-white font-black text-sm rounded-2xl shadow-glow transition">
                🚀 Xuất Bản Bài Mẫu Speaking
            </button>
        </div>
    </form>
</div>
@endsection
