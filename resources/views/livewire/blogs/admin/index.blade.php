<div class="overflow-x-auto p-4 bg-gray-200 shadow rounded dark:bg-gray-600 ">
    <table class="min-w-full divide-y divide-gray-200 text-sm text-left ">
        <thead class="bg-gray-100 text-gray-700 uppercase text-xs dark:text-white dark:bg-gray-800 text-center">
            <tr class=" whitespace-nowrap">
                <th class="px-4 py-2"> <button wire:click = "orderBy('title')">{{ __('Title') }}</button></th>
                <th class="px-4 py-2"> <button wire:click = "orderBy('slug')"> {{ __('Slug') }}</button></th>
                <th class="px-4 py-2"><button wire:click = "orderBy('body')"> {{ __('Body') }}</button></th>
                <th class="px-4 py-2 "><button wire:click = "orderBy('publish')">
                        {{ __('Published') }}</button></th>
                <th class="px-4 py-2"><button wire:click = "orderBy('keywords')"> {{ __('Keywords') }} </button></th>
                <th class="px-4 py-2"><button wire:click = "orderBy('image')"> {{ __('Image') }} </button></th>
                <th class="px-4 py-2"> {{ __('Written by') }}</th>
                <th class="px-4 py-2"> {{ __('Action') }} </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($blogs as $blog)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                    <td class="px-3 py-2 font-medium text-gray-800 dark:text-white dark:text-bold">
                        {{ Str::words($blog->title, 5, '...') }}</td>
                    <td class="px-3 py-2 dark:text-white">{{ $blog->slug }}</td>
                    <td class="px-3 py-2 dark:text-white">{!! Str::words($blog->body, 5, '...') !!}</td>
                    <td class="px-3 py-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" {{ $blog->publish ? 'checked' : '' }} class="sr-only peer"
                                wire:click = "togglePublish({{ $blog->id }})">
                            <div
                                class="w-11 h-6 bg-red-500 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </td>
                    <td class="px-3 py-2 dark:text-white">{{ $blog->keywords }}</td>
                    <td class="px-3 py-2">
                        @if ($blog->image)
                            <img src="{{ asset($blog->image) }}" alt="Blog Image"
                                class="w-16 h-16 object-cover rounded">
                        @else
                            <span class="text-gray-400 italic">No image</span>
                        @endif
                    </td>
                    <td class="px-3 py-2 dark:text-white">{{ $blog->user->name ?? 'Unknown' }}</td>
                    <td class="px-3 py-2">
                        <div class="flex gap-2">
                            <button class="text-blue-600 hover:underline">Edit</button>
                            <button class="text-red-600 hover:underline">Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination Links --}}
    <div class="mt-4">
        {{ $blogs->links() }}
    </div>
</div>
