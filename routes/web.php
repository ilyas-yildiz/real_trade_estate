<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// --- Controllers ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Models\WithdrawalRequest;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReferenceController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\WithdrawalRequestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FinancialReportController;
use App\Http\Controllers\Admin\DepositMethodsController;
use App\Http\Controllers\Admin\PasswordRequestController;


/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::name('frontend.')->group(function () {
    Route::get('/', [FrontendController::class, 'index'])->name('home');
    Route::get('/hakkimizda', [FrontendController::class, 'about'])->name('about');
    Route::get('/hizmetlerimiz', [FrontendController::class, 'servicesIndex'])->name('services');
    Route::get('/hizmetlerimiz/{slug}', [FrontendController::class, 'serviceDetail'])->name('services.detail');
    Route::get('/projelerimiz', [FrontendController::class, 'projectsIndex'])->name('projects');
    Route::get('/projelerimiz/{slug}', [FrontendController::class, 'projectDetail'])->name('projects.detail');
    Route::get('/blog', [FrontendController::class, 'blogIndex'])->name('blog.index');
    Route::get('/blog/{slug}', [FrontendController::class, 'blogDetail'])->name('blog.detail');
    Route::get('/iletisim', [FrontendController::class, 'contact'])->name('contact');
    Route::post('/iletisim', [FrontendController::class, 'handleContactForm'])->name('contact.submit');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

// Auth sonrası dashboard yönlendirmesi
Route::get('/dashboard', function (Request $request) {
    // Gelen isteğin tüm sorgu parametrelerini (örn: ?verified=1) al
    $queryParams = $request->query();
    
    // Yönlendirirken bu parametreleri de hedefe ekle
    return redirect()->route('admin.dashboard', $queryParams);

})->middleware(['auth', 'verified'])->name('dashboard');

// YENİ GRUP: Sadece Bayiler (role=1) girebilir
Route::middleware(['auth', 'bayi'])->prefix('bayi')->name('bayi.')->group(function () {
    
    // Bayi Controller'ını en üste 'use' ile eklemeyi unutma
    // use App\Http\Controllers\Bayi\DashboardController;
    
    Route::get('/dashboard', [App\Http\Controllers\Bayi\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/customers', [App\Http\Controllers\Bayi\DashboardController::class, 'customers'])->name('customers');
    Route::get('/withdrawals', [App\Http\Controllers\Bayi\DashboardController::class, 'withdrawals'])->name('withdrawals');
    Route::get('/commissions', [App\Http\Controllers\Bayi\DashboardController::class, 'commissions'])->name('commissions');

});

/*
|--------------------------------------------------------------------------
| Admin Paneli Rotaları - YENİ GÜVENLİ YAPI
|--------------------------------------------------------------------------
*/

// BÖLÜM 1: TÜM GİRİŞ YAPAN KULLANICILAR
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // "Profilim" Sayfası (Finansal Bilgiler)
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::get('/account-statement', [UserProfileController::class, 'statement'])->name('profile.statement');
    Route::post('/profile/bank-account', [UserProfileController::class, 'storeBankAccount'])->name('profile.storeBankAccount');
    Route::delete('/profile/bank-account/{bankAccount}', [UserProfileController::class, 'destroyBankAccount'])->name('profile.destroyBankAccount');
    Route::post('/profile/crypto-wallet', [UserProfileController::class, 'storeCryptoWallet'])->name('profile.storeCryptoWallet');
    Route::delete('/profile/crypto-wallet/{cryptoWallet}', [UserProfileController::class, 'destroyCryptoWallet'])->name('profile.destroyCryptoWallet');
    Route::post('/profile/request-password', [UserProfileController::class, 'requestPasswordChange'])->name('profile.requestPasswordChange');
    
    // Ödeme Bildirim Sistemi (Kullanıcı Tarafı)
    Route::resource('/payments', PaymentController::class)->only([
        'index', 'create', 'store', 'destroy'
    ]);
    
    // Güvenli Dekont Görüntüleme Rotası
    Route::get('/payments/{payment}/receipt', [PaymentController::class, 'showReceipt'])->name('payments.showReceipt');

    // Çekim Talebi Sistemi (Kullanıcı Tarafı)
    Route::resource('/withdrawals', WithdrawalRequestController::class)->only([
        'index', 'create', 'store', 'destroy'
    ]);
    Route::get('/how-to-deposit', [DepositMethodsController::class, 'showPage'])->name('deposit_methods.show_page');
    // Bildirim İşlemleri
    // Bildirim İşlemleri
    Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index'); // YENİ: Liste Sayfası
    Route::get('/notifications/{id}/read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsReadAndRedirect'])->name('notifications.read');
    Route::get('/notifications/read-all', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy'); // YENİ: Silme

});

// Breeze Profil Güncelleme Rotaları
Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// BÖLÜM 2: SADECE ADMİNLER
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Mevcut Resource Controllers
    Route::resource('categories', CategoryController::class);
    Route::resource('galleries', GalleryController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('products', ProductController::class);
    Route::resource('abouts', AboutController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('slides', SlideController::class);
    Route::resource('references', ReferenceController::class);

    // Payment için Admin'e özel 'edit' ve 'update' rotaları
    Route::resource('/payments', PaymentController::class)->only([
        'edit', 'update' // 'edit' (JSON döner), 'update' (formu işler)
    ]);

    // Withdrawal için Admin'e özel 'edit' ve 'update' rotaları
    Route::resource('/withdrawals', WithdrawalRequestController::class)->only([
        'edit', 'update' // 'edit' (JSON döner), 'update' (formu işler)
    ]);

    // Common (Generic) Rotalar
    Route::patch('{model}/{id}/status', [CommonController::class, 'updateStatus'])->name('common.updateStatus');
    Route::post('{model}/update-order', [CommonController::class, 'updateOrder'])->name('common.updateOrder');
    Route::post('{model}/bulk-delete', [CommonController::class, 'bulkDestroy'])->name('common.bulkDestroy');
    Route::post('common/upload-image', [CommonController::class, 'uploadImage'])->name('common.uploadImage');

    // Diğer admin rotaları...
    Route::post('/galleries/{gallery}/items', [GalleryItemController::class, 'store'])->name('galleries.items.store');
    Route::delete('galleries/items/{galleryItem}', [GalleryItemController::class, 'destroy'])->name('galleries.items.destroy');
    Route::put('galleries/{gallery}/cover-image', [GalleryController::class, 'updateCoverImage'])->name('galleries.updateCoverImage');
    Route::get('blogs/ai/create', [BlogController::class, 'createWithAi'])->name('blogs.createWithAi');
    Route::get('blogs/ai/new-chat', [BlogController::class, 'startNewAiChat'])->name('blogs.startNewAiChat');
    Route::post('blogs/ai/generate', [BlogController::class, 'generateWithAi'])->name('blogs.generateWithAi');
    Route::post('blogs/ai/prepare', [BlogController::class, 'prepareFromAi'])->name('blogs.prepareFromAi');
    Route::post('blogs/ai/save-chat', [BlogController::class, 'saveCurrentChat'])->name('blogs.saveAiChat');
    Route::get('blogs/ai/load-chat/{chat}', [BlogController::class, 'loadChat'])->name('blogs.loadAiChat');
    Route::delete('blogs/ai/delete-chat/{chat}', [BlogController::class, 'destroyAiChat'])->name('blogs.destroyAiChat');
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () { \UniSharp\LaravelFilemanager\Lfm::routes(); });
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::resource('users', UserController::class)->only([
        'index', 'edit', 'update'
    ]);
    // YENİ ROTALAR: Adminin Müşteri Adına Ödeme Eklemesi
    Route::post('/payments/create-for-user', [PaymentController::class, 'storeForUser'])->name('payments.storeForUser');
    Route::get('/financial-report', [FinancialReportController::class, 'index'])->name('financial.report');
    // YENİ: Admin Yatırım Hesapları CRUD Rotaları
    Route::get('/deposit-methods', [DepositMethodsController::class, 'index'])->name('deposit_methods.index');
    Route::post('/deposit-methods/bank', [DepositMethodsController::class, 'storeBank'])->name('deposit_methods.storeBank');
    Route::post('/deposit-methods/crypto', [DepositMethodsController::class, 'storeCrypto'])->name('deposit_methods.storeCrypto');
    Route::delete('/deposit-methods/bank/{id}', [DepositMethodsController::class, 'destroyBank'])->name('deposit_methods.destroyBank');
    Route::delete('/deposit-methods/crypto/{id}', [DepositMethodsController::class, 'destroyCrypto'])->name('deposit_methods.destroyCrypto');
    Route::get('/password-requests', [PasswordRequestController::class, 'index'])->name('password_requests.index');
    Route::post('/password-requests/{id}/approve', [PasswordRequestController::class, 'approve'])->name('password_requests.approve');
    Route::post('/password-requests/{id}/reject', [PasswordRequestController::class, 'reject'])->name('password_requests.reject');

});

/* Sistem Temizleme Rotaları */
Route::get('/sistemi-temizle-12345', function () {
    try {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('optimize:clear');
        return "Butun onbellekler temizlendi!";
    } catch (Exception $e) {
        return "Hata: " . $e->getMessage();
    }
});

Route::get('/run-user-seeder-a1b2c3d4e5f6', function () {
    try {
        Artisan::call('db:seed', ['--class' => 'UserSeeder', '--force' => true]);
        return 'UserSeeder başarıyla çalıştırıldı.';
    } catch (\Exception $e) {
        return 'Hata: ' . $e->getMessage();
    }
});

Route::get('/migrate-now', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return 'Veritabanı başarıyla güncellendi!';
    } catch (Exception $e) {
        return 'Hata oluştu: ' . $e->getMessage();
    }
});

