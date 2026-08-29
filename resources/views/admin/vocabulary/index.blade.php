@extends('admin.layouts.admin')

@section('title', 'Quản Lý Từ Điển & Flashcard - Admin CMS')

@section('content')
<div class="space-y-8" x-data="{ showAddModal: false }">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black font-display text-white">Quản Lý Kho Từ Điển & Flashcard SM-2</h1>
            <p class="text-xs text-slate-400 mt-1">Dữ liệu từ vựng toàn cục phục vụ tra cứu 1-chạm và hệ thống thẻ nhớ</p>
        </div>
        <button @click="showAddModal = true" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-glow transition flex items-center space-x-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Thêm Từ Vựng Mới</span>
        </button>
    </div>

    <!-- Search bar -->
    <form action="{{ route('admin.vocabulary.index') }}" method="GET" class="flex items-center space-x-3">
        <input type="text" name="search" value="{{ $search }}" placeholder="Tìm kiếm từ vựng hoặc nghĩa tiếng Việt..." class="px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs w-80">
        <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-xl">Tìm</button>
    </form>

    <!-- Table -->
    <div class="bg-slate-900 rounded-3xl border border-slate-800 p-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 uppercase text-[10px]">
                        <th class="py-3 px-4">Từ Vựng</th>
                        <th class="py-3 px-4">Từ Loại</th>
                        <th class="py-3 px-4">Phiên Âm (IPA)</th>
                        <th class="py-3 px-4">Nghĩa Tiếng Việt</th>
                        <th class="py-3 px-4 text-right">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium text-slate-300">
                    @forelse($vocabularies as $v)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3.5 px-4 font-bold text-white">{{ $v->word }}</td>
                        <td class="py-3.5 px-4 uppercase text-[10px] text-slate-400">{{ $v->part_of_speech ?: 'word' }}</td>
                        <td class="py-3.5 px-4 font-mono text-rose-400">{{ $v->phonetic_us ?: $v->phonetic_uk }}</td>
                        <td class="py-3.5 px-4">{{ $v->definition_vi }}</td>
                        <td class="py-3.5 px-4 text-right">
                            <form action="{{ route('admin.vocabulary.destroy', ['id' => $v->id]) }}" method="POST" onsubmit="return confirm('Xóa từ vựng này khỏi từ điển?');">
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
                        <td colspan="5" class="text-center py-6 text-slate-500">Chưa tìm thấy từ vựng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-800">
            {{ $vocabularies->links() }}
        </div>
    </div>

    <!-- Add Word Modal -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-800 space-y-6 shadow-2xl" @click.outside="showAddModal = false">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <h3 class="text-lg font-black font-display text-white">Thêm Từ Vựng Vào Từ Điển</h3>
                <button @click="showAddModal = false" class="text-slate-400 hover:text-white">✕</button>
            </div>

            <form action="{{ route('admin.vocabulary.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1">Từ tiếng Anh:</label>
                        <input type="text" name="word" required placeholder="VD: meticulously" class="w-full px-3.5 py-2 rounded-xl bg-slate-800 border border-slate-700 text-white font-bold">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1">Từ loại (Part of speech):</label>
                        <input type="text" name="part_of_speech" placeholder="VD: adverb, verb..." class="w-full px-3.5 py-2 rounded-xl bg-slate-800 border border-slate-700 text-white">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1">Phiên âm US (IPA):</label>
                        <input type="text" name="phonetic_us" placeholder="VD: /məˈtɪk.jə.ləs.li/" class="w-full px-3.5 py-2 rounded-xl bg-slate-800 border border-slate-700 text-white font-mono">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1">Audio phát âm URL:</label>
                        <input type="url" name="audio_us" placeholder="https://..." class="w-full px-3.5 py-2 rounded-xl bg-slate-800 border border-slate-700 text-white">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-300 uppercase mb-1">Nghĩa tiếng Việt:</label>
                    <textarea name="definition_vi" required rows="2" placeholder="VD: một cách tỉ mỉ, cẩn thận từng chi tiết" class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700 text-white"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-300 uppercase mb-1">Câu ví dụ (Example sentence):</label>
                    <textarea name="example_sentence" rows="2" placeholder="VD: The document was meticulously edited before publication." class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700 text-white font-serif"></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2.5 rounded-xl bg-slate-800 text-slate-300 font-bold">Hủy</button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black shadow-glow">Lưu Từ Vựng</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
