@extends('admin.layouts.admin')

@section('title', 'Soạn Thảo Đề Thi Mới - Admin CMS')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" x-data="examBuilder()">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.tests.index') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-400 hover:text-white mb-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Quay lại danh sách đề thi</span>
            </a>
            <h1 class="text-2xl font-black font-display text-white">Soạn Thảo & Upload Đề Thi Mới</h1>
            <p class="text-xs text-slate-400 mt-1">Hỗ trợ đầy đủ định dạng bài đọc, audio bài nghe và chú giải phương pháp Linearthinking</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.tests.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- 1. General Test Information -->
        <div class="p-6 sm:p-8 rounded-3xl bg-slate-900 border border-slate-800 space-y-6">
            <div class="flex items-center space-x-2 border-b border-slate-800 pb-3">
                <i data-lucide="info" class="w-5 h-5 text-rose-500"></i>
                <h2 class="text-base font-bold text-white">1. Thông Tin Cơ Bản Đề Thi</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Bộ Đề (Test Set):</label>
                    <select name="test_set_id" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white font-semibold text-xs focus:ring-2 focus:ring-rose-500">
                        @foreach($testSets as $set)
                        <option value="{{ $set->id }}">{{ $set->title }} ({{ $set->category->name ?? '' }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Kỹ Năng / Loại Đề:</label>
                    <select name="type" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white font-semibold text-xs focus:ring-2 focus:ring-rose-500">
                        <option value="reading">IELTS Reading Academic</option>
                        <option value="listening">IELTS Listening</option>
                        <option value="full">Full Mock Test 4 Kỹ Năng</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Tiêu Đề Bài Thi:</label>
                <input type="text" name="title" required placeholder="VD: Cambridge IELTS 19 - Test 2 Reading" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-medium focus:ring-2 focus:ring-rose-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Thời Gian Thi (Phút):</label>
                    <input type="number" name="duration_minutes" value="60" required min="5" max="180" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-medium focus:ring-2 focus:ring-rose-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Tổng Số Câu Hỏi:</label>
                    <input type="number" name="total_questions" :value="questions.length" readonly class="w-full px-4 py-2.5 rounded-xl bg-slate-800/60 border border-slate-700 text-rose-400 font-bold text-xs">
                </div>
            </div>
        </div>

        <!-- 2. Section & Passage Content -->
        <div class="p-6 sm:p-8 rounded-3xl bg-slate-900 border border-slate-800 space-y-6">
            <div class="flex items-center space-x-2 border-b border-slate-800 pb-3">
                <i data-lucide="book-open" class="w-5 h-5 text-indigo-500"></i>
                <h2 class="text-base font-bold text-white">2. Nội Dung Bài Đọc / Audio Bài Nghe</h2>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Tiêu Đề Đoạn Văn (Section Title):</label>
                <input type="text" name="section_title" required placeholder="VD: Reading Passage 1 - The History of Tennis Rackets" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-medium focus:ring-2 focus:ring-rose-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Nội Dung Đoạn Văn (Passage HTML Text):</label>
                <textarea name="passage_text" required rows="10" placeholder="Dán văn bản bài đọc tiếng Anh (có thể dùng thẻ <p>, <strong>, <em>)..." class="w-full p-4 rounded-2xl bg-slate-800 border border-slate-700 text-white text-xs leading-relaxed font-serif focus:ring-2 focus:ring-rose-500"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase mb-2">Audio URL (Nếu là bài Listening):</label>
                <input type="url" name="audio_url" placeholder="https://example.com/audio/listening-test-1.mp3" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-medium focus:ring-2 focus:ring-rose-500">
            </div>
        </div>

        <!-- 3. Question Builder with Linearthinking Annotations -->
        <div class="p-6 sm:p-8 rounded-3xl bg-slate-900 border border-slate-800 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <div class="flex items-center space-x-2">
                    <i data-lucide="help-circle" class="w-5 h-5 text-amber-500"></i>
                    <h2 class="text-base font-bold text-white">3. Soạn Câu Hỏi & Giải Thích Linearthinking</h2>
                </div>
                <button type="button" @click="addQuestion()" class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl flex items-center space-x-1.5 transition">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>Thêm Câu Hỏi</span>
                </button>
            </div>

            <!-- Questions Loop Container -->
            <div class="space-y-6">
                <template x-for="(q, idx) in questions" :key="idx">
                    <div class="p-6 rounded-2xl bg-slate-950 border border-slate-800 space-y-4 relative">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 bg-slate-800 text-rose-400 rounded-lg text-xs font-black" x-text="`Câu ${idx + 1}`"></span>
                            <button type="button" @click="removeQuestion(idx)" x-show="questions.length > 1" class="text-rose-400 hover:text-rose-300 text-xs font-bold">
                                ✕ Xóa câu này
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Nội dung câu hỏi / Mệnh đề:</label>
                                <input type="text" :name="`questions[${idx}][content]`" required placeholder="VD: Tennis rackets were originally made completely of wood." class="w-full px-3.5 py-2 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-medium">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Dạng câu hỏi:</label>
                                <select :name="`questions[${idx}][question_type]`" class="w-full px-3.5 py-2 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-bold">
                                    <option value="true_false_not_given">True / False / Not Given</option>
                                    <option value="multiple_choice_single">Multiple Choice (Trắc nghiệm A,B,C,D)</option>
                                    <option value="gap_fill">Điền từ vào chỗ trống</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-emerald-400 uppercase mb-1">Đáp án chính xác:</label>
                            <input type="text" :name="`questions[${idx}][correct_answer]`" required placeholder="VD: TRUE hoặc FALSE hoặc đáp án từ vựng..." class="w-full px-3.5 py-2 rounded-xl bg-emerald-950/40 border border-emerald-500/60 text-emerald-300 font-bold text-xs">
                        </div>

                        <!-- Linearthinking Explanation Fields -->
                        <div class="p-4 bg-slate-900/90 rounded-xl border border-indigo-900/50 space-y-3">
                            <div class="flex items-center space-x-1.5 text-indigo-400 text-xs font-bold uppercase">
                                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                                <span>Phân Tích Tư Duy Linearthinking Cho Câu Này</span>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Vị trí manh mối trong bài (Evidence Paragraph):</label>
                                <input type="text" :name="`questions[${idx}][evidence_paragraph]`" placeholder="VD: Đoạn B, dòng 3-5" class="w-full px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">1. Đơn giản hóa cấu trúc nòng cốt (S-V-O):</label>
                                <input type="text" :name="`questions[${idx}][linearthinking_structure]`" placeholder="VD: S (Tennis rackets) + V (were made of) + O (wood)" class="w-full px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">2. Phân tích liên kết logic ý nghĩa:</label>
                                <input type="text" :name="`questions[${idx}][linearthinking_logic]`" placeholder="VD: Đề bài nói làm hoàn toàn bằng gỗ, bài đọc nói kết hợp nhiều vật liệu -> Mâu thuẫn logic." class="w-full px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs">
                            </div>

                            <div class="grid grid-cols-2 gap-2 pt-1">
                                <div>
                                    <label class="block text-[10px] font-bold text-rose-400 uppercase mb-1">Từ trong câu hỏi:</label>
                                    <input type="text" :name="`questions[${idx}][paraphrase_question]`" placeholder="VD: completely" class="w-full px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs font-mono">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-emerald-400 uppercase mb-1">Từ tương đương trong bài:</label>
                                    <input type="text" :name="`questions[${idx}][paraphrase_passage]`" placeholder="VD: exclusively" class="w-full px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-xs font-mono">
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-4">
            <button type="submit" class="px-8 py-4 bg-rose-600 hover:bg-rose-700 text-white font-black text-sm rounded-2xl shadow-glow transition">
                🚀 Xuất Bản Đề Thi Lên Hệ Thống
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function examBuilder() {
    return {
        questions: [
            { content: '', question_type: 'true_false_not_given', correct_answer: '', evidence_paragraph: '', linearthinking_structure: '', linearthinking_logic: '', paraphrase_question: '', paraphrase_passage: '' }
        ],

        addQuestion() {
            this.questions.push({
                content: '',
                question_type: 'true_false_not_given',
                correct_answer: '',
                evidence_paragraph: '',
                linearthinking_structure: '',
                linearthinking_logic: '',
                paraphrase_question: '',
                paraphrase_passage: ''
            });
        },

        removeQuestion(idx) {
            if (this.questions.length > 1) {
                this.questions.splice(idx, 1);
            }
        }
    };
}
</script>
@endpush
