<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestSubmission;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = User::withCount(['submissions', 'flashcards', 'dictationProgress']);

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->latest()->paginate(10);
        return view('admin.users.index', compact('users', 'search'));
    }

    public function submissions(Request $request): View
    {
        $submissions = TestSubmission::with(['user', 'test'])
            ->latest()
            ->paginate(15);

        return view('admin.users.submissions', compact('submissions'));
    }

    public function toggleRole(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->role = ($user->role === 'admin') ? 'user' : 'admin';
        $user->save();

        return redirect()->route('admin.users.index')->with('success', "Đã thay đổi quyền tài khoản {$user->name} thành {$user->role}.");
    }
}
