@extends('layouts.app')

@section('title', 'Luyện Nghe Chép Chính Tả - ' . $topic->title)

@section('content')
<div x-data="dictationStudio()" x-init="initAudio()" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    
    <!-- Top Navigation Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('dictation.index') }}" class="inline-flex items-center space-x-2 text-xs sm:text-sm font-bold text-slate-700 hover:text-slate-900 transition">
            <i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i>
            <span>Trở lại danh sách bài nghe</span>
        </a>
        <div class="text-xs font-bold text-slate-700 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200">
            Tiến độ: <span class="text-rose-700 font-extrabold text-sm" x-text="currentIndex + 1">1</span>/{{ $topic->sentences->count() }} câu
        </div>
    </div>

    <!-- Audio Player Controller Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
            <div>
                <span class="px-2.5 py-0.5 rounded-md bg-indigo-100 text-indigo-900 text-[11px] font-extrabold uppercase tracking-wide">{{ $topic->category }}</span>
                <h1 class="text-xl sm:text-2xl font-black font-display text-slate-900 mt-1">{{ $topic->title }}</h1>
            </div>
            <!-- Audio Speed Selector -->
            <div class="flex items-center space-x-1 bg-slate-100 p-1 rounded-2xl text-xs font-bold text-slate-800 self-start sm:self-auto border border-slate-200/80">
                <template x-for="spd in [0.75, 1.0, 1.25]" :key="spd">
                    <button @click="setSpeed(spd)" 
                            :class="playbackSpeed === spd ? 'bg-white text-slate-950 shadow-xs' : 'text-slate-700 hover:text-slate-900'" 
                            class="px-3 py-1.5 rounded-xl transition font-bold" 
                            x-text="`${spd}x`">
                    </button>
                </template>
            </div>
        </div>

        <!-- Custom Audio Controls Bar -->
        <div class="bg-slate-950 text-white rounded-3xl p-6 flex flex-col sm:flex-row items-center justify-between gap-5 shadow-inner">
            <button @click="togglePlay()" 
                    aria-label="Phát hoặc tạm dừng câu audio hiện tại"
                    class="w-16 h-16 rounded-2xl bg-rose-600 hover:bg-rose-500 text-white flex items-center justify-center shadow-glow transition transform hover:scale-105 active:scale-95 flex-shrink-0 cursor-pointer">
                <i data-lucide="play" class="w-7 h-7 fill-current" x-show="!isPlaying" aria-hidden="true"></i>
                <i data-lucide="pause" class="w-7 h-7 fill-current" x-show="isPlaying" style="display: none;" aria-hidden="true"></i>
            </button>

            <!-- Progress Bar / Time Indicators -->
            <div class="flex-1 w-full space-y-2">
                <div class="flex items-center justify-between text-xs font-mono text-slate-400">
                    <span class="text-slate-200 font-bold" x-text="`Câu ${currentIndex + 1} (${currentSentence.audio_start_time || 0}s - ${currentSentence.audio_end_time || 5}s)`"></span>
                    <span class="text-rose-400 font-bold uppercase tracking-wider text-[10px] bg-rose-950/60 px-2 py-0.5 rounded-md border border-rose-800/40">A-B Repeat Mode</span>
                </div>
                <div class="w-full h-2.5 bg-slate-800 rounded-full overflow-hidden cursor-pointer" @click="replaySentence()">
                    <div class="h-full bg-gradient-to-r from-rose-500 to-rose-400 rounded-full transition-all duration-100" :style="`width: ${sentenceProgress}%`"></div>
                </div>
            </div>

            <!-- Replay Hotkey Button -->
            <button @click="replaySentence()" 
                    aria-label="Nghe lại câu hiện tại"
                    class="w-full sm:w-auto px-4 py-3 bg-slate-800 hover:bg-slate-700 rounded-2xl text-xs font-bold transition flex items-center justify-center space-x-2 text-slate-200 hover:text-white flex-shrink-0 cursor-pointer">
                <i data-lucide="rotate-ccw" class="w-4 h-4 text-slate-400" aria-hidden="true"></i>
                <span>Nghe lại (Space)</span>
            </button>
        </div>

        <!-- Typing Keystroke Area -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <label for="dictation-input" class="block text-sm font-black text-slate-900">
                    Gõ lại những gì bạn nghe được:
                </label>
                <button @click="showHint = !showHint" type="button" class="text-xs font-bold text-indigo-700 hover:text-indigo-900 transition flex items-center space-x-1">
                    <i data-lucide="help-circle" class="w-3.5 h-3.5" aria-hidden="true"></i>
                    <span x-text="showHint ? 'Ẩn gợi ý' : 'Xem gợi ý từ đầu'"></span>
                </button>
            </div>

            <!-- Hint Display -->
            <div x-show="showHint" x-cloak class="p-3 bg-indigo-50 border border-indigo-200 rounded-2xl text-xs text-indigo-950 font-medium">
                💡 <strong>Gợi ý ký tự đầu:</strong> <span class="font-mono" x-text="getMaskedHint()"></span>
            </div>

            <textarea id="dictation-input"
                      x-model="userInput" 
                      @keydown.enter.prevent="checkSentence()"
                      rows="3" 
                      placeholder="Lắng nghe và gõ câu tiếng Anh vào đây..." 
                      class="w-full p-4 rounded-2xl border-2 border-slate-300 focus:border-rose-600 focus:ring-0 text-base font-medium transition resize-none leading-relaxed text-slate-900 placeholder:text-slate-500">
            </textarea>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <p class="text-xs text-slate-600">
                    Mẹo: Nhấn <strong>Enter</strong> hoặc nút bên phải để kiểm tra kết quả ngay.
                </p>
                <div class="flex items-center space-x-2">
                    <button @click="checkSentence()" 
                            :disabled="!userInput.trim() || isChecking" 
                            class="w-full sm:w-auto px-6 py-3 bg-rose-700 hover:bg-rose-800 disabled:bg-slate-300 text-white font-extrabold text-xs rounded-xl shadow-glow transition flex items-center justify-center space-x-2 cursor-pointer">
                        <i data-lucide="check-circle" class="w-4 h-4" aria-hidden="true"></i>
                        <span x-text="isChecking ? 'Đang chấm điểm...' : 'Kiểm Tra Kết Quả'"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Feedback & Diff Result Box -->
        <div x-show="result" x-cloak class="p-6 rounded-3xl border-2 transition-all duration-300 space-y-4 animate-pop"
             :class="result?.is_passed ? 'bg-emerald-50/90 border-emerald-300' : 'bg-rose-50/90 border-rose-300'">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <span class="text-2xl" x-text="result?.is_passed ? '🎉' : '✍️'"></span>
                    <div>
                        <h3 class="font-black text-sm" :class="result?.is_passed ? 'text-emerald-950' : 'text-rose-950'"
                            x-text="result?.is_passed ? 'Tuyệt vời! Bạn đã nghe và gõ chính xác 100%.' : 'Chưa hoàn toàn chính xác. Hãy đối chiếu từ bị sai bên dưới nhé!'">
                        </h3>
                        <p class="text-xs text-slate-700" x-show="result?.is_passed">Bạn đã nhận được <strong class="text-emerald-700">+20 XP</strong> thưởng chuyên cần!</p>
                    </div>
                </div>
                <span class="px-3.5 py-1.5 rounded-full text-xs font-black"
                      :class="result?.is_passed ? 'bg-emerald-200 text-emerald-950' : 'bg-rose-200 text-rose-950'"
                      x-text="`Độ chính xác: ${result?.accuracy_percentage}%`">
                </span>
            </div>

            <!-- Target Correct Sentence -->
            <div class="p-4 bg-white rounded-2xl border border-slate-200 space-y-2">
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider block">Câu Gốc Chuẩn Xác:</span>
                <p class="text-base font-extrabold text-slate-900 leading-relaxed font-display" x-text="currentSentence.original_text"></p>
            </div>

            <!-- Word-by-word Diff Display -->
            <div class="p-4 bg-white rounded-2xl border border-slate-200 space-y-2">
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider block">Chi Tiết So Khớp Từng Từ:</span>
                <div class="flex flex-wrap gap-2 text-sm font-bold">
                    <template x-for="(item, idx) in result?.diff" :key="idx">
                        <span class="px-3 py-1.5 rounded-xl border text-xs sm:text-sm"
                              :class="item.is_correct ? 'bg-emerald-100 border-emerald-300 text-emerald-950' : 'bg-rose-100 border-rose-300 text-rose-950 line-through'"
                              x-text="item.user_word || item.target_word">
                        </span>
                    </template>
                </div>
            </div>

            <!-- Phonetics & Vietnamese Meaning -->
            <div class="space-y-2 pt-2 border-t border-slate-200/80 text-xs text-slate-900">
                <p x-show="result?.translation_vi"><strong>📖 Dịch nghĩa tiếng Việt:</strong> <span class="text-slate-800" x-text="result?.translation_vi"></span></p>
                <p x-show="result?.phonetic_notes"><strong>🔊 Quy tắc nối âm / nuốt âm:</strong> <span class="text-indigo-800 font-semibold" x-text="result?.phonetic_notes"></span></p>
            </div>

            <!-- Next Button -->
            <div class="flex justify-end pt-2">
                <button @click="nextSentence()" class="px-6 py-3 bg-slate-950 hover:bg-slate-900 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <span x-text="currentIndex < sentences.length - 1 ? 'Câu Tiếp Theo →' : 'Hoàn Thành Bài Nghe 🎉'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Completed Topic Modal -->
    <div x-show="showCompleteModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl border border-slate-200 space-y-6 text-center animate-pop" @click.outside="showCompleteModal = false">
            <div class="w-20 h-20 mx-auto rounded-3xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-4xl shadow-inner animate-bounce">
                🏆
            </div>

            <div class="space-y-2">
                <h3 class="text-2xl font-black font-display text-slate-900">Hoàn Thành Xuất Sắc!</h3>
                <p class="text-xs text-slate-700">Bạn đã hoàn thành trọn vẹn tất cả các câu trong bài nghe chép chính tả này.</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 grid grid-cols-2 gap-2 text-center">
                <div class="p-2 bg-white rounded-xl border border-slate-100">
                    <span class="block text-[10px] font-bold text-slate-600">Số Câu Đạt</span>
                    <span class="text-base font-black text-slate-900" x-text="`${sentences.length} / ${sentences.length}`"></span>
                </div>
                <div class="p-2 bg-white rounded-xl border border-slate-100">
                    <span class="block text-[10px] font-bold text-slate-600">XP Nhận Được</span>
                    <span class="text-base font-black text-emerald-700">+{{ $topic->sentences->count() * 20 }} XP</span>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button @click="resetTopic()" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition">
                    Luyện Lại Bài Này
                </button>
                <a href="{{ route('dictation.index') }}" class="flex-1 py-3 bg-rose-700 hover:bg-rose-800 text-white font-black text-xs rounded-xl shadow-glow transition block text-center">
                    Bài Nghe Khác →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function dictationStudio() {
    return {
        sentences: @json($topic->sentences),
        currentIndex: 0,
        userInput: '',
        isPlaying: false,
        playbackSpeed: 1.0,
        sentenceProgress: 0,
        isChecking: false,
        showHint: false,
        showCompleteModal: false,
        result: null,
        audioElement: null,
        checkTimer: null,

        get currentSentence() {
            return this.sentences[this.currentIndex] || {};
        },

        initAudio() {
            // Native HTML5 Audio with cross-browser reliability
            this.audioElement = new Audio('{{ $topic->audio_url }}');
            this.audioElement.preload = 'auto';

            this.audioElement.addEventListener('ended', () => {
                this.isPlaying = false;
                this.sentenceProgress = 100;
            });

            // Keyboard shortcut Space to replay sentence
            document.addEventListener('keydown', (e) => {
                if (e.code === 'Space' && document.activeElement.tagName !== 'TEXTAREA' && document.activeElement.tagName !== 'INPUT') {
                    e.preventDefault();
                    this.togglePlay();
                }
            });

            // Auto-play first sentence
            setTimeout(() => {
                this.replaySentence();
            }, 600);
        },

        setSpeed(spd) {
            this.playbackSpeed = spd;
            if (this.audioElement) {
                this.audioElement.playbackRate = spd;
            }
        },

        togglePlay() {
            if (this.isPlaying) {
                this.pauseAudio();
            } else {
                this.replaySentence();
            }
        },

        pauseAudio() {
            if (this.audioElement) {
                this.audioElement.pause();
            }
            if (this.checkTimer) {
                clearInterval(this.checkTimer);
            }
            this.isPlaying = false;
        },

        replaySentence() {
            if (!this.audioElement) return;

            const start = parseFloat(this.currentSentence.audio_start_time || 0);
            const end = parseFloat(this.currentSentence.audio_end_time || 5);

            this.audioElement.currentTime = start;
            this.audioElement.playbackRate = this.playbackSpeed;

            const playPromise = this.audioElement.play();
            if (playPromise !== undefined) {
                playPromise.then(() => {
                    this.isPlaying = true;
                }).catch(err => {
                    // Fallback to browser SpeechSynthesis if external audio is blocked
                    this.playSpeechSynthesisFallback();
                });
            }

            if (this.checkTimer) {
                clearInterval(this.checkTimer);
            }

            this.checkTimer = setInterval(() => {
                if (!this.audioElement || !this.isPlaying) return;

                const current = this.audioElement.currentTime;
                if (current >= end) {
                    this.pauseAudio();
                    this.sentenceProgress = 100;
                } else {
                    const prog = ((current - start) / Math.max(0.1, (end - start))) * 100;
                    this.sentenceProgress = Math.min(100, Math.max(0, prog));
                }
            }, 50);
        },

        playSpeechSynthesisFallback() {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const utter = new SpeechSynthesisUtterance(this.currentSentence.original_text);
                utter.lang = 'en-US';
                utter.rate = this.playbackSpeed;
                utter.onstart = () => { this.isPlaying = true; this.sentenceProgress = 10; };
                utter.onend = () => { this.isPlaying = false; this.sentenceProgress = 100; };
                window.speechSynthesis.speak(utter);
            }
        },

        getMaskedHint() {
            const text = this.currentSentence.original_text || '';
            return text.split(' ').map(w => w.length > 1 ? w[0] + '_'.repeat(w.length - 1) : w).join(' ');
        },

        async checkSentence() {
            if (!this.userInput.trim() || this.isChecking) return;
            this.isChecking = true;

            try {
                const res = await fetch('/api/dictation/verify-sentence', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        sentence_id: this.currentSentence.id,
                        user_input: this.userInput
                    })
                });

                const data = await res.json();
                if (data.success) {
                    this.result = data.result;
                    if (data.result.is_passed) {
                        window.fireConfetti?.({ particleCount: 70, spread: 60, origin: { y: 0.7 } });
                    }
                } else {
                    alert('Lỗi kiểm tra: ' + (data.message || 'Vui lòng thử lại.'));
                }
            } catch (err) {
                // Client-side fallback Levenshtein evaluation if API is offline
                this.evaluateLocally();
            } finally {
                this.isChecking = false;
            }
        },

        evaluateLocally() {
            const targetWords = (this.currentSentence.original_text || '').trim().split(/\s+/);
            const userWords = this.userInput.trim().split(/\s+/);
            let correctCount = 0;
            const diff = [];

            targetWords.forEach((tw, i) => {
                const uw = userWords[i] || '';
                const cleanTw = tw.toLowerCase().replace(/[.,!?;:"']/g, '');
                const cleanUw = uw.toLowerCase().replace(/[.,!?;:"']/g, '');
                const isMatch = cleanTw === cleanUw;
                if (isMatch) correctCount++;
                diff.push({
                    target_word: tw,
                    user_word: uw,
                    is_correct: isMatch
                });
            });

            const accuracy = Math.round((correctCount / Math.max(1, targetWords.length)) * 100);
            this.result = {
                is_passed: accuracy >= 80,
                accuracy_percentage: accuracy,
                diff: diff,
                translation_vi: this.currentSentence.translation_vi,
                phonetic_notes: this.currentSentence.phonetic_notes
            };

            if (accuracy >= 80) {
                window.fireConfetti?.({ particleCount: 70, spread: 60, origin: { y: 0.7 } });
            }
        },

        nextSentence() {
            if (this.currentIndex < this.sentences.length - 1) {
                this.currentIndex++;
                this.userInput = '';
                this.result = null;
                this.showHint = false;
                this.sentenceProgress = 0;
                this.replaySentence();
            } else {
                this.showCompleteModal = true;
                window.fireConfetti?.({ particleCount: 120, spread: 100, origin: { y: 0.5 } });
            }
        },

        resetTopic() {
            this.showCompleteModal = false;
            this.currentIndex = 0;
            this.userInput = '';
            this.result = null;
            this.showHint = false;
            this.sentenceProgress = 0;
            this.replaySentence();
        }
    };
}
</script>
@endpush
