<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionGroup;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\TestSection;
use App\Models\TestSet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminTestController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $query = Test::with(['testSet.category'])->withCount('sections');

        if ($category) {
            $query->whereHas('testSet.category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $tests = $query->latest()->paginate(10);
        $categories = TestCategory::all();
        $testSets = TestSet::all();

        return view('admin.tests.index', compact('tests', 'categories', 'testSets'));
    }

    public function create(): View
    {
        $categories = TestCategory::all();
        $testSets = TestSet::all();
        return view('admin.tests.create', compact('categories', 'testSets'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'test_set_id' => 'required|exists:test_sets,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:reading,listening,full',
            'duration_minutes' => 'required|integer|min:5|max:180',
            'total_questions' => 'required|integer|min:1|max:100',
            'section_title' => 'required|string|max:255',
            'passage_text' => 'required|string',
            'audio_url' => 'nullable|url',
            // Question fields
            'questions' => 'required|array|min:1',
            'questions.*.content' => 'required|string',
            'questions.*.question_type' => 'required|string',
            'questions.*.correct_answer' => 'required|string',
            'questions.*.evidence_paragraph' => 'nullable|string',
            'questions.*.linearthinking_structure' => 'nullable|string',
            'questions.*.linearthinking_logic' => 'nullable|string',
            'questions.*.paraphrase_question' => 'nullable|string',
            'questions.*.paraphrase_passage' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['title']) . '-' . uniqid();

        // 1. Create Test
        $test = Test::create([
            'test_set_id' => $validated['test_set_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'type' => $validated['type'],
            'duration_minutes' => (int) $validated['duration_minutes'],
            'total_questions' => (int) $validated['total_questions'],
            'is_published' => true,
        ]);

        // 2. Create Section
        $section = TestSection::create([
            'test_id' => $test->id,
            'section_number' => 1,
            'title' => $validated['section_title'],
            'passage_text' => $validated['passage_text'],
            'audio_url' => $validated['audio_url'] ?? null,
        ]);

        // 3. Create Question Group
        $group = QuestionGroup::create([
            'section_id' => $section->id,
            'instruction' => 'Trả lời các câu hỏi sau dựa trên thông tin bài đọc / bài nghe.',
            'question_type' => $validated['questions'][0]['question_type'] ?? 'true_false_not_given',
        ]);

        // 4. Create Questions with Linearthinking Annotations
        foreach ($validated['questions'] as $index => $qData) {
            $paraphraseTable = [];
            if (!empty($qData['paraphrase_question']) && !empty($qData['paraphrase_passage'])) {
                $paraphraseTable[] = [
                    'question_word' => $qData['paraphrase_question'],
                    'passage_word' => $qData['paraphrase_passage'],
                ];
            }

            Question::create([
                'group_id' => $group->id,
                'question_number' => $index + 1,
                'content' => $qData['content'],
                'options' => in_array($qData['question_type'], ['true_false_not_given', 'yes_no_not_given'])
                    ? [['key' => 'TRUE', 'text' => 'TRUE'], ['key' => 'FALSE', 'text' => 'FALSE'], ['key' => 'NOT GIVEN', 'text' => 'NOT GIVEN']]
                    : null,
                'correct_answer' => trim($qData['correct_answer']),
                'evidence_paragraph' => $qData['evidence_paragraph'] ?? null,
                'linearthinking_structure' => $qData['linearthinking_structure'] ?? null,
                'linearthinking_logic' => $qData['linearthinking_logic'] ?? null,
                'paraphrase_table' => $paraphraseTable,
            ]);
        }

        return redirect()->route('admin.tests.index')->with('success', 'Tạo đề thi mới thành công với đầy đủ giải thích Linearthinking!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $test = Test::findOrFail($id);
        $test->delete();
        return redirect()->route('admin.tests.index')->with('success', 'Đã xóa đề thi thành công.');
    }
}
