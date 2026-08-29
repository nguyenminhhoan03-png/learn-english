@extends('admin.layouts.admin')

@section('title', 'Quản Lý Học Viên - Admin CMS')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black font-display text-white">Quản Lý Học Viên & Quyền Hạn</h1>
            <p class="text-xs text-slate-400 mt-1">Danh sách người dùng, chuỗi học liên tục (Streak), điểm thưởng XP và phân quyền.</p>
        </div>
    </div>

    <!-- Search bar -->
    <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center space-x-3">
        <input type="text" name="search" value="{{ $search }}" placeholder="Tìm kiếm theo tên hoặc email học viên..." class="px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs w-80">
        <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-xl">Tìm</button>
    </form>

    <!-- Table -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 p-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 uppercase text-[10px]">
                        <th class="py-3 px-4">Học Viên</th>
                        <th class="py-3 px-4">Vai Trò</th>
                        <th class="py-3 px-4">Target Band</th>
                        <th class="py-3 px-4">Streak Ngày</th>
                        <th class="py-3 px-4">Điểm XP</th>
                        <th class="py-3 px-4">Đã Thi</th>
                        <th class="py-3 px-4 text-right">Phân Quyền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium text-slate-300">
                    @forelse($users as $u)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3.5 px-4 font-bold text-white flex items-center space-x-2.5">
                            <img src="{{ $u->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=80&q=80' }}" class="w-8 h-8 rounded-xl object-cover">
                            <div>
                                <p class="text-xs font-bold text-white">{{ $u->name }}</p>
                                <p class="text-[10px] text-slate-400 font-mono">{{ $u->email }}</p>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $u->role === 'admin' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : 'bg-slate-800 text-slate-300' }}">
                                {{ $u->role }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-amber-400">Band {{ $u->target_band }}</td>
                        <td class="py-3.5 px-4 font-bold text-orange-400">🔥 {{ $u->streak_count }} ngày</td>
                        <td class="py-3.5 px-4 font-bold text-indigo-400">⚡ {{ $u->xp_points }} XP</td>
                        <td class="py-3.5 px-4 font-bold text-emerald-400">{{ $u->submissions_count }} bài</td>
                        <td class="py-3.5 px-4 text-right">
                            <form action="{{ route('admin.users.toggle_role', ['id' => $u->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-[11px] font-bold transition">
                                    {{ $u->role === 'admin' ? 'Chuyển về Học viên' : 'Nâng cấp Admin' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-slate-500">Chưa có người dùng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-800">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
