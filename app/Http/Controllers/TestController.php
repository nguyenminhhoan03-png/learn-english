<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestCategory;
use App\Models\TestSet;
use App\Models\User;
use Core\Contexts\Testing\Application\Commands\SubmitTestCommand;
use Core\Contexts\Testing\Application\Queries\GetSubmissionResultQuery;
use Core\Contexts\Testing\Application\Queries\GetTestDetailQuery;
use Core\Shared\Application\Bus\CommandBusInterface;
use Core\Shared\Application\Bus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TestController extends Controller
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus
    ) {}

    public function index(Request $request): View
    {
        $categorySlug = $request->query('category');

        $categories = Cache::remember('all_test_categories', 3600, function () {
            return TestCategory::orderBy('sort_order')->get();
        });

        $query = TestSet::with(['category', 'tests']);

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $testSets = $query->orderBy('id', 'asc')->paginate(9);

        return view('tests.index', compact('categories', 'testSets'));
    }

    public function show(string $slug): View
    {
        $testSet = TestSet::with(['category', 'tests.sections'])->where('slug', $slug)->firstOrFail();
        return view('tests.show_set', compact('testSet'));
    }

    public function takeExam(string $slug, Request $request): View
    {
        /** @var Test $test */
        $test = $this->queryBus->ask(new GetTestDetailQuery($slug));
        $mode = $request->query('mode', 'full_test');

        return view('tests.take', compact('test', 'mode'));
    }

    public function submit(int $id, Request $request): JsonResponse|RedirectResponse
    {
        $userId = $request->user()?->id ?? User::first()?->id ?? 1;

        $command = new SubmitTestCommand(
            userId: $userId,
            testId: $id,
            mode: (string) $request->input('mode', 'full_test'),
            timeSpentSeconds: (int) $request->input('time_spent_seconds', 0),
            answers: (array) $request->input('answers', [])
        );

        /** @var \Core\Contexts\Testing\Application\DTOs\SubmissionResultDTO $result */
        $result = $this->commandBus->dispatch($command);
        $submissionId = $result->submissionId;

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'submission_id' => $submissionId,
                'result' => [
                    'testId' => $result->testId,
                    'scoreRaw' => $result->scoreRaw,
                    'totalQuestions' => $result->totalQuestions,
                    'bandScore' => $result->bandScore,
                ],
                'redirect_url' => route('ielts.result', ['submission_id' => $submissionId]),
            ]);
        }

        return redirect()->route('ielts.result', ['submission_id' => $submissionId]);
    }

    public function result(int $submission_id): View
    {
        $result = $this->queryBus->ask(new GetSubmissionResultQuery($submission_id));
        return view('tests.result', compact('result'));
    }
}
