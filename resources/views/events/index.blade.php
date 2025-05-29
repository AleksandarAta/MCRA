<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight self-center">
                {{ __('Events') }}
            </h2>
            <div class="flex justify-end {{ auth()->user()->hasRole('admin') ? 'w-4/12 justify-between' : 'w-full' }}">
                @can('admin')
                    <button
                        class="whitespace-nowrap rounded p-1 bg-orange-400  hover:text-black hover:bg-white hover:border hover:border-orange-400  dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400 text-sm">
                        <a href="{{ route('blogs.create') }}"> {{ __('Create a new event') }}</a>
                    </button>
                @endcan

                <livewire:blogs.search-blogs />
            </div>
        </div>
    </x-slot>
    <div>
        <div class="min-h-screen bg-gray-200 dark:bg-gray-900 text-white py-8 px-4">
            <div class="max-w-6xl mx-auto space-y-6">

                @foreach ($events as $event)
                    <div class= "bg-gray-400 dark:bg-gray-800 border-l-4 border-orange-500 rounded-lg shadow p-6">
                        <h2 class="text-2xl font-bold dark:text-orange-400 mb-2 text-orange-700">
                            {{ $event->Title }}
                        </h2>

                        <p class="text-sm text-white  dark:text-gray-400 mb-1">
                            {{ __('Posted on') }}:
                            <span class="text-orange-700 dark:text-orange-300">
                                {{ \Carbon\Carbon::parse($event->created_at)->format('F j, Y') }}
                            </span>
                        </p>

                        <p class="text-sm text-white dark:text-gray-400 mb-4">
                            {{ __('Event Date') }}:
                            <span class="text-orange-700 dark:text-orange-300">
                                {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}
                            </span>
                        </p>

                        <p class="text-white dark:text-gray-300 mb-4">
                            {{ Str::limit($event->text, 200) }}
                        </p>

                        <div class="text-sm text-white dark:text-gray-400 flex justify-between">
                            <div>
                                <strong>{{ __('Location') }}:</strong><br>
                                {!! nl2br(e($event->location)) !!}
                            </div>
                            <div class="self-center">
                                <h4 class="text-orange-700 dark:text-orange-300">{{ __('Ticket Price') }}</h4>
                                <p class="text-white dark:text-gray-400 self-end">
                                    {{ $event->ticket->price }}.00 $</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
