<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFlashcard;
use Core\Contexts\Vocabulary\Application\Queries\GetDueFlashcardsQuery;
use Core\Shared\Application\Bus\QueryBusInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FlashcardController extends Controller
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    public function index(Request $request): View
    {
        $userId = $request->user()?->id ?? User::first()?->id ?? 1;

        $totalCards = UserFlashcard::where('user_id', $userId)->count();
        $dueCardsCount = UserFlashcard::where('user_id', $userId)
            ->where('next_review_at', '<=', now()->toDateString())
            ->count();

        $recentCards = UserFlashcard::with('vocabulary')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->paginate(12);

        return view('flashcards.index', compact('totalCards', 'dueCardsCount', 'recentCards'));
    }

    public function studySession(Request $request): View
    {
        $userId = $request->user()?->id ?? User::first()?->id ?? 1;
        $dueCards = $this->queryBus->ask(new GetDueFlashcardsQuery($userId, 30));

        return view('flashcards.study', compact('dueCards'));
    }
}
