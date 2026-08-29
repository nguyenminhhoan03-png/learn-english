@extends('layouts.app')

@section('title', 'Bảng Điều Khiển & Phân Tích Tiến Độ - EduLearn')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- User Profile & Target Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-rose-950 text-white rounded-3xl p-8 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center space-x-5">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=160&q=80" alt="Avatar" class="w-20 h-20 rounded-2xl object-cover ring-4 ring-rose-500/30 shadow-lg">
            <div class="space-y-1">
                <div class="flex items-center space-x-2">
                    <h1 class="text-2xl font-black">{{ $user->name }}</h1>
                    <span class="px-2.5 py-0.5 rounded-full bg-rose-500/20 text-rose-300 text-xs font-bold uppercase border border-rose-500/30">Target: Band {{ $user->target_band }}</span>
                </div>
                <p class="text-xs text-slate-300">{{ $user->email }} • Tham gia từ tháng {{ $user->created_at->format('m/Y') }}</p>
            </div>
        </div>

        <div class="flex items-center space-x-6">
            <!-- Streak -->
            <div class="text-center p-4 bg-white/10 rounded-2xl backdrop-blur-md border border-white/10">
                <span class="text-2xl">🔥</span>
                <p class="text-2xl font-black text-amber-400">{{ $user->streak_count }}</p>
                <p class="text-[10px] font-bold uppercase text-slate-300">Ngày Streak</p>
            </div>
            <!-- XP -->
            <div class="text-center p-4 bg-white/10 rounded-2xl backdrop-blur-md border border-white/10">
                <span class="text-2xl">⚡</span>
                <p class="text-2xl font-black text-indigo-400">{{ $user->xp_points }}</p>
                <p class="text-[10px] font-bold uppercase text-slate-300">Điểm XP</p>
            </div>
            <!-- Flashcards -->
            <div class="text-center p-4 bg-white/10 rounded-2xl backdrop-blur-md border border-white/10">
                <span class="text-2xl">📚</span>
                <p class="text-2xl font-black text-emerald-400">{{ $vocabCount }}</p>
                <p class="text-[10px] font-bold uppercase text-slate-300">Từ Đã Lưu</p>
            </div>
        </div>
    </div>

    <!-- Weakness Radar & Study Insights Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Weakness Radar Chart (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Biểu Đồ Radar Điểm Yếu & Năng Lực</h2>
                    <p class="text-xs text-slate-500">Phân tích tỷ lệ chính xác theo từng dạng bài IELTS</p>
                </div>
                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 font-bold text-xs rounded-full">AI Analytics</span>
            </div>

            <!-- Radar Container -->
            <div id="radar-chart" class="w-full h-80"></div>

            <!-- Skill diagnosis -->
            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100 text-xs">
                <div class="p-3 bg-rose-50 rounded-2xl border border-rose-100">
                    <span class="font-bold text-rose-700 uppercase block text-[10px]">Cần Cải Thiện Nhất:</span>
                    <strong class="text-slate-900 text-sm">{{ $radarData['weakest_skill'] }}</strong>
                </div>
                <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <span class="font-bold text-emerald-700 uppercase block text-[10px]">Kỹ Năng Thế Mạnh:</span>
                    <strong class="text-slate-900 text-sm">{{ $radarData['strongest_skill'] }}</strong>
                </div>
            </div>
        </div>

        <!-- Recent Test History (5 cols) -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Lịch Sử Thi Gần Đây</h2>

            <div class="space-y-4">
                @forelse($recentSubmissions as $sub)
                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50 hover:bg-white hover:shadow-xs transition flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm line-clamp-1">{{ $sub->test->title }}</h4>
                        <p class="text-xs text-slate-400">{{ $sub->created_at->diffForHumans() }} • {{ gmdate("i:s", $sub->time_spent_seconds) }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-2.5 py-1 bg-rose-100 text-rose-700 font-black text-xs rounded-lg">Band {{ number_format($sub->band_score, 1) }}</span>
                        <a href="{{ route('ielts.result', ['submission_id' => $sub->id]) }}" class="block text-[11px] font-bold text-slate-500 hover:text-rose-600 mt-1">Xem lại →</a>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-400 text-sm">
                    Bạn chưa hoàn thành bài thi nào. Hãy bắt đầu làm bài thi đầu tiên!
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', async function () {
    const radarOptions = {
        series: [{
            name: 'Độ chính xác (%)',
            data: @json($radarData['series']),
        }],
        chart: {
            height: 320,
            type: 'radar',
            toolbar: { show: false }
        },
        colors: ['#E11D48'],
        markers: {
            size: 4,
            colors: ['#BE123C'],
            strokeColors: '#fff',
            strokeWidth: 2
        },
        fill: {
            opacity: 0.25
        },
        xaxis: {
            categories: @json($radarData['labels']),
            labels: {
                style: {
                    colors: ['#475569', '#475569', '#475569', '#475569', '#475569', '#475569'],
                    fontSize: '12px',
                    fontFamily: 'Be Vietnam Pro, sans-serif',
                    fontWeight: 600
                }
            }
        },
        yaxis: {
            show: false,
            min: 0,
            max: 100
        }
    };

    if (window.loadChart) {
        const ApexCharts = await window.loadChart();
        const chartEl = document.querySelector("#radar-chart");
        if (chartEl && ApexCharts) {
            const chart = new ApexCharts(chartEl, radarOptions);
            chart.render();
        }
    }
});
</script>
@endpush
