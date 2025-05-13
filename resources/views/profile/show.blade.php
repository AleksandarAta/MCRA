<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                {{-- {{ dd(Auth::user()->load('adress')) }} --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class=" p-3 grid grid-cols-8 gap-4 dark:bg-slate-600">
                    <div class="shadow-xl p-3 col-span-3 dark:bg-gray-800">
                            <img src="{{ asset(Auth::user()->img) }}" alt="{{ Auth::user()->name }}">
                            <p>{{Auth::user()->name}}</p>
                            @if (Auth::user()->load('adress')->adress != null)
                                <p>{{Auth::user()->load('adress')->adress->city}}</p>
                                <p>{{Auth::user()->load('adress')->adress->country}}</p>
                            @else 
                            <p> User not verified yet</p>
                            @endif
                            <p>{{Auth::user()->phone}}</p>
                            <p>{{Auth::user()->email}}</p>
                            <button
                 class="rounded p-1 bg-orange-400  hover:text-black hover:bg-white hover:border hover:border-orange-400  dark:bg-orange-600 dark:text-white dark:hover:text-black dark:hover:bg-white dark:hover:border-orange-400 text-sm">
                <a href="#"> {{ __('Add friend') }}</a>
                </button>
                    </div>
                    <div class="col-span-4">
                        @if (Auth::user()->load('biography')->biography != null)
                        <p>{{Auth::user()->load('biography')->biography->title}}</p>
                        <p>{!! Auth::user()->load('biography')->biography->biography !!}</p>
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




            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    <livewire:profile.delete-user-form/>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
