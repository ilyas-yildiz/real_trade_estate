<?php

use Illuminate\Support\Facades\Route;

// --- Controllers ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReferenceController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\PaymentController;


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

/*
|--------------------------------------------------------------------------
| Admin Paneli Rotaları - YENİ GÜVENLİ YAPI
|--------------------------------------------------------------------------
*/

// BÖLÜM 1: TÜM GİRİŞ YAPAN KULLANICILARIN GİREBİLECEĞİ ALAN
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // "Profilim" Sayfası (Finansal Bilgiler)
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/bank-account', [UserProfileController::class, 'storeBankAccount'])->name('profile.storeBankAccount');
    Route::delete('/profile/bank-account/{bankAccount}', [UserProfileController::class, 'destroyBankAccount'])->name('profile.destroyBankAccount');
    Route::post('/profile/crypto-wallet', [UserProfileController::class, 'storeCryptoWallet'])->name('profile.storeCryptoWallet');
    Route::delete('/profile/crypto-wallet/{cryptoWallet}', [UserProfileController::class, 'destroyCryptoWallet'])->name('profile.destroyCryptoWallet');

    // Ödeme Bildirim Sistemi (Kullanıcı Tarafı + Admin Liste)
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

    // YENİ EKLENDİ: Güvenli Dekont Görüntüleme Rotası
    Route::get('/payments/{payment}/receipt', [PaymentController::class, 'showReceipt'])->name('payments.showReceipt');

});

// Breeze'in Profil/Şifre Güncelleme Rotaları
Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// BÖLÜM 2: SADECE ADMİNLERİN GİREBİLECEĞİ YÖNETİM ALANLARI
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Resource Controllers (Mevcut Modüller)
       // Resource Controllers (Mevcut Modüller)
    $resourceControllers = [
        'categories' => CategoryController::class,
        'galleries' => GalleryController::class,
        'blogs' => BlogController::class,
        'authors' => AuthorController::class,
        'products' => ProductController::class,
        'abouts' => AboutController::class,
        'services' => ServiceController::class,
        'projects' => ProjectController::class,
        'slides' => SlideController::class,
        'references' => ReferenceController::class,
    ];
    foreach ($resourceControllers as $name => $controller) {
        Route::resource($name, $controller);
    }

    // Common (Generic) Rotalar
    Route::patch('{model}/{id}/status', [CommonController::class, 'updateStatus'])->name('common.updateStatus');
    Route::post('{model}/update-order', [CommonController::class, 'updateOrder'])->name('common.updateOrder');
    Route::post('{model}/bulk-delete', [CommonController::class, 'bulkDestroy'])->name('common.bulkDestroy');
    Route::post('common/upload-image', [CommonController::class, 'uploadImage'])->name('common.uploadImage');

    // Gallery Item Rotaları
    Route::post('/galleries/{gallery}/items', [GalleryItemController::class, 'store'])->name('galleries.items.store');
    Route::delete('galleries/items/{galleryItem}', [GalleryItemController::class, 'destroy'])->name('galleries.items.destroy');
    Route::put('galleries/{gallery}/cover-image', [GalleryController::class, 'updateCoverImage'])->name('galleries.updateCoverImage');

    // Blog Modülü AI Rotaları
    Route::get('blogs/ai/create', [BlogController::class, 'createWithAi'])->name('blogs.createWithAi');
    Route::get('blogs/ai/new-chat', [BlogController::class, 'startNewAiChat'])->name('blogs.startNewAiChat');
    Route::post('blogs/ai/generate', [BlogController::class, 'generateWithAi'])->name('blogs.generateWithAi');
    Route::post('blogs/ai/prepare', [BlogController::class, 'prepareFromAi'])->name('blogs.prepareFromAi');
    Route::post('blogs/ai/save-chat', [BlogController::class, 'saveCurrentChat'])->name('blogs.saveAiChat');
    Route::get('blogs/ai/load-chat/{chat}', [BlogController::class, 'loadChat'])->name('blogs.loadAiChat');
    Route::delete('blogs/ai/delete-chat/{chat}', [BlogController::class, 'destroyAiChat'])->name('blogs.destroyAiChat');

    // Laravel File Manager
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () { \UniSharp\LaravelFilemanager\Lfm::routes(); });

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    // Ödeme Bildirim Sistemi (Admin Yönetim Tarafı)
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show'); // İnceleme sayfası
    Route::match(['put', 'patch'], '/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update'); // Onay/Red işlemi
});

/*
|--------------------------------------------------------------------------
| Sistem Temizleme Rotaları
|--------------------------------------------------------------------------
*/
Route::get('/sistemi-temizle-12345', function () {
    try {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
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