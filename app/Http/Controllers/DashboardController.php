<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\TestSubmission;
use App\Models\User;
use App\Models\UserDictationProgress;
use App\Models\UserFlashcard;
use Core\Contexts\Gamification\Domain\Services\WeaknessRadarEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly WeaknessRadarEngine $radarEngine
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user() 
            ?? User::where('role', 'user')->first() 
            ?? User::first();

        if (!$user) {
            $user = User::create([
                'name' => 'Nguyễn Minh Anh',
                'email' => 'student@edulearn.vn',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'target_band' => 7.5,
                'streak_count' => 7,
                'last_study_date' => now(),
                'xp_points' => 820,
            ]);
        }

        $userId = $user->id;

        $radarData = $this->radarEngine->calculateRadar($userId);

        $recentSubmissions = TestSubmission::with('test')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        $dictationCount = UserDictationProgress::where('user_id', $userId)->count();
        $vocabCount = UserFlashcard::where('user_id', $userId)->count();

        return view('dashboard.index', compact(
            'user',
            'radarData',
            'recentSubmissions',
            'dictationCount',
            'vocabCount'
        ));
    }
}
