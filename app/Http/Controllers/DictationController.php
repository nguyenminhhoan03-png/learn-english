<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\DictationTopic;
use App\Models\User;
use Core\Contexts\Dictation\Application\Queries\GetTopicDetailQuery;
use Core\Shared\Application\Bus\QueryBusInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DictationController extends Controller
{
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {}

    public function index(Request $request): View
    {
        $level = $request->query('level');
        $query = DictationTopic::with('sentences');

        if ($level) {
            $query->where('level', $level);
        }

        $topics = $query->paginate(9);

        return view('dictation.index', compact('topics', 'level'));
    }

    public function practice(string $slug, Request $request): View
    {
        $userId = $request->user()?->id ?? User::first()?->id ?? 1;
        $data = $this->queryBus->ask(new GetTopicDetailQuery($slug, $userId));

        return view('dictation.practice', [
            'topic' => $data['topic'],
            'userProgress' => $data['user_progress'],
        ]);
    }
}
