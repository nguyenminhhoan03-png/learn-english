@extends('layouts.app')

@section('title', 'EduLearn - Luyện Thi IELTS & Tự Học Tiếng Anh Chuẩn DOL Linearthinking')

@section('content')
<div class="space-y-16 sm:space-y-24">
    <!-- Hero Banner -->
    <section class="relative overflow-hidden bg-gradient-to-b from-rose-50/60 via-white to-slate-50 pt-12 sm:pt-20 pb-16 sm:pb-24 border-b border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                <!-- Left Hero Text -->
                <div class="lg:col-span-7 space-y-6 sm:space-y-8 text-center lg:text-left">
                    <div class="inline-flex items-center justify-center space-x-1.5 sm:space-x-2 px-3 sm:px-3.5 py-1.5 rounded-full bg-rose-100/90 border border-rose-200 text-rose-800 text-[10px] sm:text-xs font-extrabold tracking-wide uppercase shadow-2xs">
                        <span>🚀 Phương Pháp Độc Quyền</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600" aria-hidden="true"></span>
                        <span>Linearthinking</span>
                    </div>
                    
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black font-display text-slate-900 tracking-tight leading-[1.3] sm:leading-[1.28]">
                        <span class="block">Tự Học Tiếng Anh Thông Minh</span>
                        <span class="block mt-1.5 sm:mt-2.5 bg-gradient-to-r from-rose-600 via-rose-500 to-rose-700 bg-clip-text text-transparent pb-1">
                            Chuẩn Band 8.0+
                        </span>
                    </h1>

                    <p class="text-sm sm:text-lg text-slate-700 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-medium">
                        Nâng cao điểm số IELTS & tiếng Anh toàn diện với hệ thống phòng thi tách đôi (Split-Screen), luyện nghe chép chính tả 4 bước, flashcard thuật toán SuperMemo SM-2 và công nghệ AI chấm bài 4 tiêu chí.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 sm:gap-4 pt-2">
                        <a href="{{ route('ielts.index') }}" class="w-full sm:w-auto px-6 sm:px-7 py-3.5 sm:py-4 bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-sm sm:text-base rounded-2xl shadow-glow hover:shadow-lg transition transform hover:-translate-y-0.5 inline-flex items-center justify-center space-x-2">
                            <span>Luyện Thi Đề Cambridge 19</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 sm:w-5 sm:h-5" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('dictation.index') }}" class="w-full sm:w-auto px-6 sm:px-7 py-3.5 sm:py-4 bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-sm sm:text-base rounded-2xl border border-slate-300 shadow-xs hover:border-slate-400 transition inline-flex items-center justify-center space-x-2">
                            <i data-lucide="headphones" class="w-4 h-4 sm:w-5 sm:h-5 text-rose-600" aria-hidden="true"></i>
                            <span>Nghe Chép Chính Tả</span>
                        </a>
                    </div>

                    <!-- Trust Stats Grid -->
                    <div class="grid grid-cols-3 gap-2 sm:gap-6 pt-6 border-t border-slate-200/80">
                        <div class="p-2 sm:p-3 bg-white/80 rounded-2xl border border-slate-200/80 text-center">
                            <p class="text-base sm:text-2xl font-black font-display text-slate-900">40+ Bộ Đề</p>
                            <p class="text-[10px] sm:text-xs font-bold text-slate-600 mt-0.5 truncate">Cambridge 10-19</p>
                        </div>
                        <div class="p-2 sm:p-3 bg-white/80 rounded-2xl border border-slate-200/80 text-center">
                            <p class="text-base sm:text-2xl font-black font-display text-rose-700">SM-2 Engine</p>
                            <p class="text-[10px] sm:text-xs font-bold text-slate-600 mt-0.5 truncate">Spaced Repetition</p>
                        </div>
                        <div class="p-2 sm:p-3 bg-white/80 rounded-2xl border border-slate-200/80 text-center">
                            <p class="text-base sm:text-2xl font-black font-display text-indigo-700">AI Grader</p>
                            <p class="text-[10px] sm:text-xs font-bold text-slate-600 mt-0.5 truncate">Chuẩn 4 Tiêu Chí</p>
                        </div>
                    </div>
                </div>

                <!-- Right Feature Preview Card -->
                <div class="lg:col-span-5">
                    <div class="relative mx-auto max-w-md bg-white rounded-3xl p-5 sm:p-7 shadow-xl border border-slate-200/90 space-y-4 sm:space-y-5">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3 sm:pb-4 gap-2">
                            <div class="flex items-center space-x-2.5 sm:space-x-3 min-w-0">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-rose-50 text-rose-600 font-display font-black text-sm sm:text-base flex items-center justify-center border border-rose-200/60 flex-shrink-0">
                                    9.0
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold font-display text-slate-900 text-xs sm:text-base truncate">Cambridge IELTS 19</h4>
                                    <p class="text-[11px] sm:text-xs text-slate-600 font-medium truncate">Test 1 • Reading Academic</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 text-[10px] sm:text-xs font-extrabold text-emerald-800 bg-emerald-100 rounded-full border border-emerald-300 flex-shrink-0">Free Access</span>
                        </div>

                        <!-- Linearthinking Box Highlight -->
                        <div class="bg-indigo-50/90 border border-indigo-200/80 rounded-2xl p-4 sm:p-5 space-y-2">
                            <div class="flex items-center space-x-2 text-indigo-950 font-black text-xs uppercase tracking-wider">
                                <i data-lucide="sparkles" class="w-4 h-4 text-indigo-700" aria-hidden="true"></i>
                                <span>Giải Thích Linearthinking Cốt Lõi</span>
                            </div>
                            <p class="text-xs text-slate-800 leading-relaxed font-medium">
                                <strong class="text-indigo-950">S-V-O Simplification:</strong> Tách mệnh đề quan hệ phụ, tập trung vào liên kết logic nhân quả giữa 2 câu để định vị đáp án chính xác.
                            </p>
                        </div>

                        <a href="{{ route('ielts.take', ['slug' => 'cambridge-19-test-1-reading']) }}" class="w-full py-3 sm:py-3.5 bg-slate-900 hover:bg-rose-600 text-white font-extrabold text-xs sm:text-sm rounded-xl text-center block transition shadow-md">
                            Vào Phòng Thi Thử Ngay →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Features Grid -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16 space-y-2">
            <h2 class="text-2xl sm:text-4xl font-black font-display text-slate-900 tracking-tight">Hệ Thống 5 Mô-đun Tự Học Chuẩn DOL</h2>
            <p class="text-sm sm:text-base text-slate-600 font-medium">Mọi công cụ bạn cần để bứt phá band điểm IELTS mơ ước</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <!-- Feature 1: Test Room -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-card hover:shadow-lg transition duration-200 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-200/60">
                    <i data-lucide="book-open-check" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold font-display text-slate-900">Phòng Thi Tách Đôi (Split-Screen)</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                    Kéo thả điều chỉnh tỷ lệ bài đọc - câu hỏi, đồng hồ đếm ngược, bộ công cụ Highlight và lời giải phân tích Linearthinking.
                </p>
                <a href="{{ route('ielts.index') }}" class="inline-flex items-center text-xs sm:text-sm font-bold text-rose-600 hover:text-rose-700">
                    Khám phá kho đề →
                </a>
            </div>

            <!-- Feature 2: Dictation -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-card hover:shadow-lg transition duration-200 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-200/60">
                    <i data-lucide="headphones" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold font-display text-slate-900">Luyện Nghe Chép Chính Tả</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                    Chép từng câu theo phương pháp ngắt nhịp khoa học, so khớp Levenshtein từng từ và học quy tắc nối âm, nuốt âm.
                </p>
                <a href="{{ route('dictation.index') }}" class="inline-flex items-center text-xs sm:text-sm font-bold text-indigo-600 hover:text-indigo-700">
                    Luyện nghe ngay →
                </a>
            </div>

            <!-- Feature 3: Flashcard SM-2 -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-card hover:shadow-lg transition duration-200 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-200/60">
                    <i data-lucide="layers" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold font-display text-slate-900">Sổ Từ Vựng & Flashcard SM-2</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                    Tra từ 1 chạm trong bài đọc, lưu kèm câu ngữ cảnh gốc và thuật toán SuperMemo SM-2 giúp ghi nhớ vĩnh viễn.
                </p>
                <a href="{{ route('flashcards.index') }}" class="inline-flex items-center text-xs sm:text-sm font-bold text-amber-600 hover:text-amber-700">
                    Ôn tập thẻ nhớ →
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Cambridge Sets -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl sm:text-3xl font-black font-display text-slate-900">Bộ Đề Luyện Thi Nổi Bật</h2>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">Đầy đủ đáp án và phân tích chi tiết</p>
            </div>
            <a href="{{ route('ielts.index') }}" class="text-xs sm:text-sm font-bold text-rose-600 hover:underline">
                Xem tất cả đề →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredTests as $test)
            <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-card hover:shadow-md transition flex flex-col justify-between">
                <div class="p-5 sm:p-6 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-500">
                        <span class="px-2.5 py-0.5 rounded-md bg-rose-50 text-rose-600 uppercase font-extrabold">{{ $test->type }}</span>
                        <span>⏱ {{ $test->duration_minutes }} phút</span>
                    </div>
                    <h3 class="font-bold font-display text-slate-900 text-base leading-snug line-clamp-2">{{ $test->title }}</h3>
                    <p class="text-xs text-slate-500 font-medium">{{ $test->total_questions }} câu hỏi • 40 Band Score</p>
                </div>
                <div class="p-5 sm:p-6 pt-0">
                    <a href="{{ route('ielts.take', ['slug' => $test->slug]) }}" class="w-full py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl text-center block transition shadow-xs">
                        Làm Bài Thi →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
