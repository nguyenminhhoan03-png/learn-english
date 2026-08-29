@extends('admin.layouts.admin')

@section('title', 'Quản Lý Bài Mẫu Band 8.0+ - Admin CMS')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black font-display text-white">Kho Bài Mẫu IELTS Writing & Speaking</h1>
            <p class="text-xs text-slate-400 mt-1">Quản lý dàn bài Linearthinking, bài mẫu Band 8.0+ và bộ từ vựng collocation</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.samples.create_writing') }}" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-glow transition flex items-center space-x-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Thêm Bài Mẫu Writing</span>
            </a>
            <a href="{{ route('admin.samples.create_speaking') }}" class="px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl transition flex items-center space-x-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Thêm Bài Mẫu Speaking</span>
            </a>
        </div>
    </div>

    <!-- Writing Samples Section -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 p-6 space-y-4">
        <h2 class="text-base font-bold text-white flex items-center space-x-2">
            <i data-lucide="file-text" class="w-4 h-4 text-rose-400"></i>
            <span>Bài Mẫu IELTS Writing (Task 1 & Task 2)</span>
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 uppercase text-[10px]">
                        <th class="py-3 px-4">Tiêu Đề</th>
                        <th class="py-3 px-4">Loại Task</th>
                        <th class="py-3 px-4">Band Score</th>
                        <th class="py-3 px-4 text-right">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium text-slate-300">
                    @forelse($writingSamples as $w)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3.5 px-4 font-bold text-white">{{ $w->title }}</td>
                        <td class="py-3.5 px-4 uppercase text-[10px] font-extrabold text-rose-400">{{ $w->task_type }}</td>
                        <td class="py-3.5 px-4 font-bold text-emerald-400">Band {{ $w->band_score }}</td>
                        <td class="py-3.5 px-4 text-right">
                            <form action="{{ route('admin.samples.destroy_writing', ['id' => $w->id]) }}" method="POST" onsubmit="return confirm('Xóa bài mẫu này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg bg-rose-950/60 text-rose-400 hover:text-rose-200">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-slate-500">Chưa có bài mẫu Writing nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Speaking Samples Section -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 p-6 space-y-4">
        <h2 class="text-base font-bold text-white flex items-center space-x-2">
            <i data-lucide="mic" class="w-4 h-4 text-amber-400"></i>
            <span>Bài Mẫu IELTS Speaking (Part 1, 2, 3)</span>
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 uppercase text-[10px]">
                        <th class="py-3 px-4">Chủ Đề (Topic)</th>
                        <th class="py-3 px-4">Part</th>
                        <th class="py-3 px-4">Band Score</th>
                        <th class="py-3 px-4 text-right">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium text-slate-300">
                    @forelse($speakingSamples as $s)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3.5 px-4 font-bold text-white">{{ $s->topic }}</td>
                        <td class="py-3.5 px-4 uppercase text-[10px] font-extrabold text-amber-400">{{ $s->part }}</td>
                        <td class="py-3.5 px-4 font-bold text-emerald-400">Band {{ $s->band_score }}</td>
                        <td class="py-3.5 px-4 text-right">
                            <form action="{{ route('admin.samples.destroy_speaking', ['id' => $s->id]) }}" method="POST" onsubmit="return confirm('Xóa bài mẫu này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg bg-rose-950/60 text-rose-400 hover:text-rose-200">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-slate-500">Chưa có bài mẫu Speaking nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
