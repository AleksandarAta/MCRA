<div wire:ignore>
    <div class="w-4/5 mx-auto p-6 bg-gray-200 shadow-lg rounded-lg font-sans  dark:text-white dark:bg-gray-800">
        <div class="flex flex-col justify-center ">
            <div class="flex">
                <img src="{{ asset($blog->user->profile_photo_path) }}" alt="blog user profile"
                    class="w-12 h-17 rounded-xl">
                <span class="self-center ml-3">{{ $blog->user->name }}</span>
            </div>
            <div class="w-full rounded-lg overflow-hidden mt-4">
                <img src="{{ $blog->image }}" alt="Blog Image" class="w-auto h-auto mx-auto ">
            </div>
            <div class="flex flex-col justify-center h-full mt-4">
                <h1 class="text-4xl text-gray-800 font-bold mb-4 dark:text-white">{{ $blog->title }}</h1>
                <p class="text-lg text-gray-700 leading-relaxed mb-6 dark:text-white">{{ $blog->body }}</p>
                <div class="mb-6 dark:text-white">
                    <span
                        class="inline-block bg-gray-300 text-orange-600 py-1 px-4 mr-2 mb-2 rounded-full text-sm dark:bg-gray-600 dark:text-orange-400">{{ $blog->keywords }}</span>
                </div>
            </div>
        </div>
        <div class="relative">
            <h2 class="text-3xl text-center text-orange-600 dark:text-orange-400">{{ __('Comments') }}</h2>
            @foreach ($comments as $comment)
                <div class="flex flex-col justify-center p-2">
                    <div class="{{ Auth::id() == $comment->user->id ? 'flex justify-between w-72' : 'flex' }}">
                        <div class="flex">
                            <img src="{{ asset($blog->user->profile_photo_path) }}" alt="pp"
                                class="w-10 h-15 rounded-xl mr-3">
                            <h5 class="self-center">{{ $comment->user->name }}</h5>
                        </div>
                        @if (Auth::id() == $comment->user->id)
                            <button
                                class="bg-red-400 text-dark dark:bg-red-800 dark:text-white rounded-xl mr-3 p-1  hover:text-red-400  hover:bg-white dark:hover:bg-white dark:hover:text-red-600"
                                type="button" @click="$dispatch('deleteComment', { commentId: {{ $comment->id }} })">
                                {{ __('Delete comment') }}
                            </button>
                        @endif
                    </div>
                    <blockquote class="pl-7
                                p-2">
                        {{ $comment->body }}
                    </blockquote>
                </div>
            @endforeach
            <livewire:comment.create-comment :$blog />
        </div>
    </div>
</div>
