<x-app-layout>

    <div class="py-12 dark:text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class=" p-3 grid grid-cols-8 gap-4 dark:bg-slate-600">
                    <div class="shadow-xl p-3 col-span-3 dark:bg-gray-800">
                            <img src="{{ asset($user->img) }}" alt="{{ $user->name }}">
                            <p>{{$user->name}}</p>
                            @if ($user->adress != null)
                                <p>{{$user->adress->city}}</p>
                                <p>{{$user->adress->country}}</p>
                            @else 
                            <p>User not verified yet</p>
                            @endif
                            <p>{{$user->phone}}</p>
                            <p>{{$user->email}}</p>
                            <button
                 class="rounded p-1 bg-orange-400  hover:text-black hover:bg-white hover:border hover:border-orange-400  dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400 text-sm">
                <a href="#"> {{ __('Add friend') }}</a>
                </button>
                    </div>
                    <div class="col-span-4">
                        @if ($user->biography != null)
                        <p>{{$user->biography->title}}</p>
                        {!! $user->biography->biography !!}
                        @else
                        <p>User not verified yet</p>
                        @endif
                        <h2>{{__("Commneds")}}</h2>
                            <p>To be continued...</p>
                    </div>    
                </div>              
            </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mt-4">
                    <h2>{{__('Badges')}}</h2>
                </div>
        </div>
    </div>
</x-app-layout>

