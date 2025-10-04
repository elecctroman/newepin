<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::where('is_published', true)->latest()->paginate(10);

        return view('blog.index', compact('posts'));
    }

    public function show(BlogPost $post): View
    {
        abort_unless($post->is_published, 404);

        return view('blog.show', compact('post'));
    }
}
