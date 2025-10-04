<x-layouts.app title="Blog">
    <h1 class="text-3xl font-bold mb-4">Blog</h1>
    <div class="space-y-4">
        @foreach($posts as $post)
            <article class="bg-white rounded shadow p-4">
                <h2 class="text-2xl font-semibold"><a href="{{ route('blog.show', $post) }}" class="text-indigo-600">{{ $post->title }}</a></h2>
                <p class="text-sm text-gray-500">{{ $post->published_at?->format('d M Y') }}</p>
                <p class="mt-2">{{ $post->excerpt }}</p>
            </article>
        @endforeach
    </div>
    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</x-layouts.app>
