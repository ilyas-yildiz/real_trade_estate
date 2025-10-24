<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller; // HATA DÜZELTİLDİ: Eksik olan bu satırdı.
use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Auth'u kullanabilmek için ekledik

class DashboardController extends Controller
{
    /**
     * Admin paneli anasayfasını gösterir ve gerekli verileri derler.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // GÜNCELLEME: Değişkenleri varsayılan (boş) değerleriyle başlatıyoruz.
        $totalBlogs = 0;
        $totalAuthors = 0;
        $totalCategories = 0;
        $latestBlogs = collect(); // Boş bir koleksiyon
        $activeAuthors = collect();
        $categoriesWithCount = collect();

        // GÜNCELLEME: Sadece admin ise veritabanı sorgularını çalıştır.
        if (Auth::user()->is_admin) {
            // 1. Üstteki büyük kartlar için temel istatistikleri çekiyoruz.
            $totalBlogs = Blog::count();
            $totalAuthors = Author::count();
            $totalCategories = Category::count();

            // 2. "En Son Eklenen Yazılar" tablosu için son 5 blogu ilişkileriyle birlikte çekiyoruz.
            $latestBlogs = Blog::with(['category', 'author'])->latest()->take(5)->get();

            // 3. "En Aktif Yazarlar" tablosu için, en çok yazısı olan 5 yazarı çekiyoruz.
            $activeAuthors = Author::withCount('blogs')->orderBy('blogs_count', 'desc')->take(5)->get();

            // 4. Sağ kenar çubuğundaki "Kategoriye Göre Yazı Sayısı" listesi için.
            $categoriesWithCount = Category::withCount('blogs')->orderBy('blogs_count', 'desc')->take(5)->get();
        }

        // Tüm verileri view'a 'compact' fonksiyonu ile gönderiyoruz.
        // Admin değilse, tüm bu değişkenler varsayılan (boş) halleriyle gidecek.
        return view('admin.dashboard.index', compact(
            'totalBlogs',
            'totalAuthors',
            'totalCategories',
            'latestBlogs',
            'activeAuthors',
            'categoriesWithCount'
        ));
    }
}