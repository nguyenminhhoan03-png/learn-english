<?php

use App\Http\Controllers\AiWritingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DictationController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SampleBankController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

// 1. Landing Page & Authentication
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
Route::get('/quick-login/{role}', [\App\Http\Controllers\AuthController::class, 'quickLogin'])->name('auth.quick_login');
Route::match(['get', 'post'], '/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Quick Demo Role Switcher
Route::get('/switch-user/{role}', [\App\Http\Controllers\AuthController::class, 'quickLogin'])->name('switch_user');

// 2. IELTS / TOEIC Online Testing
Route::prefix('luyen-thi-ielts')->name('ielts.')->group(function () {
    Route::get('/', [TestController::class, 'index'])->name('index');
    Route::get('/bo-de/{slug}', [TestController::class, 'show'])->name('show_set');
    Route::get('/take/{slug}', [TestController::class, 'takeExam'])->name('take');
    Route::post('/submit/{id}', [TestController::class, 'submit'])->middleware('throttle:exam-submit')->name('submit');
    Route::get('/result/{submission_id}', [TestController::class, 'result'])->name('result');
});

// 3. Dictation Studio (Nghe Chép Chính Tả)
Route::prefix('nghe-chep-chinh-ta')->name('dictation.')->group(function () {
    Route::get('/', [DictationController::class, 'index'])->name('index');
    Route::get('/{slug}', [DictationController::class, 'practice'])->name('practice');
});

// 4. Vocabulary Notebook & Flashcards SRS
Route::prefix('so-tu-vung')->name('flashcards.')->group(function () {
    Route::get('/', [FlashcardController::class, 'index'])->name('index');
    Route::get('/study', [FlashcardController::class, 'studySession'])->name('study');
});

// 5. Writing & Speaking Sample Bank
Route::prefix('bai-mau')->name('samples.')->group(function () {
    Route::get('/writing', [SampleBankController::class, 'writingIndex'])->name('writing.index');
    Route::get('/writing/{slug}', [SampleBankController::class, 'writingShow'])->name('writing.show');
    Route::get('/speaking', [SampleBankController::class, 'speakingIndex'])->name('speaking.index');
    Route::get('/speaking/{slug}', [SampleBankController::class, 'speakingShow'])->name('speaking.show');
});

// 6. AI Essay Grader
Route::prefix('ai-cham-bai')->name('ai.')->group(function () {
    Route::get('/', [AiWritingController::class, 'index'])->name('writing.index');
    Route::post('/grade', [AiWritingController::class, 'grade'])->middleware('throttle:ai-grade')->name('writing.grade');
});

// 7. Structured Learning Roadmaps (Lộ Trình Học Chuẩn Hóa)
Route::prefix('lo-trinh-hoc')->name('roadmaps.')->group(function () {
    Route::get('/', [\App\Http\Controllers\RoadmapController::class, 'index'])->name('index');
    Route::get('/{slug}', [\App\Http\Controllers\RoadmapController::class, 'show'])->name('show');
});

// 8. Learning Tools (Bảng Quy Đổi Điểm & Bảng Phát Âm IPA)
Route::prefix('cong-cu')->name('tools.')->group(function () {
    Route::get('/quy-doi-diem', [\App\Http\Controllers\ToolsController::class, 'scoreConverter'])->name('converter');
    Route::get('/bang-phat-am-ipa', [\App\Http\Controllers\ToolsController::class, 'ipaChart'])->name('ipa');
});

// 9. Student Analytics Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 8. Admin CMS Portal (Quản Trị Hệ Thống & Upload Đề Thi)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // IELTS Test Management
    Route::prefix('tests')->name('tests.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminTestController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminTestController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Admin\AdminTestController::class, 'store'])->name('store');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminTestController::class, 'destroy'])->name('destroy');
    });

    // Dictation Management
    Route::prefix('dictation')->name('dictation.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminDictationController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminDictationController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Admin\AdminDictationController::class, 'store'])->name('store');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminDictationController::class, 'destroy'])->name('destroy');
    });

    // Samples Bank Management
    Route::prefix('samples')->name('samples.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminSampleController::class, 'index'])->name('index');
        Route::get('/create-writing', [\App\Http\Controllers\Admin\AdminSampleController::class, 'createWriting'])->name('create_writing');
        Route::post('/store-writing', [\App\Http\Controllers\Admin\AdminSampleController::class, 'storeWriting'])->name('store_writing');
        Route::get('/create-speaking', [\App\Http\Controllers\Admin\AdminSampleController::class, 'createSpeaking'])->name('create_speaking');
        Route::post('/store-speaking', [\App\Http\Controllers\Admin\AdminSampleController::class, 'storeSpeaking'])->name('store_speaking');
        Route::delete('/writing/{id}', [\App\Http\Controllers\Admin\AdminSampleController::class, 'destroyWriting'])->name('destroy_writing');
        Route::delete('/speaking/{id}', [\App\Http\Controllers\Admin\AdminSampleController::class, 'destroySpeaking'])->name('destroy_speaking');
    });

    // Vocabulary Management
    Route::prefix('vocabulary')->name('vocabulary.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminVocabularyController::class, 'index'])->name('index');
        Route::post('/store', [\App\Http\Controllers\Admin\AdminVocabularyController::class, 'store'])->name('store');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminVocabularyController::class, 'destroy'])->name('destroy');
    });

    // Users & Submissions Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('index');
        Route::get('/submissions', [\App\Http\Controllers\Admin\AdminUserController::class, 'submissions'])->name('submissions');
        Route::post('/{id}/toggle-role', [\App\Http\Controllers\Admin\AdminUserController::class, 'toggleRole'])->name('toggle_role');
    });
});

// Dynamic XML Sitemap for Google Search Console
Route::get('/sitemap.xml', function () {
    $tests = \App\Models\Test::all();
    $testSets = \App\Models\TestSet::all();
    $dictations = \App\Models\DictationTopic::all();
    $writingSamples = \App\Models\WritingSample::all();
    $speakingSamples = \App\Models\SpeakingSample::all();

    $content = view('sitemap', compact('tests', 'testSets', 'dictations', 'writingSamples', 'speakingSamples'));
    return response($content, 200)->header('Content-Type', 'text/xml');
})->name('sitemap');
