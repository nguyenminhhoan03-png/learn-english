@extends('layouts.app')

@section('title', 'Phiên Ôn Tập Thẻ Từ Vựng SM-2')

@section('content')
<div x-data="flashcardSession()" class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('flashcards.index') }}" class="inline-flex items-center space-x-2 text-sm font-bold text-slate-600 hover:text-slate-900">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Về sổ từ vựng</span>
        </a>
        <div class="text-xs font-bold text-slate-500">
            Thẻ: <span class="text-rose-600 font-extrabold text-sm" x-text="currentIndex + 1">1</span>/{{ $dueCards->count() }}
        </div>
    </div>

    @if($dueCards->isEmpty())
    <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm space-y-4">
        <span class="text-5xl">🎉</span>
        <h2 class="text-2xl font-extrabold text-slate-900">Bạn đã hoàn thành tất cả thẻ cần ôn hôm nay!</h2>
        <p class="text-sm text-slate-500">Hãy quay lại vào ngày mai để tiếp tục chu kỳ ghi nhớ ngắt quãng SM-2.</p>
        <a href="{{ route('flashcards.index') }}" class="inline-block px-6 py-3 bg-slate-900 text-white font-bold rounded-xl text-sm mt-4">
            Quay Về Danh Sách Thẻ
        </a>
    </div>
    @else

    <!-- 3D Flashcard Container -->
    <div class="relative w-full h-96 perspective-1000 cursor-pointer select-none" @click="isFlipped = !isFlipped">
        <div class="w-full h-full duration-500 transform-style-3d relative transition-transform rounded-3xl shadow-xl border border-slate-200"
             :class="{'rotate-y-180': isFlipped}">
            
            <!-- FRONT SIDE -->
            <div class="absolute inset-0 w-full h-full bg-white rounded-3xl p-8 flex flex-col justify-between items-center text-center backface-hidden">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400">MẶT TRƯỚC (NHẤP ĐỂ LẬT NGHĨA)</span>
                
                <div class="space-y-3">
                    <h2 class="text-4xl font-black text-slate-900 tracking-tight" x-text="currentCard.vocabulary.word"></h2>
                    <p class="text-sm font-mono text-rose-600" x-text="currentCard.vocabulary.phonetic_us || currentCard.vocabulary.phonetic_uk"></p>
                </div>

                <div class="flex items-center space-x-2 text-xs font-semibold text-slate-400">
                    <i data-lucide="rotate-cw" class="w-4 h-4"></i>
                    <span>Bấm vào thẻ để xem nghĩa</span>
                </div>
            </div>

            <!-- BACK SIDE -->
            <div class="absolute inset-0 w-full h-full bg-slate-900 text-white rounded-3xl p-8 flex flex-col justify-between items-center text-center rotate-y-180 backface-hidden">
                <span class="text-xs font-bold uppercase tracking-widest text-rose-400">MẶT SAU (Ý NGHĨA & NGỮ CẢNH)</span>
                
                <div class="space-y-4 max-w-md">
                    <h3 class="text-2xl font-bold text-white" x-text="currentCard.vocabulary.definition_vi"></h3>
                    <p class="text-xs text-slate-300 italic" x-text="`&ldquo;${currentCard.context_sentence || currentCard.vocabulary.example_sentence || ''}&rdquo;`"></p>
                </div>

                <div class="text-xs text-slate-400 font-mono">
                    Thuật toán SM-2: Tính toán ngày ôn tiếp theo
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Buttons (SM-2 Grades: 0 = Blackout, 1 = Hard, 2 = Good, 3 = Easy) -->
    <div class="space-y-3" x-show="isFlipped" x-transition>
        <p class="text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Đánh giá mức độ ghi nhớ của bạn:</p>
        <div class="grid grid-cols-4 gap-3">
            <button @click="submitGrade(0)" class="p-3 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-2xl font-bold text-xs border border-rose-200 transition">
                <span>0. Quên hẳn</span>
                <span class="block text-[10px] font-normal text-rose-500 mt-0.5">Ôn lại ngay</span>
            </button>
            <button @click="submitGrade(1)" class="p-3 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-2xl font-bold text-xs border border-amber-200 transition">
                <span>1. Khó nhớ</span>
                <span class="block text-[10px] font-normal text-amber-500 mt-0.5">1 ngày sau</span>
            </button>
            <button @click="submitGrade(2)" class="p-3 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-2xl font-bold text-xs border border-indigo-200 transition">
                <span>2. Nhớ tốt</span>
                <span class="block text-[10px] font-normal text-indigo-500 mt-0.5">3-6 ngày sau</span>
            </button>
            <button @click="submitGrade(3)" class="p-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-2xl font-bold text-xs border border-emerald-200 transition">
                <span>3. Quá dễ</span>
                <span class="block text-[10px] font-normal text-emerald-500 mt-0.5">10+ ngày sau</span>
            </button>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.perspective-1000 { perspective: 1000px; }
.transform-style-3d { transform-style: preserve-3d; }
.backface-hidden { backface-visibility: hidden; -webkit-backface-visibility: hidden; }
.rotate-y-180 { transform: rotateY(180deg); }
</style>
@endpush

@push('scripts')
<script>
function flashcardSession() {
    return {
        cards: @json($dueCards),
        currentIndex: 0,
        isFlipped: false,

        get currentCard() {
            return this.cards[this.currentIndex] || {};
        },

        async submitGrade(grade) {
            try {
                await fetch('/api/flashcards/submit-review', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        card_id: this.currentCard.id,
                        grade: grade
                    })
                });

                if (this.currentIndex < this.cards.length - 1) {
                    this.isFlipped = false;
                    this.currentIndex++;
                } else {
                    window.fireConfetti?.({ particleCount: 100, spread: 80, origin: { y: 0.6 } });
                    alert('🎉 Hoàn thành phiên ôn tập Flashcard hôm nay!');
                    window.location.href = "{{ route('flashcards.index') }}";
                }
            } catch (err) {
                alert('Có lỗi xảy ra khi lưu đánh giá.');
            }
        }
    };
}
</script>
@endpush
