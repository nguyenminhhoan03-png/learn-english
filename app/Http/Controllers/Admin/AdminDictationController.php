<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DictationSentence;
use App\Models\DictationTopic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminDictationController extends Controller
{
    public function index(): View
    {
        $topics = DictationTopic::withCount('sentences')->latest()->paginate(10);
        return view('admin.dictation.index', compact('topics'));
    }

    public function create(): View
    {
        return view('admin.dictation.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'level' => 'required|in:A2,B1,B2,C1',
            'audio_url' => 'required|url',
            'thumbnail' => 'nullable|url',
            'sentences' => 'required|array|min:1',
            'sentences.*.audio_start_time' => 'required|numeric|min:0',
            'sentences.*.audio_end_time' => 'required|numeric|min:0',
            'sentences.*.sentence_text' => 'required|string',
            'sentences.*.translation_vi' => 'required|string',
            'sentences.*.phonetic_notes' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['title']) . '-' . uniqid();
        $totalSentences = count($validated['sentences']);
        $lastSentence = end($validated['sentences']);
        $duration = (int) ($lastSentence['audio_end_time'] ?? 60);

        // 1. Create Topic
        $topic = DictationTopic::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'level' => $validated['level'],
            'audio_url' => $validated['audio_url'],
            'thumbnail' => $validated['thumbnail'] ?? null,
            'duration_seconds' => $duration,
            'total_sentences' => $totalSentences,
            'is_published' => true,
        ]);

        // 2. Create Sentences
        foreach ($validated['sentences'] as $index => $sData) {
            DictationSentence::create([
                'topic_id' => $topic->id,
                'sentence_order' => $index + 1,
                'audio_start_time' => (float) $sData['audio_start_time'],
                'audio_end_time' => (float) $sData['audio_end_time'],
                'sentence_text' => trim($sData['sentence_text']),
                'translation_vi' => trim($sData['translation_vi']),
                'phonetic_notes' => $sData['phonetic_notes'] ?? null,
            ]);
        }

        return redirect()->route('admin.dictation.index')->with('success', 'Đã tải lên bài nghe chép chính tả mới thành công!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $topic = DictationTopic::findOrFail($id);
        $topic->delete();
        return redirect()->route('admin.dictation.index')->with('success', 'Đã xóa bài nghe chép chính tả.');
    }
}
