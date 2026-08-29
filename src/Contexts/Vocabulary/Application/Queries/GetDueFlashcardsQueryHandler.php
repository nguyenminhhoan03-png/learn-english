<?php

declare(strict_types=1);

namespace Core\Contexts\Vocabulary\Application\Queries;

use App\Models\UserFlashcard;
use Carbon\Carbon;
use Core\Shared\Application\Bus\QueryHandlerInterface;
use Illuminate\Database\Eloquent\Collection;

final class GetDueFlashcardsQueryHandler implements QueryHandlerInterface
{
    public function handle(GetDueFlashcardsQuery $query): Collection
    {
        $dueCards = UserFlashcard::with('vocabulary')
            ->where('user_id', $query->userId)
            ->where('next_review_at', '<=', Carbon::today())
            ->orderBy('next_review_at', 'asc')
            ->limit($query->limit)
            ->get();

        if ($dueCards->isEmpty()) {
            $dueCards = UserFlashcard::with('vocabulary')
                ->where('user_id', $query->userId)
                ->inRandomOrder()
                ->limit($query->limit)
                ->get();
        }

        return $dueCards;
    }
}
