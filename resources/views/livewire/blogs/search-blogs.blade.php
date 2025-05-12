<div class="relative" x-data = "{isOpen: true}" @click.away = 'isOpen = false' @keydown.escape = 'isOpen = false'
    @keydown.window="if (event.keyCode === 191) { event.preventDefault(); $refs.searchDropdown.focus(); }"

>   <div class="flex rounded-full border border-orange-400 p-2 dark:border-orange-600">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 self-center fill-orange-400" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
    <input x-ref="searchDropdown" @focus = "isOpen = true" type="text" 
    @keydown.escape="$el.blur()" 
    wire:model.live="search" placeholder=" {{ __('Search for blogs') }}" 
    class="h-7 w-48 focus:border-none border-none focus:outline-none focus:ring-0 focus:border-transparent dark:bg-gray-800 dark:text-white">
</div>
    <div x-show ="isOpen" class="w-56 rounded font-semibold text-sm  text-gray-800 dark:text-gray-200 leading-tight self-center absolute bg-white dark:bg-gray-600 w-48 z-10 flex flex-col">
    @if (strlen($this->search) >= 3)
        @if ($blogs->isEmpty())            
            <p>{{ __("No search results for") }} {{$search}}</p>
        @endif
        @foreach ($blogs as $blog)
        <div class="flex justify-between h-20 p-2">
            <span>{{$blog->title }}</span>
            @if($blog->image)
            <img src="{{ asset($blog->image) }}"
                alt="{{ $blog->title }}"
                class="w-10 h-full object-cover">
        @endif
        </div>
        @endforeach
    @endif
</div>
 </div>

 