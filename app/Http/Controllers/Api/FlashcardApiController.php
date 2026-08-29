<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Core\Contexts\Vocabulary\Application\Commands\ReviewFlashcardCommand;
use Core\Shared\Application\Bus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FlashcardApiController extends Controller
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function submitReview(Request $request): JsonResponse
    {
        $userId = $request->user()?->id ?? User::first()?->id ?? 1;

        $command = new ReviewFlashcardCommand(
            userId: $userId,
            cardId: (int) $request->input('card_id'),
            grade: (int) $request->input('grade')
        );

        $result = $this->commandBus->dispatch($command);

        return response()->json([
            'success' => true,
            'result' => $result,
        ]);
    }
}
