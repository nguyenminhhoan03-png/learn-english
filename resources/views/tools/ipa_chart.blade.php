@extends('layouts.app')

@section('title', 'Bảng Phiên Âm Quốc Tế IPA 44 Âm Chuẩn Oxford - EduLearn')
@section('meta_description', 'Luyện phát âm chuẩn 44 âm IPA tiếng Anh với âm thanh mẫu, khẩu hình miệng và các từ vựng ví dụ trực quan.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10" x-data="ipaApp()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white rounded-3xl p-8 sm:p-10 shadow-2xl space-y-3 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 space-y-2 max-w-3xl">
            <span class="px-3 py-1 bg-indigo-500/30 text-indigo-200 border border-indigo-400/40 text-xs font-black rounded-full uppercase">
                Interactive IPA Phonetic Chart
            </span>
            <h1 class="text-2xl sm:text-4xl font-black font-display tracking-tight leading-tight">
                Bảng 44 Âm Phiên Âm Quốc Tế (IPA)
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 font-medium leading-relaxed">
                Nhấp vào bất kỳ ký tự âm nào để nghe phát âm chuẩn bản xứ, xem khẩu hình và các từ vựng ví dụ thực tế.
            </p>
        </div>
    </div>

    <!-- Active Sound Floating Inspector -->
    <div class="p-6 bg-white rounded-3xl border border-slate-200 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-6" x-show="activeSound" x-cloak>
        <div class="flex items-center space-x-5">
            <div class="w-16 h-16 rounded-2xl bg-rose-600 text-white font-mono font-black text-2xl flex items-center justify-center shadow-glow">
                <span x-text="activeSound.symbol"></span>
            </div>
            <div>
                <div class="flex items-center space-x-2">
                    <span class="text-xs font-bold uppercase text-rose-600 bg-rose-50 px-2.5 py-0.5 rounded-full" x-text="activeSound.type"></span>
                    <span class="text-xs text-slate-400 font-medium" x-text="activeSound.voicing"></span>
                </div>
                <h2 class="text-xl font-black text-slate-900 mt-1" x-text="`Âm: ${activeSound.symbol} (${activeSound.name})`"></h2>
            </div>
        </div>

        <!-- Examples & Play Button -->
        <div class="flex items-center space-x-4">
            <div class="text-right">
                <span class="text-[11px] font-bold text-slate-400 uppercase block">Từ Ví Dụ Điển Hình:</span>
                <span class="text-base font-bold text-slate-900" x-text="activeSound.examples.join(', ')"></span>
            </div>
            <button @click="playSound(activeSound.examples[0] || activeSound.symbol)" class="px-5 py-3 bg-slate-900 hover:bg-rose-600 text-white font-extrabold text-xs rounded-2xl shadow-md transition flex items-center space-x-2">
                <i data-lucide="volume-2" class="w-4 h-4"></i>
                <span>Nghe Phát Âm</span>
            </button>
        </div>
    </div>

    <!-- 1. VOWELS (Nguyên Âm) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
            <h3 class="text-lg font-black font-display text-slate-900">1. Nguyên Âm (Vowels - 20 Âm)</h3>
            <span class="text-xs font-bold text-slate-500">12 Nguyên âm đơn + 8 Nguyên âm đôi</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
            <template x-for="sound in vowels" :key="sound.symbol">
                <button @click="selectSound(sound)" 
                        :class="activeSound?.symbol === sound.symbol ? 'border-rose-600 bg-rose-50 shadow-md ring-2 ring-rose-400/40' : 'border-slate-200 bg-white hover:border-indigo-400 hover:bg-indigo-50/50'"
                        class="p-4 rounded-2xl border text-center transition flex flex-col items-center justify-center space-y-1.5 cursor-pointer group">
                    <span class="text-2xl font-black font-mono text-slate-900 group-hover:text-rose-600 transition" x-text="sound.symbol"></span>
                    <span class="text-xs font-semibold text-slate-500 truncate max-w-full" x-text="sound.examples[0]"></span>
                </button>
            </template>
        </div>
    </div>

    <!-- 2. CONSONANTS (Phụ Âm) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
            <h3 class="text-lg font-black font-display text-slate-900">2. Phụ Âm (Consonants - 24 Âm)</h3>
            <span class="text-xs font-bold text-slate-500">Âm hữu thanh & vô thanh</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
            <template x-for="sound in consonants" :key="sound.symbol">
                <button @click="selectSound(sound)" 
                        :class="activeSound?.symbol === sound.symbol ? 'border-rose-600 bg-rose-50 shadow-md ring-2 ring-rose-400/40' : 'border-slate-200 bg-white hover:border-indigo-400 hover:bg-indigo-50/50'"
                        class="p-4 rounded-2xl border text-center transition flex flex-col items-center justify-center space-y-1.5 cursor-pointer group">
                    <span class="text-2xl font-black font-mono text-slate-900 group-hover:text-rose-600 transition" x-text="sound.symbol"></span>
                    <span class="text-xs font-semibold text-slate-500 truncate max-w-full" x-text="sound.examples[0]"></span>
                </button>
            </template>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function ipaApp() {
    return {
        activeSound: null,

        vowels: [
            { symbol: '/iː/', name: 'i dài', type: 'Monophthong (Long)', voicing: 'Nguyên âm đơn dài', examples: ['see', 'tree', 'eat'] },
            { symbol: '/ɪ/', name: 'i ngắn', type: 'Monophthong (Short)', voicing: 'Nguyên âm đơn ngắn', examples: ['sit', 'hit', 'fit'] },
            { symbol: '/ʊ/', name: 'u ngắn', type: 'Monophthong (Short)', voicing: 'Nguyên âm đơn ngắn', examples: ['good', 'put', 'foot'] },
            { symbol: '/uː/', name: 'u dài', type: 'Monophthong (Long)', voicing: 'Nguyên âm đơn dài', examples: ['two', 'blue', 'food'] },
            { symbol: '/e/', name: 'e ngắn', type: 'Monophthong (Short)', voicing: 'Nguyên âm đơn ngắn', examples: ['ten', 'bed', 'head'] },
            { symbol: '/ə/', name: 'schwa', type: 'Monophthong (Short)', voicing: 'Nguyên âm trung hòa', examples: ['about', 'camera', 'banana'] },
            { symbol: '/ɜː/', name: 'ơ dài', type: 'Monophthong (Long)', voicing: 'Nguyên âm đơn dài', examples: ['bird', 'work', 'learn'] },
            { symbol: '/ɔː/', name: 'o dài', type: 'Monophthong (Long)', voicing: 'Nguyên âm đơn dài', examples: ['door', 'saw', 'walk'] },
            { symbol: '/æ/', name: 'e bẹt', type: 'Monophthong (Short)', voicing: 'Nguyên âm đơn ngắn', examples: ['cat', 'apple', 'black'] },
            { symbol: '/ʌ/', name: 'á ngắn', type: 'Monophthong (Short)', voicing: 'Nguyên âm đơn ngắn', examples: ['cup', 'love', 'sun'] },
            { symbol: '/ɑː/', name: 'a dài', type: 'Monophthong (Long)', voicing: 'Nguyên âm đơn dài', examples: ['car', 'father', 'park'] },
            { symbol: '/ɒ/', name: 'o ngắn', type: 'Monophthong (Short)', voicing: 'Nguyên âm đơn ngắn', examples: ['hot', 'dog', 'box'] },
            // Diphthongs
            { symbol: '/ɪə/', name: 'ia', type: 'Diphthong', voicing: 'Nguyên âm đôi', examples: ['hear', 'clear', 'near'] },
            { symbol: '/eɪ/', name: 'ây', type: 'Diphthong', voicing: 'Nguyên âm đôi', examples: ['say', 'eight', 'wait'] },
            { symbol: '/ʊə/', name: 'ua', type: 'Diphthong', voicing: 'Nguyên âm đôi', examples: ['tour', 'pure', 'sure'] },
            { symbol: '/ɔɪ/', name: 'oi', type: 'Diphthong', voicing: 'Nguyên âm đôi', examples: ['boy', 'coin', 'voice'] },
            { symbol: '/əʊ/', name: 'âu', type: 'Diphthong', voicing: 'Nguyên âm đôi', examples: ['go', 'home', 'road'] },
            { symbol: '/eə/', name: 'e-ơ', type: 'Diphthong', voicing: 'Nguyên âm đôi', examples: ['hair', 'care', 'bear'] },
            { symbol: '/aɪ/', name: 'ai', type: 'Diphthong', voicing: 'Nguyên âm đôi', examples: ['my', 'time', 'like'] },
            { symbol: '/aʊ/', name: 'ao', type: 'Diphthong', voicing: 'Nguyên âm đôi', examples: ['now', 'house', 'cow'] }
        ],

        consonants: [
            { symbol: '/p/', name: 'p bật hơi', type: 'Voiceless', voicing: 'Phụ âm vô thanh', examples: ['pen', 'stop', 'happy'] },
            { symbol: '/b/', name: 'b', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['book', 'baby', 'big'] },
            { symbol: '/t/', name: 't', type: 'Voiceless', voicing: 'Phụ âm vô thanh', examples: ['tea', 'table', 'get'] },
            { symbol: '/d/', name: 'd', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['door', 'day', 'food'] },
            { symbol: '/tʃ/', name: 'ch', type: 'Voiceless', voicing: 'Phụ âm vô thanh', examples: ['chair', 'nature', 'match'] },
            { symbol: '/dʒ/', name: 'j', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['job', 'bridge', 'age'] },
            { symbol: '/k/', name: 'k', type: 'Voiceless', voicing: 'Phụ âm vô thanh', examples: ['cat', 'key', 'school'] },
            { symbol: '/g/', name: 'g', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['go', 'green', 'bag'] },
            { symbol: '/f/', name: 'f', type: 'Voiceless', voicing: 'Phụ âm vô thanh', examples: ['fish', 'coffee', 'leaf'] },
            { symbol: '/v/', name: 'v', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['van', 'voice', 'have'] },
            { symbol: '/θ/', name: 'th không rung', type: 'Voiceless', voicing: 'Phụ âm vô thanh', examples: ['think', 'both', 'teeth'] },
            { symbol: '/ð/', name: 'th rung', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['this', 'mother', 'with'] },
            { symbol: '/s/', name: 's nhẹ', type: 'Voiceless', voicing: 'Phụ âm vô thanh', examples: ['see', 'city', 'nice'] },
            { symbol: '/z/', name: 'z', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['zoo', 'lazy', 'rose'] },
            { symbol: '/ʃ/', name: 's nặng', type: 'Voiceless', voicing: 'Phụ âm vô thanh', examples: ['she', 'shop', 'fish'] },
            { symbol: '/ʒ/', name: 'gi', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['vision', 'measure', 'garage'] },
            { symbol: '/m/', name: 'm', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['man', 'summer', 'time'] },
            { symbol: '/n/', name: 'n', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['no', 'name', 'sun'] },
            { symbol: '/ŋ/', name: 'ng', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['sing', 'finger', 'long'] },
            { symbol: '/h/', name: 'h', type: 'Voiceless', voicing: 'Phụ âm vô thanh', examples: ['hat', 'hello', 'home'] },
            { symbol: '/l/', name: 'l', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['leg', 'light', 'ball'] },
            { symbol: '/r/', name: 'r', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['red', 'run', 'car'] },
            { symbol: '/w/', name: 'w', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['wet', 'window', 'water'] },
            { symbol: '/j/', name: 'y', type: 'Voiced', voicing: 'Phụ âm hữu thanh', examples: ['yes', 'yellow', 'you'] }
        ],

        init() {
            this.activeSound = this.vowels[0];
        },

        selectSound(sound) {
            this.activeSound = sound;
            this.playSound(sound.examples[0] || sound.symbol);
        },

        playSound(text) {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const utter = new SpeechSynthesisUtterance(text);
                utter.lang = 'en-US';
                utter.rate = 0.85;
                window.speechSynthesis.speak(utter);
            }
        }
    };
}
</script>
@endpush
