<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpeakingSample;
use App\Models\WritingSample;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminSampleController extends Controller
{
    public function index(): View
    {
        $writingSamples = WritingSample::latest()->paginate(10);
        $speakingSamples = SpeakingSample::latest()->paginate(10);
        return view('admin.samples.index', compact('writingSamples', 'speakingSamples'));
    }

    public function createWriting(): View
    {
        return view('admin.samples.create_writing');
    }

    public function storeWriting(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'task_type' => 'required|in:task1,task2',
            'title' => 'required|string|max:255',
            'prompt' => 'required|string',
            'band_score' => 'required|numeric|min:5.0|max:9.0',
            'outline_linearthinking' => 'required|string',
            'sample_essay' => 'required|string',
            'vocab_words' => 'nullable|array',
            'vocab_meanings' => 'nullable|array',
        ]);

        $slug = Str::slug($validated['title']) . '-' . uniqid();

        $vocabList = [];
        if (!empty($validated['vocab_words'])) {
            foreach ($validated['vocab_words'] as $i => $w) {
                if (!empty($w)) {
                    $vocabList[] = [
                        'word' => $w,
                        'meaning' => $validated['vocab_meanings'][$i] ?? '',
                    ];
                }
            }
        }

        WritingSample::create([
            'task_type' => $validated['task_type'],
            'title' => $validated['title'],
            'slug' => $slug,
            'prompt' => $validated['prompt'],
            'band_score' => (float) $validated['band_score'],
            'outline_linearthinking' => $validated['outline_linearthinking'],
            'sample_essay' => $validated['sample_essay'],
            'key_vocab_list' => $vocabList,
        ]);

        return redirect()->route('admin.samples.index')->with('success', 'Đã thêm bài mẫu Writing thành công!');
    }

    public function createSpeaking(): View
    {
        return view('admin.samples.create_speaking');
    }

    public function storeSpeaking(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'part' => 'required|in:part1,part2,part3',
            'topic' => 'required|string|max:255',
            'cue_card_or_question' => 'required|string',
            'band_score' => 'required|numeric|min:5.0|max:9.0',
            'audio_url' => 'nullable|url',
            'sample_transcript' => 'required|string',
            'vocab_words' => 'nullable|array',
            'vocab_meanings' => 'nullable|array',
        ]);

        $slug = Str::slug($validated['topic']) . '-' . uniqid();

        $vocabList = [];
        if (!empty($validated['vocab_words'])) {
            foreach ($validated['vocab_words'] as $i => $w) {
                if (!empty($w)) {
                    $vocabList[] = [
                        'word' => $w,
                        'meaning' => $validated['vocab_meanings'][$i] ?? '',
                    ];
                }
            }
        }

        SpeakingSample::create([
            'part' => $validated['part'],
            'topic' => $validated['topic'],
            'slug' => $slug,
            'cue_card_or_question' => $validated['cue_card_or_question'],
            'band_score' => (float) $validated['band_score'],
            'audio_url' => $validated['audio_url'] ?? null,
            'sample_transcript' => $validated['sample_transcript'],
            'key_vocab_list' => $vocabList,
        ]);

        return redirect()->route('admin.samples.index')->with('success', 'Đã thêm bài mẫu Speaking thành công!');
    }

    public function destroyWriting(int $id): RedirectResponse
    {
        WritingSample::findOrFail($id)->delete();
        return redirect()->route('admin.samples.index')->with('success', 'Đã xóa bài mẫu Writing.');
    }

    public function destroySpeaking(int $id): RedirectResponse
    {
        SpeakingSample::findOrFail($id)->delete();
        return redirect()->route('admin.samples.index')->with('success', 'Đã xóa bài mẫu Speaking.');
    }
}
