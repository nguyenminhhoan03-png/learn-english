@extends('layouts.app')

@section('title', 'AI Chấm Bài IELTS Writing 4 Tiêu Chí - EduLearn')

@section('content')
<div x-data="aiGrader()" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white rounded-3xl p-8 shadow-xl space-y-2">
        <span class="px-3 py-1 bg-indigo-500/20 border border-indigo-400/40 text-indigo-300 rounded-full text-xs font-bold uppercase">
            AI IELTS Essay Grader
        </span>
        <h1 class="text-3xl font-extrabold tracking-tight">Trợ Lý AI Chấm Bài Writing Chuẩn 4 Tiêu Chí</h1>
        <p class="text-sm text-slate-300">Nhận xét chi tiết, dự đoán điểm Band và gợi ý sửa bài theo phương pháp Linearthinking.</p>
    </div>

    <!-- Input Form Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Loại bài thi:</label>
                <select x-model="taskType" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-rose-500 font-semibold text-sm">
                    <option value="task2">IELTS Writing Task 2 (Essay)</option>
                    <option value="task1">IELTS Writing Task 1 (Report)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Số lượng từ:</label>
                <div class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 flex items-center justify-between">
                    <span>Đã viết: <strong class="text-rose-600" x-text="wordCount">0</strong> từ</span>
                    <span class="text-xs text-slate-400" x-text="taskType === 'task2' ? 'Yêu cầu: ≥ 250 từ' : 'Yêu cầu: ≥ 150 từ'"></span>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Đề bài (Prompt):</label>
            <input type="text" x-model="prompt" placeholder="Nhập đề bài IELTS Writing vào đây..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-rose-500 text-sm">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Bài viết của bạn (Essay):</label>
            <textarea x-model="userEssay" @input="updateWordCount" rows="10" placeholder="Dán bài viết của bạn vào đây để AI phân tích..." class="w-full p-4 rounded-2xl border border-slate-300 focus:ring-2 focus:ring-rose-500 text-sm leading-relaxed font-serif"></textarea>
        </div>

        <div class="flex justify-end">
            <button @click="gradeEssay()" :disabled="isGrading || wordCount < 30" class="px-8 py-3.5 bg-rose-600 hover:bg-rose-700 disabled:bg-slate-300 text-white font-extrabold text-sm rounded-xl shadow-glow transition flex items-center space-x-2">
                <i data-lucide="sparkles" class="w-4 h-4"></i>
                <span x-text="isGrading ? 'AI Đang Chấm Bài...' : 'Chấm Bài Ngay'"></span>
            </button>
        </div>
    </div>

    <!-- Evaluation Results Card -->
    <div x-show="evaluation" x-cloak class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xl space-y-8 animate-pop">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-100 pb-6">
            <div>
                <span class="text-xs font-bold uppercase text-slate-400">DỰ ĐOÁN ĐIỂM TỔNG QUAN</span>
                <div class="flex items-baseline space-x-2">
                    <span class="text-5xl font-black text-rose-600" x-text="evaluation?.overall_band"></span>
                    <span class="text-slate-500 font-bold">/ 9.0</span>
                </div>
            </div>

            <!-- 4 Criteria Scorecard -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full sm:w-auto">
                <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-500">TASK RESPONSE</p>
                    <p class="text-xl font-black text-slate-900" x-text="evaluation?.band_task_response"></p>
                </div>
                <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-500">COHERENCE</p>
                    <p class="text-xl font-black text-slate-900" x-text="evaluation?.band_coherence"></p>
                </div>
                <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-500">LEXICAL</p>
                    <p class="text-xl font-black text-slate-900" x-text="evaluation?.band_lexical"></p>
                </div>
                <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-500">GRAMMAR</p>
                    <p class="text-xl font-black text-slate-900" x-text="evaluation?.band_grammar"></p>
                </div>
            </div>
        </div>

        <!-- Detailed Feedback -->
        <div class="space-y-4">
            <h3 class="text-lg font-extrabold text-slate-900">Nhận Xét Chi Tiết & Hướng Dẫn Sửa Lỗi</h3>
            <div class="bg-indigo-50/70 rounded-2xl p-6 border border-indigo-100 text-sm text-slate-800 leading-relaxed whitespace-pre-line" x-text="evaluation?.detailed_feedback">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function aiGrader() {
    return {
        taskType: 'task2',
        prompt: 'Some people think that environmental problems should be solved on a global scale while others believe it is a national matter. Discuss both views.',
        userEssay: '',
        wordCount: 0,
        isGrading: false,
        evaluation: null,

        updateWordCount() {
            const words = this.userEssay.trim().split(/\s+/).filter(w => w.length > 0);
            this.wordCount = words.length;
        },

        async gradeEssay() {
            if (this.isGrading) return;
            this.isGrading = true;
            this.evaluation = null;

            try {
                const res = await fetch("{{ route('ai.writing.grade') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        task_type: this.taskType,
                        prompt: this.prompt,
                        user_essay: this.userEssay
                    })
                });

                const data = await res.json();
                if (data.success) {
                    this.evaluation = data.evaluation;
                    window.fireConfetti?.({ particleCount: 80, spread: 70, origin: { y: 0.6 } });
                } else {
                    alert(data.message || 'Lỗi chấm bài.');
                }
            } catch (err) {
                alert('Có lỗi xảy ra khi kết nối máy chủ AI.');
            } finally {
                this.isGrading = false;
            }
        }
    };
}
</script>
@endpush
