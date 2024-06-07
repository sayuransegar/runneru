<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Runner Registration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <!-- Display Delivery Status -->
                        <div id="delivery-status" class="text-center text-4xl mt-4" style="font-size: 1.5rem;">
                            @php
                                $approval = app('App\Http\Controllers\RunnerController')->approval();
                            @endphp

                            @if ($approval === null)
                                <span class="animate__animated animate__bounce animate__infinite animate__slower" style="display: inline-block;">P</span>
                                <span class="animate__animated animate__bounce animate__infinite animate__slower" style="display: inline-block; animation-delay: 0.1s;">e</span>
                                <span class="animate__animated animate__bounce animate__infinite animate__slower" style="display: inline-block; animation-delay: 0.2s;">n</span>
                                <span class="animate__animated animate__bounce animate__infinite animate__slower" style="display: inline-block; animation-delay: 0.3s;">d</span>
                                <span class="animate__animated animate__bounce animate__infinite animate__slower" style="display: inline-block; animation-delay: 0.4s;">i</span>
                                <span class="animate__animated animate__bounce animate__infinite animate__slower" style="display: inline-block; animation-delay: 0.5s;">n</span>
                                <span class="animate__animated animate__bounce animate__infinite animate__slower" style="display: inline-block; animation-delay: 0.6s;">g</span>
                                <span class="animate__animated animate__bounce animate__infinite animate__slower" style="display: inline-block; animation-delay: 0.7s;">.</span>
                                <span class="animate__animated animate__bounce animate__infinite animate__slower" style="display: inline-block; animation-delay: 0.8s;">.</span>
                                <span class="animate__animated animate__bounce animate__infinite animate__slower" style="display: inline-block; animation-delay: 0.9s;">.</span>
                            @elseif ($approval === '0')
                                Rejected
                            @elseif ($approval === '1')
                                Approved
                            @else
                                Unknown
                            @endif
                        </div>
                        <form action="{{ route('cancelregistration') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="flex items-center justify-center mt-4">
                                @if ($approval === null)
                                    <x-danger-button class="ms-4">
                                        {{ __('Cancel Registration') }}
                                    </x-danger-button>
                                @elseif ($approval === '0')
                                    <x-danger-button class="ms-4">
                                        {{ __('Re-register') }}
                                    </x-danger-button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
</x-app-layout>
