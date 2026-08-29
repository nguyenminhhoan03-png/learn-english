@extends('layouts.app')

@section('title', 'Bảng Quy Đổi Điểm IELTS, TOEIC & CEFR Chuẩn Quốc Tế - EduLearn')
@section('meta_description', 'Công cụ tính và quy đổi điểm IELTS Band 9.0, TOEIC 990, Khung tham chiếu Châu Âu CEFR (B1, B2, C1, C2) và VSTEP chính xác nhất.')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10" x-data="scoreConverter()">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-rose-950 to-slate-900 text-white rounded-3xl p-8 sm:p-10 shadow-2xl space-y-3 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 space-y-2 max-w-3xl">
            <span class="px-3 py-1 bg-rose-500/30 text-rose-200 border border-rose-400/40 text-xs font-black rounded-full uppercase">
                Interactive Converter Tool
            </span>
            <h1 class="text-2xl sm:text-4xl font-black font-display tracking-tight leading-tight">
                Bảng Quy Đổi Điểm IELTS, TOEIC & CEFR
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 font-medium leading-relaxed">
                Nhập số câu đúng hoặc kéo thanh trượt để quy đổi tức thì giữa các thang điểm IELTS (Band 0-9.0), TOEIC (0-990), CEFR và VSTEP.
            </p>
        </div>
    </div>

    <!-- Converter Interactive Playground -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Input & Slider Controls (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h2 class="text-lg font-black font-display text-slate-900">1. Chọn Loại Bài Thi Cần Tính</h2>
                <div class="flex items-center space-x-1 bg-slate-100 p-1 rounded-xl text-xs font-bold">
                    <button @click="testType = 'ielts_reading'" :class="testType === 'ielts_reading' ? 'bg-white text-rose-600 shadow-xs' : 'text-slate-600'" class="px-3 py-1.5 rounded-lg transition">IELTS Reading</button>
                    <button @click="testType = 'ielts_listening'" :class="testType === 'ielts_listening' ? 'bg-white text-rose-600 shadow-xs' : 'text-slate-600'" class="px-3 py-1.5 rounded-lg transition">IELTS Listening</button>
                    <button @click="testType = 'toeic'" :class="testType === 'toeic' ? 'bg-white text-rose-600 shadow-xs' : 'text-slate-600'" class="px-3 py-1.5 rounded-lg transition">TOEIC (450-990)</button>
                </div>
            </div>

            <!-- IELTS Mode -->
            <div x-show="testType.startsWith('ielts')" class="space-y-5">
                <div>
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-2">
                        <span>Số Câu Đúng (Raw Score):</span>
                        <span class="text-base font-black text-rose-600" x-text="`${ieltsRaw} / 40 câu`"></span>
                    </div>
                    <input type="range" min="0" max="40" x-model.number="ieltsRaw" class="w-full accent-rose-600 h-2 bg-slate-200 rounded-lg cursor-pointer">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl">
                        <span class="text-[11px] font-bold text-slate-500 uppercase block">IELTS Band Score</span>
                        <span class="text-3xl font-black text-slate-900" x-text="computedIeltsBand"></span>
                    </div>
                    <div class="p-3.5 bg-rose-50 border border-rose-200/80 rounded-2xl">
                        <span class="text-[11px] font-bold text-rose-700 uppercase block">Trình Độ CEFR Tương Đương</span>
                        <span class="text-3xl font-black text-rose-600" x-text="computedCefr"></span>
                    </div>
                </div>
            </div>

            <!-- TOEIC Mode -->
            <div x-show="testType === 'toeic'" x-cloak class="space-y-5">
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-1">
                            <span>TOEIC Reading (Số câu đúng / 100):</span>
                            <span class="text-sm font-black text-indigo-600" x-text="`${toeicReadingRaw} câu (${computedToeicReadingScore} điểm)`"></span>
                        </div>
                        <input type="range" min="0" max="100" x-model.number="toeicReadingRaw" class="w-full accent-indigo-600 h-2 bg-slate-200 rounded-lg cursor-pointer">
                    </div>

                    <div>
                        <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-1">
                            <span>TOEIC Listening (Số câu đúng / 100):</span>
                            <span class="text-sm font-black text-indigo-600" x-text="`${toeicListeningRaw} câu (${computedToeicListeningScore} điểm)`"></span>
                        </div>
                        <input type="range" min="0" max="100" x-model.number="toeicListeningRaw" class="w-full accent-indigo-600 h-2 bg-slate-200 rounded-lg cursor-pointer">
                    </div>
                </div>

                <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-2xl flex items-center justify-between">
                    <div>
                        <span class="text-xs font-extrabold uppercase text-indigo-900 block">Tổng Điểm TOEIC 2 Kỹ Năng:</span>
                        <span class="text-3xl font-black text-indigo-600" x-text="`${computedToeicTotal} / 990`"></span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-bold uppercase text-slate-500 block">Trình Độ:</span>
                        <span class="text-xl font-black text-slate-900" x-text="computedToeicLevel"></span>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-500 font-medium">Muốn thử sức ngay với đề thi chuẩn?</span>
                <a href="{{ route('ielts.index') }}" class="px-4 py-2 bg-slate-900 hover:bg-rose-600 text-white font-extrabold text-xs rounded-xl transition">
                    Vào Thi Thử Ngay →
                </a>
            </div>
        </div>

        <!-- Equivalent Conversion Summary (5 cols) -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
            <h3 class="text-lg font-black font-display text-slate-900">Đối Chiếu Khung Năng Lực Quốc Tế</h3>
            
            <div class="space-y-3 text-xs">
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80 flex items-center justify-between">
                    <span class="font-bold text-slate-700">Khung Tham Chiếu Châu Âu (CEFR):</span>
                    <strong class="text-rose-600 text-sm font-black" x-text="computedCefr"></strong>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80 flex items-center justify-between">
                    <span class="font-bold text-slate-700">Khung Năng Lực Ngoại Ngữ VN (VSTEP):</span>
                    <strong class="text-slate-900 text-sm font-black" x-text="computedVstep"></strong>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80 flex items-center justify-between">
                    <span class="font-bold text-slate-700">Đầu Ra Đại Học & Xét Tuyển:</span>
                    <strong class="text-emerald-700 font-bold" x-text="computedTargetUse"></strong>
                </div>
            </div>

            <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900 leading-relaxed font-medium">
                💡 <strong>Mẹo tự học:</strong> Để tăng 0.5 Band IELTS Reading, bạn cần nắm vững kỹ thuật bóc tách cụm $S-V-O$ trong phương pháp Linearthinking để không bị bẫy bởi từ vựng lạ.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function scoreConverter() {
    return {
        testType: 'ielts_reading',
        ieltsRaw: 30,
        toeicReadingRaw: 75,
        toeicListeningRaw: 80,

        get computedIeltsBand() {
            const raw = this.ieltsRaw;
            if (raw >= 39) return 9.0;
            if (raw >= 37) return 8.5;
            if (raw >= 35) return 8.0;
            if (raw >= 33) return 7.5;
            if (raw >= 30) return 7.0;
            if (raw >= 27) return 6.5;
            if (raw >= 23) return 6.0;
            if (raw >= 19) return 5.5;
            if (raw >= 15) return 5.0;
            if (raw >= 13) return 4.5;
            if (raw >= 10) return 4.0;
            return 3.5;
        },

        get computedCefr() {
            const band = this.computedIeltsBand;
            if (band >= 8.5) return 'C2 (Mastery)';
            if (band >= 7.0) return 'C1 (Effective Operational)';
            if (band >= 5.5) return 'B2 (Vantage)';
            if (band >= 4.0) return 'B1 (Threshold)';
            return 'A2 (Waystage)';
        },

        get computedVstep() {
            const band = this.computedIeltsBand;
            if (band >= 8.0) return 'Bậc 6 (C2)';
            if (band >= 6.5) return 'Bậc 5 (C1)';
            if (band >= 5.5) return 'Bậc 4 (B2)';
            if (band >= 4.0) return 'Bậc 3 (B1)';
            return 'Bậc 2 (A2)';
        },

        get computedTargetUse() {
            const band = this.computedIeltsBand;
            if (band >= 7.5) return 'Xét tuyển FTU, NEU, Học bổng Du học';
            if (band >= 6.5) return 'Miễn thi tốt nghiệp ĐH, Xét tuyển thẳng';
            if (band >= 5.5) return 'Chuẩn đầu ra tốt nghiệp ĐH Bách Khoa, Quốc Gia';
            return 'Nền tảng giao tiếp cơ bản';
        },

        get computedToeicReadingScore() {
            return Math.min(495, Math.max(5, Math.round(this.toeicReadingRaw * 4.95)));
        },

        get computedToeicListeningScore() {
            return Math.min(495, Math.max(5, Math.round(this.toeicListeningRaw * 4.95)));
        },

        get computedToeicTotal() {
            return this.computedToeicReadingScore + this.computedToeicListeningScore;
        },

        get computedToeicLevel() {
            const total = this.computedToeicTotal;
            if (total >= 850) return 'Xuất Sắc (Professional)';
            if (total >= 700) return 'Khá Giỏi (Working Proficiency)';
            if (total >= 500) return 'Trung Bình Khá (Intermediate)';
            return 'Cơ Bản (Beginner)';
        }
    };
}
</script>
@endpush
