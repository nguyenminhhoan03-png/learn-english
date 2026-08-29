@extends('admin.layouts.admin')

@section('title', 'Lịch Sử Nộp Bài Thi - Admin CMS')

@section('content')
<div class="space-y-8">
    <div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-400 hover:text-white mb-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Về Dashboard</span>
        </a>
        <h1 class="text-2xl font-black font-display text-white">Toàn Bộ Lịch Sử Nộp Bài Thi & Chấm Điểm</h1>
        <p class="text-xs text-slate-400 mt-1">Danh sách tất cả bài thi IELTS được học viên nộp trên hệ thống</p>
    </div>

    <div class="bg-slate-900 rounded-3xl border border-slate-800 p-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 uppercase text-[10px]">
                        <th class="py-3 px-4">Học Viên</th>
                        <th class="py-3 px-4">Đề Thi</th>
                        <th class="py-3 px-4">Thời Gian Làm</th>
                        <th class="py-3 px-4">Số Câu Đúng</th>
                        <th class="py-3 px-4">Band Score</th>
                        <th class="py-3 px-4">Nộp Lúc</th>
                        <th class="py-3 px-4 text-right">Chi Tiết</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium text-slate-300">
                    @forelse($submissions as $sub)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3.5 px-4 font-bold text-white flex items-center space-x-2">
                            <img src="{{ $sub->user->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=80&q=80' }}" class="w-7 h-7 rounded-lg object-cover">
                            <span>{{ $sub->user->name }}</span>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-slate-200">{{ $sub->test->title }}</td>
                        <td class="py-3.5 px-4 font-mono">{{ gmdate("i:s", $sub->time_spent_seconds) }}</td>
                        <td class="py-3.5 px-4">{{ $sub->score_raw }}/{{ $sub->test->total_questions }} câu</td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-md bg-rose-500/20 text-rose-300 font-extrabold text-xs border border-rose-500/30">
                                Band {{ number_format($sub->band_score, 1) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-400">{{ $sub->created_at->format('H:i d/m/Y') }}</td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="{{ route('ielts.result', ['submission_id' => $sub->id]) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-rose-400 font-bold text-[11px] transition">
                                Xem Kết Quả →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-slate-500">Chưa có bài thi nào được nộp.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-800">
            {{ $submissions->links() }}
        </div>
    </div>
</div>
@endsection
