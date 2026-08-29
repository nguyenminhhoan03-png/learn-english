<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

class ToolsController extends Controller
{
    public function scoreConverter(): View
    {
        return view('tools.converter');
    }

    public function ipaChart(): View
    {
        return view('tools.ipa_chart');
    }
}
