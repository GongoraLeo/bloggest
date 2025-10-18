<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Últimos Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if($posts->isEmpty())
                        <p class="text-center text-gray-500">No hay posts para mostrar todavía.</p>
                    @else
                        <div class="space-y-8">
                            @foreach ($posts as $post)
                                <article class="p-6 bg-white dark:bg-gray-900/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent rounded-lg shadow-md transition-transform transform hover:scale-105">
                                    <div class="flex justify-between items-center mb-3 text-gray-500">
                                        <span class="text-sm">{{ $post->published_at->diffForHumans() }} por {{ $post->user->name }}</span>
                                    </div>
                                    <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                    </h2>
                                    <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
                                        {{ Str::limit($post->content, 250) }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
                                            Leer más
                                            <x-arrow-right-icon class="ml-2 w-4 h-4" />
                                        </a>
                                        <div class="text-sm text-gray-500">
                                            <x-chat-bubble-icon class="inline w-4 h-4" />
                                            <span>{{ $post->comments_count }} {{ Str::plural('Comentario', $post->comments_count) }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>