<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\LearningRoadmap;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoadmapController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $query = LearningRoadmap::with('phases');

        if ($category && in_array($category, ['ielts', 'toeic', 'communication', 'vstep'])) {
            $query->where('category', $category);
        }

        $roadmaps = $query->orderBy('sort_order', 'asc')->get();

        return view('roadmaps.index', compact('roadmaps', 'category'));
    }

    public function show(string $slug): View
    {
        $roadmap = LearningRoadmap::with('phases')->where('slug', $slug)->firstOrFail();
        $relatedRoadmaps = LearningRoadmap::where('id', '!=', $roadmap->id)->take(3)->get();

        return view('roadmaps.show', compact('roadmap', 'relatedRoadmaps'));
    }
}
