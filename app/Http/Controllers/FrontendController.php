<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Project;
use App\Models\Reference;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    protected $settings;

    /**
     * Controller başlatıldığında, tüm view'larla ayarları paylaş.
     */
    public function __construct()
    {
        // Ayarları veritabanından çek ve bir diziye dönüştür
        $this->settings = Setting::pluck('value', 'key')->all();
        
        // Ayarları tüm frontend view'larıyla paylaş
        View::share('settings', $this->settings);
    }

    /**
     * Anasayfayı gösterir.
     * Gerekli tüm dinamik verileri çeker.
     */
    public function index()
    {
        $slides = Slide::where('status', 1)->orderBy('order', 'asc')->get();
        
        // Sadece ilk "hakkımızda" kaydını al
        $about = About::where('status', 1)->first(); 
        
        $services = Service::where('status', 1)->orderBy('order', 'asc')->get();
        
        // Blogları kategorileriyle birlikte çek (Eager Loading)
        $blogs = Blog::with('category')
                    ->where('status', 1)
                    ->latest() // En son eklenenler
                    ->take(3)  // Sadece 3 tane al (home.blade.php 3'lü setler halinde gösteriyor)
                    ->get();
                    
        $references = Reference::where('status', 1)->get();

        return view('frontend.home', compact(
            'slides',
            'about',
            'services',
            'blogs',
            'references'
            // $settings zaten View::share ile paylaşıldı
        ));
    }

    /**
     * Hakkımızda sayfasını gösterir.
     */
    public function about()
    {
        $about = About::where('status', 1)->first();
        // İleride referansları vb. de bu sayfaya gönderebiliriz
        return view('frontend.about', compact('about'));
    }

    /**
     * Hizmetler (Hesap Türleri) listeleme sayfasını gösterir.
     */
    public function servicesIndex()
    {
        $services = Service::where('status', 1)->orderBy('order', 'asc')->paginate(9);
        return view('frontend.services.index', compact('services'));
    }

    /**
     * Tek bir hizmetin (Hesap Türü) detay sayfasını gösterir.
     */
    public function serviceDetail($slug)
    {
        $service = Service::where('slug', $slug)->where('status', 1)->firstOrFail();
        return view('frontend.services.detail', compact('service'));
    }

    /**
     * Projeler listeleme sayfasını gösterir.
     */
    public function projectsIndex()
    {
        $projects = Project::where('status', 1)->orderBy('order', 'asc')->paginate(9);
        return view('frontend.projects.index', compact('projects'));
    }

    /**
     * Tek bir projenin detay sayfasını gösterir.
     */
    public function projectDetail($slug)
    {
        $project = Project::where('slug', $slug)->where('status', 1)->firstOrFail();
        return view('frontend.projects.detail', compact('project'));
    }

    /**
     * Blog listeleme sayfasını gösterir.
     */
    public function blogIndex(Request $request)
    {
        $query = Blog::with('category')->where('status', 1);

        // Kategoriye göre filtreleme (opsiyonel)
        if ($request->has('category')) {
            $categorySlug = $request->get('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }
        
        $blogs = $query->latest()->paginate(9);
        $categories = Category::all();
        
        return view('frontend.blog.index', compact('blogs', 'categories'));
    }

    /**
     * Tek bir blog yazısının detay sayfasını gösterir.
     */
    public function blogDetail($slug)
    {
        $blog = Blog::where('slug', $slug)->where('status', 1)->firstOrFail();
        $latestBlogs = Blog::where('status', 1)->where('id', '!=', $blog->id)->latest()->take(3)->get();
        $categories = Category::all();
        
        return view('frontend.blog.detail', compact('blog', 'latestBlogs', 'categories'));
    }

    /**
     * İletişim sayfasını gösterir.
     */
    public function contact()
    {
        // $settings zaten paylaşıldı (telefon, adres vb. için)
        return view('frontend.contact');
    }

    /**
     * İletişim formunu işler.
     */
    public function handleContactForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
            // 'phone', 'subject' vb. eklenebilir
        ]);

        // TODO: E-posta gönderme veya veritabanına kaydetme mantığı
        // Örn: Mail::to($this->settings['admin_email'])->send(new ContactFormMail($validated));

        return back()->with('success', 'Mesajınız başarıyla gönderildi!');
    }
}
