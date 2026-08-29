<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AiWritingEvaluation;
use App\Models\User;
use Core\Contexts\AiEvaluation\Application\Commands\GradeEssayCommand;
use Core\Shared\Application\Bus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AiWritingController extends Controller
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function index(Request $request): View
    {
        $userId = $request->user()?->id ?? User::first()?->id ?? 1;
        $evaluations = AiWritingEvaluation::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        return view('ai.writing', compact('evaluations'));
    }

    public function grade(Request $request): JsonResponse
    {
        $request->validate([
            'task_type' => 'required|string|in:task1,task2',
            'prompt' => 'required|string|min:10',
            'user_essay' => 'required|string|min:50',
        ]);

        $userId = $request->user()?->id ?? User::first()?->id ?? 1;

        $command = new GradeEssayCommand(
            userId: $userId,
            taskType: (string) $request->input('task_type'),
            prompt: (string) $request->input('prompt'),
            userEssay: (string) $request->input('user_essay')
        );

        $evaluation = $this->commandBus->dispatch($command);

        return response()->json([
            'success' => true,
            'evaluation' => $evaluation,
        ]);
    }
}
