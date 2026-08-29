@extends('admin.layouts.admin')

@section('title', 'Quản Lý Đề Thi IELTS - Admin CMS')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black font-display text-white">Quản Lý Đề Thi IELTS & TOEIC</h1>
            <p class="text-xs text-slate-400 mt-1">Danh sách đề thi, bài đọc và cấu trúc giải thích Linearthinking</p>
        </div>

        <a href="{{ route('admin.tests.create') }}" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-glow transition flex items-center space-x-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Soạn Thảo Đề Thi Mới</span>
        </a>
    </div>

    <!-- Category Filter Tabs -->
    <div class="flex items-center space-x-2 border-b border-slate-800 pb-4 overflow-x-auto">
        <a href="{{ route('admin.tests.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ !request('category') ? 'bg-rose-600 text-white' : 'bg-slate-900 text-slate-400 hover:text-white' }}">
            Tất Cả Đề Thi ({{ $tests->total() }})
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('admin.tests.index', ['category' => $cat->slug]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request('category') === $cat->slug ? 'bg-rose-600 text-white' : 'bg-slate-900 text-slate-400 hover:text-white' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>

    <!-- Tests List Table -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 p-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4">Tên Đề Thi</th>
                        <th class="py-3 px-4">Bộ Đề</th>
                        <th class="py-3 px-4">Loại Bài</th>
                        <th class="py-3 px-4">Thời Gian</th>
                        <th class="py-3 px-4">Số Câu Hỏi</th>
                        <th class="py-3 px-4">Số Section</th>
                        <th class="py-3 px-4 text-right">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium text-slate-300">
                    @forelse($tests as $test)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3.5 px-4 font-bold text-white">
                            <span class="block">{{ $test->title }}</span>
                            <span class="text-[10px] text-slate-500 font-mono">slug: {{ $test->slug }}</span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-300">{{ $test->testSet->title ?? 'N/A' }}</td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-0.5 rounded-md bg-rose-500/20 text-rose-300 uppercase font-extrabold text-[10px]">
                                {{ $test->type }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">{{ $test->duration_minutes }} phút</td>
                        <td class="py-3.5 px-4 font-bold text-emerald-400">{{ $test->total_questions }} câu</td>
                        <td class="py-3.5 px-4">{{ $test->sections_count }} phần</td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('ielts.take', ['slug' => $test->slug]) }}" target="_blank" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition" title="Xem phòng thi">
                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                </a>
                                <form action="{{ route('admin.tests.destroy', ['id' => $test->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đề thi này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-rose-950/60 hover:bg-rose-900 text-rose-400 hover:text-rose-200 transition" title="Xóa đề">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-slate-500">Chưa có đề thi nào trong danh mục này.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-800">
            {{ $tests->links() }}
        </div>
    </div>
</div>
@endsection
