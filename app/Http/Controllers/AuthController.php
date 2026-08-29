<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(6)],
            'target_band' => 'required|numeric|min:4.0|max:9.0',
        ], [
            'email.unique' => 'Email này đã được đăng ký trên hệ thống.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'target_band' => (float) $validated['target_band'],
            'streak_count' => 1,
            'last_study_date' => now(),
            'xp_points' => 50, // Welcome gift XP
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Chào mừng bạn đến với EduLearn! Bạn đã nhận được +50 XP thưởng khởi đầu.');
    }

    public function quickLogin(string $role): RedirectResponse
    {
        $email = ($role === 'admin') ? 'admin@edulearn.vn' : 'student@edulearn.vn';
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => ($role === 'admin') ? 'Admin EduLearn' : 'Nguyễn Minh Anh',
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => $role,
                'target_band' => ($role === 'admin') ? 8.5 : 7.5,
                'streak_count' => ($role === 'admin') ? 12 : 7,
                'last_study_date' => now(),
                'xp_points' => ($role === 'admin') ? 1450 : 820,
            ]);
        }

        Auth::login($user);
        request()->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Đã đăng nhập thành công với quyền Quản Trị Viên (Admin)!');
        }

        return redirect()->route('dashboard')->with('success', 'Đã đăng nhập thành công với tài khoản Học Viên!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Bạn đã đăng xuất khỏi hệ thống thành công.');
    }
}
