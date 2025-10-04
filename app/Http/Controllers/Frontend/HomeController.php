<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::where('auto_deliver', true)->take(8)->get();
        $blogPosts = BlogPost::where('is_published', true)->latest()->take(3)->get();

        return view('pages.home', compact('featuredProducts', 'blogPosts'));
    }
}
