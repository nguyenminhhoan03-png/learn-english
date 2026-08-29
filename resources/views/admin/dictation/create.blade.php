@extends('admin.layouts.admin')

@section('title', 'Tải Lên Bài Dictation Mới - Admin CMS')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" x-data="dictationBuilder()">
    <div>
        <a href="{{ route('admin.dictation.index') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-400 hover:text-white mb-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Quay lại danh sách bài nghe</span>
        </a>
        <h1 class="text-2xl font-black font-display text-white">Tải Lên & Cắt Đoạn Audio Dictation</h1>
        <p class="text-xs text-slate-400 mt-1">Nhập liên kết âm thanh và định vị các mốc giây cho từng câu tiếng Anh.</p>
    </div>

    <form action="{{ route('admin.dictation.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- General Topic Info -->
        <div class="p-6 sm:p-8 rounded-3xl bg-slate-900 border border-slate-800 space-y-6">
            <div class="flex items-center space-x-2 border-b border-slate-800 pb-3">
                <i data-lucide="info" class="w-5 h-5 text-indigo-500"></i>
                <h2 class="text-base font-bold text-white">1. Thông Tin Bài Nghe</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Tiêu Đề Bài Nghe:</label>
                    <input type="text" name="title" required placeholder="VD: The Secrets of Human Communication" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Cấp Độ (CEFR Level):</label>
                    <select name="level" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-bold">
                        <option value="B1">B1 (Intermediate)</option>
                        <option value="B2" selected>B2 (Upper-Intermediate)</option>
                        <option value="C1">C1 (Advanced)</option>
                        <option value="A2">A2 (Elementary)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Chủ Đề (Category):</label>
                    <input type="text" name="category" required placeholder="VD: TED Talks, Science, Society..." class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Audio MP3 URL:</label>
                    <input type="url" name="audio_url" required placeholder="https://example.com/audio/speech.mp3" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-medium">
                </div>
            </div>
        </div>

        <!-- Sentences Segmenter -->
        <div class="p-6 sm:p-8 rounded-3xl bg-slate-900 border border-slate-800 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <div class="flex items-center space-x-2">
                    <i data-lucide="volume-2" class="w-5 h-5 text-rose-500"></i>
                    <h2 class="text-base font-bold text-white">2. Danh Sách Câu & Timestamps Audio</h2>
                </div>
                <button type="button" @click="addSentence()" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl flex items-center space-x-1.5 transition">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>Thêm Câu Tiếp Theo</span>
                </button>
            </div>

            <div class="space-y-4">
                <template x-for="(s, idx) in sentences" :key="idx">
                    <div class="p-5 rounded-2xl bg-slate-950 border border-slate-800 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 bg-indigo-950 text-indigo-400 font-black text-xs rounded-lg" x-text="`Câu ${idx + 1}`"></span>
                            <button type="button" @click="removeSentence(idx)" x-show="sentences.length > 1" class="text-rose-400 text-xs font-bold">✕ Xóa câu này</button>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Thời gian bắt đầu (Giây):</label>
                                <input type="number" step="0.1" :name="`sentences[${idx}][audio_start_time]`" x-model="s.audio_start_time" required class="w-full px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs font-mono">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Thời gian kết thúc (Giây):</label>
                                <input type="number" step="0.1" :name="`sentences[${idx}][audio_end_time]`" x-model="s.audio_end_time" required class="w-full px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs font-mono">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nội dung câu tiếng Anh (Target Transcript):</label>
                            <input type="text" :name="`sentences[${idx}][sentence_text]`" required placeholder="VD: Good communication is the most powerful tool for spreading ideas." class="w-full px-3 py-2 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs font-medium">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Bản dịch nghĩa tiếng Việt:</label>
                                <input type="text" :name="`sentences[${idx}][translation_vi]`" required placeholder="VD: Giao tiếp tốt là công cụ mạnh mẽ nhất..." class="w-full px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Ghi chú phát âm (Nối âm / Nuốt âm):</label>
                                <input type="text" :name="`sentences[${idx}][phonetic_notes]`" placeholder="VD: Nối âm /z/ trong 'is the', nuốt âm /t/ trong 'most powerful'..." class="w-full px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-4 bg-rose-600 hover:bg-rose-700 text-white font-black text-sm rounded-2xl shadow-glow transition">
                🚀 Xuất Bản Bài Nghe Chép Chính Tả
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function dictationBuilder() {
    return {
        sentences: [
            { audio_start_time: 0.0, audio_end_time: 5.5 }
        ],

        addSentence() {
            const last = this.sentences[this.sentences.length - 1];
            const nextStart = last ? parseFloat(last.audio_end_time) : 0.0;
            this.sentences.push({
                audio_start_time: nextStart,
                audio_end_time: (nextStart + 5.0).toFixed(1)
            });
        },

        removeSentence(idx) {
            if (this.sentences.length > 1) {
                this.sentences.splice(idx, 1);
            }
        }
    };
}
</script>
@endpush
