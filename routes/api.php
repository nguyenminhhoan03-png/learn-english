<?php

use App\Http\Controllers\Api\DictationApiController;
use App\Http\Controllers\Api\DictionaryApiController;
use App\Http\Controllers\Api\FlashcardApiController;
use Illuminate\Support\Facades\Route;

// Dictionary 1-Click Lookup & Save
Route::post('/dictionary/lookup', [DictionaryApiController::class, 'lookup'])
    ->middleware('throttle:dictionary-lookup');

Route::post('/dictionary/save-word', [DictionaryApiController::class, 'saveWord']);

// Dictation Realtime Checking
Route::post('/dictation/verify-sentence', [DictationApiController::class, 'verifySentence'])
    ->middleware('throttle:dictation-verify');

// Flashcards SM-2 Review
Route::post('/flashcards/submit-review', [FlashcardApiController::class, 'submitReview']);
