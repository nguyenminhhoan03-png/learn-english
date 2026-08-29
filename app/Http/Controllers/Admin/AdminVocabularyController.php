<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminVocabularyController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = Vocabulary::query();

        if ($search) {
            $query->where('word', 'like', "%{$search}%")
                  ->orWhere('definition_vi', 'like', "%{$search}%");
        }

        $vocabularies = $query->latest()->paginate(15);
        return view('admin.vocabulary.index', compact('vocabularies', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'word' => 'required|string|max:100|unique:vocabulary,word',
            'part_of_speech' => 'nullable|string|max:50',
            'phonetic_us' => 'nullable|string|max:100',
            'phonetic_uk' => 'nullable|string|max:100',
            'audio_us' => 'nullable|url',
            'definition_vi' => 'required|string',
            'example_sentence' => 'nullable|string',
        ]);

        Vocabulary::create([
            'word' => strtolower(trim($validated['word'])),
            'part_of_speech' => $validated['part_of_speech'] ?? null,
            'phonetic_us' => $validated['phonetic_us'] ?? null,
            'phonetic_uk' => $validated['phonetic_uk'] ?? null,
            'audio_us' => $validated['audio_us'] ?? null,
            'definition_vi' => trim($validated['definition_vi']),
            'example_sentence' => $validated['example_sentence'] ?? null,
        ]);

        return redirect()->route('admin.vocabulary.index')->with('success', 'Đã thêm từ vựng mới vào từ điển toàn cục!');
    }

    public function destroy(int $id): RedirectResponse
    {
        Vocabulary::findOrFail($id)->delete();
        return redirect()->route('admin.vocabulary.index')->with('success', 'Đã xóa từ vựng.');
    }
}
