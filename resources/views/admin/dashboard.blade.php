@extends('admin.layouts.admin')

@section('title', 'Bảng Điều Khiển Quản Trị - LearnEnglish CMS')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black font-display text-white">Tổng Quan Hệ Thống (CMS Dashboard)</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Giám sát số liệu học tập, quản lý kho đề thi và tài nguyên học liệu.</p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.tests.create') }}" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-glow transition flex items-center space-x-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tạo Đề Thi Mới</span>
            </a>
            <a href="{{ route('admin.dictation.create') }}" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-xl transition flex items-center space-x-2">
                <i data-lucide="headphones" class="w-4 h-4 text-indigo-400"></i>
                <span>Thêm Bài Dictation</span>
            </a>
        </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Students -->
        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400">
                <span>TỔNG HỌC VIÊN</span>
                <i data-lucide="users" class="w-4 h-4 text-indigo-400"></i>
            </div>
            <p class="text-3xl font-black text-white font-display">{{ number_format($stats['total_students']) }}</p>
            <p class="text-[11px] font-semibold text-emerald-400">✓ Đang hoạt động</p>
        </div>

        <!-- Card 2: Tests -->
        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400">
                <span>ĐỀ THI TRONG KHO</span>
                <i data-lucide="book-open" class="w-4 h-4 text-rose-400"></i>
            </div>
            <p class="text-3xl font-black text-rose-500 font-display">{{ $stats['total_tests'] }}</p>
            <p class="text-[11px] font-semibold text-slate-400">Cambridge 10 - 19</p>
        </div>

        <!-- Card 3: Submissions -->
        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400">
                <span>LƯỢT NỘP BÀI THI</span>
                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
            </div>
            <p class="text-3xl font-black text-emerald-400 font-display">{{ number_format($stats['total_submissions']) }}</p>
            <p class="text-[11px] font-semibold text-slate-400">Đã chấm điểm tự động</p>
        </div>

        <!-- Card 4: Avg Band -->
        <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-xs font-bold text-slate-400">
                <span>BAND SCORE TRUNG BÌNH</span>
                <i data-lucide="award" class="w-4 h-4 text-amber-400"></i>
            </div>
            <p class="text-3xl font-black text-amber-400 font-display">{{ $stats['avg_band_score'] }}</p>
            <p class="text-[11px] font-semibold text-slate-400">IELTS Academic</p>
        </div>
    </div>

    <!-- Quick Management Hub -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.tests.index') }}" class="p-6 rounded-3xl bg-slate-900 hover:bg-slate-800/80 border border-slate-800 transition flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-500/20 text-rose-400 flex items-center justify-center flex-shrink-0">
                <i data-lucide="book-open-check" class="w-6 h-6"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-white">Quản Lý Đề Thi IELTS</h4>
                <p class="text-xs text-slate-400">{{ $stats['total_tests'] }} Đề thi • Phân tích Linearthinking</p>
            </div>
        </a>

        <a href="{{ route('admin.dictation.index') }}" class="p-6 rounded-3xl bg-slate-900 hover:bg-slate-800/80 border border-slate-800 transition flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center flex-shrink-0">
                <i data-lucide="headphones" class="w-6 h-6"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-white">Quản Lý Nghe Chép Chính Tả</h4>
                <p class="text-xs text-slate-400">{{ $stats['total_dictation_topics'] }} Bài audio • Timestamps</p>
            </div>
        </a>

        <a href="{{ route('admin.samples.index') }}" class="p-6 rounded-3xl bg-slate-900 hover:bg-slate-800/80 border border-slate-800 transition flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center flex-shrink-0">
                <i data-lucide="file-text" class="w-6 h-6"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-white">Quản Lý Bài Mẫu Band 8.0+</h4>
                <p class="text-xs text-slate-400">{{ $stats['total_writing_samples'] }} Bài Writing & Speaking</p>
            </div>
        </a>
    </div>

    <!-- Recent Submissions Table -->
    <div class="p-6 sm:p-8 rounded-3xl bg-slate-900 border border-slate-800 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black font-display text-white">Lịch Sử Nộp Bài Thi Mới Nhất</h2>
                <p class="text-xs text-slate-400">Kết quả chấm điểm IELTS thời gian thực</p>
            </div>
            <a href="{{ route('admin.users.submissions') }}" class="text-xs font-bold text-rose-400 hover:underline">
                Xem tất cả bài nộp →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4">Học Viên</th>
                        <th class="py-3 px-4">Đề Thi</th>
                        <th class="py-3 px-4">Thời Gian Làm</th>
                        <th class="py-3 px-4">Số Câu Đúng</th>
                        <th class="py-3 px-4">Band Score</th>
                        <th class="py-3 px-4">Nộp Lúc</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium text-slate-300">
                    @forelse($recentSubmissions as $sub)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3 px-4 font-bold text-white flex items-center space-x-2">
                            <img src="{{ $sub->user->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=80&q=80' }}" class="w-6 h-6 rounded-lg object-cover">
                            <span>{{ $sub->user->name }}</span>
                        </td>
                        <td class="py-3 px-4">{{ $sub->test->title }}</td>
                        <td class="py-3 px-4 font-mono">{{ gmdate("i:s", $sub->time_spent_seconds) }}</td>
                        <td class="py-3 px-4">{{ $sub->score_raw }} câu</td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-1 rounded-md bg-rose-500/20 text-rose-300 font-extrabold text-xs border border-rose-500/30">
                                Band {{ number_format($sub->band_score, 1) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-slate-400">{{ $sub->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-slate-500">Chưa có bài thi nào được nộp.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
