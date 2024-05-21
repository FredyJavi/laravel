<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chirps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{route('chirps.store')}}">
                        @csrf
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Message</label>
                        <textarea name="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe tu mensage...">{{ old('message') }}</textarea>
                        <button class="mt-2 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                            Enviar
                        </button>
                        @error('message') {{$message}}@enderror
                    </form>
                </div>
            </div>

            <!-- listando lo guardado -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg divide-y dark:divide-gray-900">
                @foreach($chirps as $chirp)
                    <div class="p-6 flex space-x-2">
                        <svg class="h-6 w-6 text-gray-600 dark:text-gray-400 -scale-x-100" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"></path>
                        </svg>
                <p>{{$chirp->message}}</p>
            </div>
            <a href="{{route('chirps.edit',$chirp)}}">{{__('Edit Chirp')}}</a>
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-gray-800 dark:text-gray-200">
                            {{$chirp->user->name}}
                        </span>
                        <small class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                    @can('update',$chirp)

                    <small class="text-sm text-gray-600 dark:text-gray-400"> &middot; {{ __('edited') }}</small>
                    <x-dropdown>
                        <x-slot name="trigger">
                            <button>
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <button><!-- edit -->
                                <x-dropdown-link href="{{route('chirps.edit',$chirp)}}" >{{__('Edit Chirp')}}</x-dropdown-link>
                             <!-- eliminar se envia el parametro del id-->
                             <form method="POST" action="{{route('chirps.destroy',$chirp)}}">
                                @csrf() @method('DELETE')
                                <x-dropdown-link href="{{route('chirps.destroy',$chirp)}}"
                                    onclick="event.preventDefault();this.closest('form').submit()" >
                                    {{__('Delete Chirp')}}
                                </x-dropdown-link>
                             </form>

                            </button>
                        </x-slot>

                    </x-dropdown>

                    @endcan()


                    </div>

                </div>
            @endforeach
            </div>
        </div>
    </div>
</x-app-layout>


