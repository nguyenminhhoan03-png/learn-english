<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SpeakingSample;
use App\Models\WritingSample;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SampleBankController extends Controller
{
    public function writingIndex(Request $request): View
    {
        $task = $request->query('task');
        $query = WritingSample::query();

        if ($task) {
            $query->where('task_type', $task);
        }

        $samples = $query->orderBy('id', 'desc')->paginate(9);

        return view('samples.writing_index', compact('samples', 'task'));
    }

    public function writingShow(string $slug): View
    {
        $sample = WritingSample::where('slug', $slug)->firstOrFail();
        return view('samples.writing_show', compact('sample'));
    }

    public function speakingIndex(Request $request): View
    {
        $part = $request->query('part');
        $query = SpeakingSample::query();

        if ($part) {
            $query->where('part', $part);
        }

        $samples = $query->orderBy('id', 'desc')->paginate(9);

        return view('samples.speaking_index', compact('samples', 'part'));
    }

    public function speakingShow(string $slug): View
    {
        $sample = SpeakingSample::where('slug', $slug)->firstOrFail();
        return view('samples.speaking_show', compact('sample'));
    }
}
