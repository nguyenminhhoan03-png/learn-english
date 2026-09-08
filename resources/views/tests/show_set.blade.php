@extends('layouts.app')

@section('title', $testSet->title . ' - Chi Tiết Bộ Đề & Tùy Chọn Part')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8" x-data="testSetConfig()">
    <a href="{{ route('ielts.index') }}" class="inline-flex items-center space-x-2 text-sm font-bold text-slate-600 hover:text-slate-900 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        <span>Về kho đề thi</span>
    </a>

    <!-- Set Overview Banner -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col md:flex-row gap-6 sm:gap-8 items-center">
        <img src="{{ $testSet->thumbnail ?: 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80' }}" 
             alt="{{ $testSet->title }}" 
             class="w-full md:w-64 h-48 rounded-2xl object-cover shadow-2xs">
        <div class="space-y-3 flex-1">
            <span class="px-3 py-1 bg-rose-50 text-rose-700 font-extrabold text-xs rounded-full uppercase tracking-wider border border-rose-200/80">
                {{ $testSet->category->name }}
            </span>
            <h1 class="text-2xl sm:text-3xl font-black font-display text-slate-900 leading-tight">{{ $testSet->title }}</h1>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $testSet->description }}</p>
            <div class="flex items-center space-x-4 pt-2 text-xs font-bold text-slate-500">
                <span>📚 {{ $testSet->tests->count() }} Bài thi chuẩn</span>
                <span>•</span>
                <span>🎯 Tùy chọn luyện từng Part</span>
                <span>•</span>
                <span>⚡ Lời giải Linearthinking</span>
            </div>
        </div>
    </div>

    <!-- Tests List in Set -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black font-display text-slate-900">Danh Sách Bài Thi ({{ $testSet->tests->count() }})</h2>
            <span class="text-xs font-bold text-slate-500 hidden sm:inline">Chọn làm Full Test hoặc luyện riêng từng Part</span>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @foreach($testSet->tests as $test)
            @php
                $sectionsData = $test->sections->map(function($sec) {
                    $qCount = $sec->questionGroups->flatMap(fn($g) => $g->questions)->count();
                    return [
                        'id' => $sec->id,
                        'number' => $sec->section_number,
                        'title' => $sec->title,
                        'question_count' => $qCount,
                    ];
                });
            @endphp
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs hover:shadow-md transition space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-0.5 rounded-md bg-rose-50 text-rose-600 border border-rose-200 text-xs font-extrabold uppercase">
                                {{ $test->type }}
                            </span>
                            <span class="text-xs text-slate-400 font-semibold">⏱ {{ $test->duration_minutes }} phút • {{ $test->sections->flatMap(fn($s)=>$s->questionGroups->flatMap(fn($g)=>$g->questions))->count() ?: $test->total_questions }} câu hỏi</span>
                        </div>
                        <h3 class="text-lg font-black font-display text-slate-900 mt-1">{{ $test->title }}</h3>
                    </div>

                    <div class="flex items-center space-x-2.5 w-full sm:w-auto">
                        <button type="button" 
                                @click="openConfigModal('{{ $test->slug }}', '{{ addslashes($test->title) }}', {{ json_encode($sectionsData) }}, {{ $test->duration_minutes }})"
                                class="flex-1 sm:flex-none px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-extrabold text-xs rounded-xl transition text-center flex items-center justify-center space-x-1.5 cursor-pointer">
                            <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5 text-slate-600"></i>
                            <span>Tùy Chọn Part</span>
                        </button>
                        <a href="{{ route('ielts.take', ['slug' => $test->slug, 'mode' => 'full_test']) }}" 
                           class="flex-1 sm:flex-none px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs rounded-xl shadow-glow transition text-center flex items-center justify-center space-x-1.5 cursor-pointer">
                            <i data-lucide="play" class="w-3.5 h-3.5"></i>
                            <span>Thi Thử Full Test</span>
                        </a>
                    </div>
                </div>

                <!-- Individual Part Pills (Direct 1-Click Practice) -->
                @if($test->sections->count() > 0)
                <div class="pt-3 border-t border-slate-100">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Các phần thi trong đề (Bấm để luyện riêng):</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($test->sections as $sec)
                        @php
                            $secQCount = $sec->questionGroups->flatMap(fn($g)=>$g->questions)->count();
                        @endphp
                        <a href="{{ route('ielts.take', ['slug' => $test->slug, 'mode' => 'practice', 'parts' => $sec->section_number]) }}" 
                           class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-300 text-slate-700 hover:text-indigo-700 text-xs font-bold transition group">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-slate-400 group-hover:text-indigo-600"></i>
                            <span>{{ Str::limit($sec->title, 36) }}</span>
                            <span class="px-1.5 py-0.2 rounded-md bg-white border border-slate-200 text-[10px] font-mono text-slate-600 group-hover:border-indigo-200 group-hover:text-indigo-700">
                                {{ $secQCount }} câu
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- Part Selection & Test Configuration Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full shadow-2xl border border-slate-200 overflow-hidden animate-pop" 
             @click.outside="showModal = false">
            
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-900 to-slate-800 text-white">
                <div>
                    <span class="px-2 py-0.5 rounded bg-rose-600 text-white font-mono text-[10px] font-bold uppercase tracking-wide">Cấu hình bài thi</span>
                    <h3 class="text-base sm:text-lg font-black font-display text-white mt-1 leading-tight" x-text="activeTestTitle"></h3>
                </div>
                <button @click="showModal = false" class="p-1.5 rounded-xl text-slate-400 hover:text-white hover:bg-white/10 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-6">
                <!-- Select All / Clear Quick Actions -->
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Tích chọn phần bạn muốn làm:</span>
                    <div class="flex items-center space-x-2 text-xs font-bold">
                        <button type="button" @click="selectAllParts()" class="text-rose-600 hover:underline">Chọn tất cả</button>
                        <span class="text-slate-300">•</span>
                        <button type="button" @click="clearParts()" class="text-slate-500 hover:underline">Bỏ chọn</button>
                    </div>
                </div>

                <!-- Parts Checkboxes List -->
                <div class="space-y-2.5 max-h-60 overflow-y-auto pr-1">
                    <template x-for="sec in activeSections" :key="sec.id">
                        <label class="flex items-center justify-between p-3.5 rounded-2xl border transition cursor-pointer select-none"
                               :class="selectedParts.includes(sec.number) ? 'border-rose-500 bg-rose-50/70 text-rose-950 font-bold shadow-2xs' : 'border-slate-200 hover:border-slate-300 bg-white text-slate-800'">
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" 
                                       :value="sec.number" 
                                       x-model="selectedParts" 
                                       class="rounded text-rose-600 focus:ring-rose-500 w-4 h-4">
                                <div>
                                    <p class="text-xs font-bold leading-tight" x-text="sec.title"></p>
                                    <p class="text-[11px] text-slate-400 font-medium mt-0.5" x-text="`Phần ${sec.number}`"></p>
                                </div>
                            </div>
                            <span class="text-xs px-2.5 py-1 rounded-xl bg-white border border-slate-200 text-slate-700 font-mono font-bold flex-shrink-0"
                                  x-text="`${sec.question_count} câu`"></span>
                        </label>
                    </template>
                </div>

                <!-- Summary Box -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 grid grid-cols-2 gap-4 text-center">
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Số câu hỏi đã chọn</p>
                        <p class="text-xl font-black text-slate-900 mt-0.5" x-text="`${totalSelectedQuestions} câu`"></p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Thời gian gợi ý</p>
                        <p class="text-xl font-black text-indigo-600 mt-0.5" x-text="`${suggestedMinutes} phút`"></p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-5 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                <button type="button" @click="showModal = false" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-100 transition">
                    Hủy bỏ
                </button>
                <button type="button" 
                        @click="startPractice()" 
                        :disabled="selectedParts.length === 0"
                        class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 disabled:bg-slate-300 text-white font-extrabold text-xs shadow-glow transition flex items-center space-x-1.5 cursor-pointer">
                    <i data-lucide="play" class="w-3.5 h-3.5"></i>
                    <span>Bắt Đầu Làm Bài Ngay →</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function testSetConfig() {
    return {
        showModal: false,
        activeTestSlug: '',
        activeTestTitle: '',
        activeSections: [],
        activeFullMinutes: 60,
        selectedParts: [],

        openConfigModal(slug, title, sections, minutes) {
            this.activeTestSlug = slug;
            this.activeTestTitle = title;
            this.activeSections = sections;
            this.activeFullMinutes = minutes;
            // Default select all
            this.selectedParts = sections.map(s => s.number);
            this.showModal = true;
            this.$nextTick(() => {
                if (window.lucide) window.lucide.createIcons();
            });
        },

        selectAllParts() {
            this.selectedParts = this.activeSections.map(s => s.number);
        },

        clearParts() {
            this.selectedParts = [];
        },

        get totalSelectedQuestions() {
            return this.activeSections
                .filter(s => this.selectedParts.includes(s.number))
                .reduce((sum, s) => sum + s.question_count, 0);
        },

        get suggestedMinutes() {
            if (this.selectedParts.length === this.activeSections.length) {
                return this.activeFullMinutes;
            }
            // Roughly 1.5 minutes per selected question
            return Math.max(5, Math.round(this.totalSelectedQuestions * 1.5));
        },

        startPractice() {
            if (this.selectedParts.length === 0) return;
            const partsParam = this.selectedParts.sort().join(',');
            window.location.href = `/luyen-thi-ielts/take/${this.activeTestSlug}?mode=practice&parts=${partsParam}`;
        }
    };
}
</script>
@endpush

