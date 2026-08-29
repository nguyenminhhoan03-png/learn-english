<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\DictationTopic;
use App\Models\Test;
use App\Models\WritingSample;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredTests = Test::with('testSet.category')
            ->orderBy('views_count', 'desc')
            ->limit(4)
            ->get();

        $dictationTopics = DictationTopic::orderBy('id', 'asc')
            ->limit(3)
            ->get();

        $writingSamples = WritingSample::orderBy('id', 'desc')
            ->limit(3)
            ->get();

        return view('home', compact('featuredTests', 'dictationTopics', 'writingSamples'));
    }
}
