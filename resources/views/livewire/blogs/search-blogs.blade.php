 <div class="relative" x-data = "{isOpen: true}" @click.away = 'isOpen = false' @keydown.escape = 'isOpen = false'
     @keydown.window="if (event.keyCode === 191) { event.preventDefault(); $refs.searchDropdown.focus(); }">
     <div class="flex rounded-full border border-orange-400 p-2 dark:border-orange-600">
         <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 self-center fill-orange-400"
             viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
             <path
                 d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
         </svg>
         <input x-ref="searchDropdown" @focus = "isOpen = true" type="text" @keydown.escape="$el.blur()"
             wire:model.live.debounce.300ms="search" placeholder=" {{ __('Search for blogs') }}"
             class="h-7 w-48 focus:border-none border-none focus:outline-none focus:ring-0 focus:border-transparent dark:bg-gray-800 dark:text-white">
         <div role="status" class="p-1" wire:loading>
             <svg aria-hidden="true" class="w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                 viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                 <path
                     d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                     fill="currentColor" />
                 <path
                     d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                     fill="currentFill" />
             </svg>
         </div>
     </div>
     <div x-show ="isOpen"
         class="w-56 rounded font-semibold text-sm  text-gray-800 dark:text-gray-200 leading-tight self-center absolute bg-white dark:bg-gray-600 z-10 flex flex-col">
         @if (strlen($this->search) >= 3)
             @if ($blogs->isEmpty())
                 <p>{{ __('No search results for') }} {{ $search }}</p>
             @endif
             @foreach ($blogs as $blog)
                 <a href="{{ route('blogs.show', $blog->slug) }}">

                     <div class="flex justify-between h-20 p-2">
                         <span>{{ $blog->title }}</span>
                         @if ($blog->image)
                             <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}"
                                 class="w-10 h-full object-cover">
                         @endif
                     </div>
                 </a>
             @endforeach
         @endif
     </div>

 </div>
