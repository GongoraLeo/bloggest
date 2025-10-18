<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Contenido del Post -->
                    <article>
                        <div class="flex items-center mb-4 space-x-4">
                            @if($post->user->avatar_url)
                                <img class="w-10 h-10 rounded-full" src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }} avatar">
                            @else
                                <x-default-avatar-icon class="w-10 h-10 text-gray-400" />
                            @endif
                            <div class="font-medium dark:text-white">
                                <p>{{ $post->user->name }}</p>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Publicado {{ $post->published_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($post->content)) !!}
                        </div>

                        <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                            Visto {{ $post->views }} {{ Str::plural('vez', $post->views) }}
                        </div>
                    </article>

                    <!-- Sección de Comentarios -->
                    <section class="mt-10">
                        <h3 class="text-lg font-semibold mb-4">Comentarios ({{ $post->comments->total() }})</h3>

                        <!-- Formulario para añadir comentario -->
                        <div class="mb-6">
                            <form action="{{ route('posts.comments.store', $post) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="content" class="sr-only">Tu comentario</label>
                                    <textarea name="content" id="content" rows="4" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Escribe tu comentario..." required>{{ old('content') }}</textarea>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                </div>

                                @guest
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="name" class="sr-only">Nombre</label>
                                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="Tu nombre" :value="old('name')" required />
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>
                                        <div>
                                            <label for="email" class="sr-only">Email</label>
                                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" placeholder="Tu email" :value="old('email')" required />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                    </div>
                                @endguest

                                <x-primary-button>
                                    {{ __('Publicar Comentario') }}
                                </x-primary-button>
                            </form>
                        </div>

                        <!-- Lista de Comentarios -->
                        <div class="space-y-6">
                            @forelse ($post->comments as $comment)
                                <div class="p-4 bg-gray-100 dark:bg-gray-900 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center space-x-3">
                                            @if($comment->author_avatar)
                                                <img class="w-8 h-8 rounded-full" src="{{ $comment->author_avatar }}" alt="{{ $comment->author_name }} avatar">
                                            @else
                                                <x-default-avatar-icon class="w-8 h-8 text-gray-400" />
                                            @endif
                                            <div>
                                                <p class="font-semibold">{{ $comment->author_name }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Botones de Editar/Eliminar con Policies -->
                                        <div class="flex space-x-2">
                                            @can('update', $comment)
                                                <a href="{{ route('comments.edit', $comment) }}" class="text-sm text-blue-500 hover:underline">Editar</a>
                                            @endcan
                                            @can('delete', $comment)
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este comentario?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-500 hover:underline">Eliminar</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <p class="mt-3 text-gray-700 dark:text-gray-300">
                                        {{ $comment->content }}
                                    </p>
                                </div>
                            @empty
                                <p class="text-gray-500">Sé el primero en comentar.</p>
                            @endforelse
                        </div>

                        <!-- Paginación de Comentarios -->
                        <div class="mt-6">
                            {{ $post->comments->links('pagination::tailwind') }}
                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>