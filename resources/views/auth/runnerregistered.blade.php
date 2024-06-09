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
                        <div id="delivery-status" class="text-center mt-4">
                            @php
                                $approval = app('App\Http\Controllers\RunnerController')->approval();
                            @endphp

                            @if ($approval === null)
                                <div class="pending-card card">
                                    <div class="status">Pending...</div>
                                    <div class="message">Please wait for admin approval.</div>
                                </div>
                            @elseif ($approval === '0')
                                <div class="rejected-card card">
                                    <div class="status">Rejected</div>
                                    <div class="message">Your registration has been rejected.</div>
                                </div>
                            @elseif ($approval === '1')
                                <div class="approved-card card">
                                    <div class="status">Approved</div>
                                    <div class="message">Your registration has been approved!</div>
                                </div>
                            @else
                                <div class="unknown-card card">
                                    <div class="status">Unknown</div>
                                    <div class="message">Status not available.</div>
                                </div>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .card {
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .status {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .message {
            font-size: 18px;
        }

        .pending-card {
            background-color: #ffcc00; /* Yellow */
            color: #333; /* Dark Gray */
        }

        .rejected-card {
            background-color: #ff3300; /* Red */
            color: #fff; /* White */
        }

        .approved-card {
            background-color: #00cc00; /* Green */
            color: #fff; /* White */
        }

        .unknown-card {
            background-color: #f0f0f0; /* Light Gray */
            color: #333; /* Dark Gray */
        }
    </style>
</x-app-layout>
