<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DictationTopic;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestSubmission;
use App\Models\User;
use App\Models\Vocabulary;
use App\Models\WritingSample;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_students' => User::where('role', 'user')->count(),
            'total_tests' => Test::count(),
            'total_submissions' => TestSubmission::count(),
            'total_dictation_topics' => DictationTopic::count(),
            'total_vocabularies' => Vocabulary::count(),
            'total_writing_samples' => WritingSample::count(),
            'avg_band_score' => round((float) TestSubmission::avg('band_score'), 1) ?: 6.5,
        ];

        $recentSubmissions = TestSubmission::with(['user', 'test'])
            ->latest()
            ->take(6)
            ->get();

        $recentTests = Test::with(['testSet.category'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentSubmissions', 'recentTests'));
    }
}
