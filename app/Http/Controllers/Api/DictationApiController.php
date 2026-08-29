<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Core\Contexts\Dictation\Application\Commands\VerifySentenceCommand;
use Core\Shared\Application\Bus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DictationApiController extends Controller
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {}

    public function verifySentence(Request $request): JsonResponse
    {
        $userId = $request->user()?->id ?? User::first()?->id ?? 1;

        $command = new VerifySentenceCommand(
            userId: $userId,
            sentenceId: (int) $request->input('sentence_id'),
            userInput: (string) $request->input('user_input', '')
        );

        $result = $this->commandBus->dispatch($command);

        return response()->json([
            'success' => true,
            'result' => $result,
        ]);
    }
}
