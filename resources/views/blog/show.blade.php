<x-layouts.app :title="$post->title">
    <article class="bg-white rounded shadow p-6">
        <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
        <p class="text-sm text-gray-500 mb-4">{{ $post->published_at?->format('d M Y') }}</p>
        <div class="prose max-w-none">
            {!! nl2br(e($post->content)) !!}
        </div>
    </article>
</x-layouts.app>
