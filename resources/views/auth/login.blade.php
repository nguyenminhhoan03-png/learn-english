@extends('layouts.app')

@section('title', 'Đăng Nhập Tài Khoản - LearnEnglish')

@section('content')
<div class="min-h-[calc(100vh-14rem)] flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-4xl w-full bg-white rounded-3xl border border-slate-200/90 shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12">
        
        <!-- Left Column: Visual & Benefits Showcase -->
        <div class="lg:col-span-5 bg-gradient-to-br from-slate-900 via-rose-950 to-slate-900 p-8 sm:p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <!-- Background Glow & Pattern -->
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-600 flex items-center justify-center text-white shadow-glow">
                        <i data-lucide="zap" class="w-5 h-5 fill-current"></i>
                    </div>
                    <div>
                        <span class="text-xl font-black font-display tracking-tight text-white block leading-none">LearnEnglish</span>
                        <span class="text-[9px] font-bold uppercase tracking-wider text-rose-400">Linearthinking Method</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <h2 class="text-2xl font-black font-display text-white leading-tight">Bứt Phá Điểm Số IELTS & TOEIC</h2>
                    <p class="text-xs text-slate-300 font-medium leading-relaxed">
                        Hệ thống tự học tiếng Anh thông minh ứng dụng tư duy logic toán học Linearthinking, giảm 50% thời gian làm bài thi.
                    </p>
                </div>

                <!-- Feature Highlights List -->
                <div class="space-y-3 pt-2">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 rounded-lg bg-rose-500/20 text-rose-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        </div>
                        <p class="text-xs text-slate-200">Trọn bộ 40+ đề Cambridge 10 - 19 có giải thích chi tiết cấu trúc nòng cốt.</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        </div>
                        <p class="text-xs text-slate-200">AI chấm Writing 4 tiêu chí chuẩn giám khảo quốc tế.</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        </div>
                        <p class="text-xs text-slate-200">Thuật toán SuperMemo SM-2 ghi nhớ từ vựng vĩnh viễn.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Badge -->
            <div class="relative mt-8 pt-6 border-t border-slate-800 flex items-center justify-between text-xs">
                <div>
                    <span class="block text-lg font-black text-rose-400">100K+</span>
                    <span class="text-[10px] text-slate-400">Học viên tin dùng</span>
                </div>
                <div>
                    <span class="block text-lg font-black text-emerald-400">8.0+</span>
                    <span class="text-[10px] text-slate-400">Điểm thi trung bình</span>
                </div>
                <div>
                    <span class="block text-lg font-black text-indigo-400">99.4%</span>
                    <span class="text-[10px] text-slate-400">Đạt mục tiêu</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Authentication Card -->
        <div class="lg:col-span-7 p-8 sm:p-10 flex flex-col justify-center space-y-6" x-data="{ showPass: false }">
            
            <!-- Auth Navigation Tabs -->
            <div class="flex items-center p-1.5 bg-slate-100 rounded-2xl">
                <a href="{{ route('login') }}" class="flex-1 py-2.5 text-center text-xs font-black rounded-xl bg-white text-rose-700 shadow-xs transition">
                    Đăng Nhập
                </a>
                <a href="{{ route('register') }}" class="flex-1 py-2.5 text-center text-xs font-bold rounded-xl text-slate-700 hover:text-slate-900 transition">
                    Tạo Tài Khoản Mới
                </a>
            </div>

            <!-- Errors Alert -->
            @if ($errors->any())
            <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold rounded-2xl flex items-center space-x-2">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <!-- Standard Login Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wide mb-1.5">Địa Chỉ Email:</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email', 'admin@learnenglish.vn') }}" required placeholder="your-email@example.com" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-rose-500 text-xs font-semibold text-slate-900">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wide mb-1.5">Mật Khẩu:</label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" value="password123" required placeholder="Nhập mật khẩu..." class="w-full pl-10 pr-10 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-rose-500 text-xs font-semibold text-slate-900">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                            <i data-lucide="eye" class="w-4 h-4" x-show="!showPass"></i>
                            <i data-lucide="eye-off" class="w-4 h-4" x-show="showPass" style="display: none;"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 text-slate-600 font-semibold cursor-pointer select-none">
                        <input type="checkbox" name="remember" checked class="text-rose-600 focus:ring-rose-500 rounded h-4 w-4">
                        <span>Ghi nhớ đăng nhập</span>
                    </label>
                    <a href="#" class="text-rose-600 hover:underline font-bold">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="w-full py-3.5 bg-rose-600 hover:bg-rose-700 text-white font-black text-xs rounded-xl shadow-glow transition transform hover:-translate-y-0.5">
                    Đăng Nhập Vào Hệ Thống →
                </button>
            </form>

            <div class="text-center text-xs text-slate-500">
                Chưa có tài khoản học viên? 
                <a href="{{ route('register') }}" class="font-extrabold text-rose-600 hover:underline">Đăng ký miễn phí ngay</a>
            </div>
        </div>
    </div>
</div>
@endsection
