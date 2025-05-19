<div x-data="{ isOpen: false }">
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight self-center">
                    {{ __('Blogs') }}
                </h2>
                <div class="flex justify-between {{ auth()->user()->hasRole('admin') ? 'w-5/12' : 'w-2/6' }}">
                    @can('admin')
                        <button x-on:click = "isOpen = !isOpen"
                            class="whitespace-nowrap rounded p-1 bg-orange-400  hover:text-black hover:bg-white hover:border hover:border-orange-400  dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400 text-sm"
                            x-text="isOpen ? '{{ __('Show as User') }}' : '{{ __('Show as Admin') }}'"></button>
                    @endcan
                    @can('editor')
                        <button
                            class="whitespace-nowrap rounded p-1 bg-orange-400  hover:text-black hover:bg-white hover:border hover:border-orange-400  dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400 text-sm">
                            <a href="{{ route('blogs.create') }}"> {{ __('Create a new blog') }}</a>
                        </button>
                    @endcan

                    <livewire:blogs.search-blogs />
                </div>
            </div>
        </x-slot>
        <div class="py-12">
            <div class="w-2/3 mx-auto sm:px-6 lg:px-8">
                <div id="userInterface" class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"
                    x-show = "!isOpen" x-transition>
                    <div class="grid grid-cols-5 gap-4 p-2 ">
                        @foreach ($blogs as $blog)
                            <div
                                class="max-w-3xl mx-auto p-6 bg-gray-200 dark:bg-gray-900 rounded-lg shadow-md relative h-96">

                                @if ($blog->image)
                                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}"
                                        class="w-full h-32 object-cover rounded-md mb-4">
                                @endif

                                <h1 class="text-1xl font-bold text-gray-900 dark:text-white mb-2">
                                    {{ $blog->title }}
                                </h1>

                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    Posted by User {{ $blog->user->name }} on
                                    <time datetime="{{ $blog->created_at->toDateString() }}">
                                        {{ $blog->created_at->format('F j, Y') }}
                                    </time>
                                </p>

                                <div class="prose dark:prose-invert max-w-none mb-4">
                                    <p>{!! Str::words($blog->body, 3, ' ...') !!}</p>
                                </div>
                                <a href="{{ route('blogs.show', $blog->slug) }}">
                                    <button
                                        class="rounded p-2 absolute bottom-2 right-2 bg-orange-400 hover:text-black hover:bg-white hover:border hover:border-orange-400 ml-3 dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400">
                                        {{ __('Show More') }}</button>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="p-3">
                        {{ $blogs->links() }}
                    </div>
                </div>
                <div x-show="isOpen" x-transition>
                    <template x-if="isOpen">
                        <livewire:blogs.admin.index />
                    </template>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
