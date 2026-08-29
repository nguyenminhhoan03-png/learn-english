@extends('admin.layouts.admin')

@section('title', 'Quản Lý Nghe Chép Chính Tả - Admin CMS')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black font-display text-white">Quản Lý Bài Nghe Chép Chính Tả (Dictation)</h1>
            <p class="text-xs text-slate-400 mt-1">Danh sách audio bài nghe, chia đoạn và phiên âm nối âm</p>
        </div>
        <a href="{{ route('admin.dictation.create') }}" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-glow transition flex items-center space-x-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tải Lên Bài Nghe Mới</span>
        </a>
    </div>

    <div class="bg-slate-900 rounded-3xl border border-slate-800 p-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4">Tiêu Đề</th>
                        <th class="py-3 px-4">Chủ Đề</th>
                        <th class="py-3 px-4">Cấp Độ</th>
                        <th class="py-3 px-4">Thời Lượng</th>
                        <th class="py-3 px-4">Số Câu</th>
                        <th class="py-3 px-4 text-right">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium text-slate-300">
                    @forelse($topics as $topic)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3.5 px-4 font-bold text-white">{{ $topic->title }}</td>
                        <td class="py-3.5 px-4">{{ $topic->category }}</td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-0.5 rounded-md bg-indigo-500/20 text-indigo-300 font-extrabold text-[10px]">
                                {{ $topic->level }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-mono">{{ $topic->duration_seconds }}s</td>
                        <td class="py-3.5 px-4 font-bold text-emerald-400">{{ $topic->sentences_count }} câu</td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('dictation.practice', ['slug' => $topic->slug]) }}" target="_blank" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition">
                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                </a>
                                <form action="{{ route('admin.dictation.destroy', ['id' => $topic->id]) }}" method="POST" onsubmit="return confirm('Xóa bài nghe này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-rose-950/60 hover:bg-rose-900 text-rose-400 transition">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-slate-500">Chưa có bài nghe nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
