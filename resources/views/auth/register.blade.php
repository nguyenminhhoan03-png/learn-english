@extends('layouts.app')

@section('title', 'Đăng Ký Tài Khoản Mới - EduLearn English')

@section('content')
<div class="min-h-[calc(100vh-14rem)] flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-4xl w-full bg-white rounded-3xl border border-slate-200/90 shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12">
        
        <!-- Left Column: Visual & Welcome Gift -->
        <div class="lg:col-span-5 bg-gradient-to-br from-indigo-950 via-slate-900 to-rose-950 p-8 sm:p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-600 flex items-center justify-center text-white shadow-glow">
                        <i data-lucide="zap" class="w-5 h-5 fill-current"></i>
                    </div>
                    <div>
                        <span class="text-xl font-black font-display tracking-tight text-white block leading-none">EduLearn</span>
                        <span class="text-[9px] font-bold uppercase tracking-wider text-rose-400">Linearthinking Method</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <h2 class="text-2xl font-black font-display text-white leading-tight">Gia Nhập Cộng Đồng 100,000+ Thí Sinh</h2>
                    <p class="text-xs text-slate-300 font-medium leading-relaxed">
                        Tạo tài khoản học viên miễn phí hôm nay để nhận ngay lộ trình cá nhân hóa và các đặc quyền luyện thi hàng đầu.
                    </p>
                </div>

                <!-- Welcome Gift Card -->
                <div class="p-4 bg-white/10 backdrop-blur-md rounded-2xl border border-white/15 space-y-2">
                    <div class="flex items-center space-x-2 text-amber-400 font-bold text-xs">
                        <i data-lucide="gift" class="w-4 h-4"></i>
                        <span>Quà Tặng Tân Thủ Khởi Đầu:</span>
                    </div>
                    <ul class="text-xs space-y-1.5 text-slate-200">
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span>Tặng ngay <strong>+50 XP</strong> thăng hạng cấp bậc</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span>Khởi tạo chuỗi <strong>Streak 🔥 Ngày 1</strong></span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span>Mở khóa toàn bộ <strong>40+ đề thi Cambridge</strong></span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="relative mt-6 pt-4 border-t border-slate-800 text-[11px] text-slate-400 text-center">
                Bằng việc đăng ký, bạn đồng ý với Điều khoản dịch vụ và Chính sách bảo mật của EduLearn.
            </div>
        </div>

        <!-- Right Column: Register Form -->
        <div class="lg:col-span-7 p-8 sm:p-10 flex flex-col justify-center space-y-6" x-data="{ showPass: false }">
            
            <!-- Auth Navigation Tabs -->
            <div class="flex items-center p-1.5 bg-slate-100 rounded-2xl">
                <a href="{{ route('login') }}" class="flex-1 py-2 text-center text-xs font-bold rounded-xl text-slate-600 hover:text-slate-900 transition">
                    Đăng Nhập
                </a>
                <a href="{{ route('register') }}" class="flex-1 py-2 text-center text-xs font-black rounded-xl bg-white text-rose-600 shadow-xs transition">
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

            <!-- Register Form -->
            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wide mb-1.5">Họ Và Tên Học Viên:</label>
                    <div class="relative">
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="VD: Nguyễn Văn A" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-rose-500 text-xs font-semibold text-slate-900">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wide mb-1.5">Địa Chỉ Email:</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="email-cua-ban@gmail.com" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-rose-500 text-xs font-semibold text-slate-900">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wide mb-1.5">Mục Tiêu Target Band:</label>
                        <select name="target_band" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-rose-500 text-xs font-bold text-slate-900">
                            <option value="6.5">Band 6.5 (Khá)</option>
                            <option value="7.0">Band 7.0 (Giỏi)</option>
                            <option value="7.5" selected>Band 7.5 (Rất Tốt)</option>
                            <option value="8.0">Band 8.0 (Xuất Sắc)</option>
                            <option value="8.5">Band 8.5 (Chuyên Gia)</option>
                            <option value="9.0">Band 9.0 (Tuyệt Đối)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wide mb-1.5">Mật Khẩu:</label>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" name="password" required placeholder="Tối thiểu 6 ký tự..." class="w-full pl-3 pr-8 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-rose-500 text-xs font-semibold text-slate-900">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600">
                                <i data-lucide="eye" class="w-3.5 h-3.5" x-show="!showPass"></i>
                                <i data-lucide="eye-off" class="w-3.5 h-3.5" x-show="showPass" style="display: none;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-700 uppercase tracking-wide mb-1.5">Xác Nhận Mật Khẩu:</label>
                    <input :type="showPass ? 'text' : 'password'" name="password_confirmation" required placeholder="Nhập lại mật khẩu..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-rose-500 text-xs font-semibold text-slate-900">
                </div>

                <button type="submit" class="w-full py-3.5 bg-rose-600 hover:bg-rose-700 text-white font-black text-xs rounded-xl shadow-glow transition transform hover:-translate-y-0.5 mt-2">
                    🚀 Đăng Ký Tài Khoản & Nhận +50 XP Ngay
                </button>
            </form>

            <div class="text-center text-xs text-slate-500">
                Đã có tài khoản từ trước? 
                <a href="{{ route('login') }}" class="font-extrabold text-rose-600 hover:underline">Đăng nhập tại đây</a>
            </div>
        </div>
    </div>
</div>
@endsection
