<div x-data = "{isOpen: false, addCommentText: '{{ __('Add a comment') }}'}">

    <div x-show="isOpen">
        <form action="" wire:submit.prevent="submit">
            @csrf
            <input type="hidden" wire:model="user_id">
            <input type="hidden" wire:model="blog_id">

            <textarea name="body" id="body" cols="30" rows="1" class="w-full" wire:model = 'body'></textarea>
            <button type="submit"
                class="rounded p-2  bg-orange-400 hover:text-black hover:bg-white hover:border hover:border-orange-400 ml-3 dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400">
                {{ __('Add a comment') }}</button>
        </form>
    </div>
    <button type="button" x-on:click = "isOpen = !isOpen" x-text = "!isOpen ? addCommentText : 'cancel'"
        class="rounded p-2  bg-orange-400 hover:text-black hover:bg-white hover:border hover:border-orange-400 ml-3 dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400">
    </button>
</div>
