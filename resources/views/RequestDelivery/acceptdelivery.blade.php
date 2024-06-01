<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Runner Registration Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if ($status == '1')
                    <!-- Card After Accept -->
                    <div id="card-after-accept" class="p-6 text-gray-900">
                        <h3 class="text-xl font-semibold mb-4">Payment Details</h3>
                        <form action="{{ route('submitpayment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="userid" value="{{ $deliveryDetails->user->id }}">
                            <input type="hidden" name="runnerid" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="deliveryid" value="{{ $deliveryDetails->id }}">

                            <div class="mt-4">
                                <!-- Item Price -->
                                <x-input-label for="itemprice" :value="__('Item Price (RM)')" />
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">RM</span>
                                    <x-text-input type="number" name="itemprice" id="itemprice" class="block pl-10 mt-1 w-full" min="0" step="0.01" required />
                                </div>
                            </div>
                            <div class="mt-4">
                                <!-- Service Charge -->
                                <x-input-label for="servicecharge" :value="__('Service Charge (RM)')" />
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">RM</span>
                                    <x-text-input type="number" name="servicecharge" id="servicecharge" class="block pl-10 mt-1 w-full" min="0" step="0.01" required />
                                </div>
                            </div>
                            <div class="flex items-center justify-center mt-4">
                                <x-primary-button class="ms-4">
                                    {{ __('Submit') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                @elseif ($status == '2')
                    <!-- Out For Delivery Card -->
                    <div id="card-out-for-delivery" class="p-6 text-center text-gray-900 bg-white shadow-lg rounded-lg">
                        <div class="flex flex-col items-center mb-4">
                            <div>
                                <h3 class="text-2xl font-bold">Out For Delivery</h3>
                                <p class="text-gray-600 mt-4">Update Delivery Status If Customer Received The Item!</p>
                            </div>
                        </div>
                        <form action="{{ route('deliverystatusupdate', $deliveryDetails->id) }}" method="POST" class="mt-6">
                            @csrf
                            <div class="flex justify-center">
                                <button type="submit" name="status" value="3" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                                    {{ __('Update Status') }}
                                </button>
                            </div>
                        </form>
                    </div>
                @elseif ($status == '3')
                    <!-- Delivered Card -->
                    <div id="card-delivered" class="p-6 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        <div class="flex items-center justify-center mb-4">
                            <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="text-center">
                            <h3 class="text-xl font-semibold">Delivery Delivered</h3>
                            <p class="text-gray-600">Your delivery has been successfully completed.</p>
                        </div>
                        <div class="mt-4 flex justify-center">
                            <button id="openReportModal" type="button" class="px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300">
                                Report Customer
                            </button>
                        </div>
                    </div>
                @elseif ($status == '0')
                    <!-- Delivery Reject Card -->
                    <div id="card-rejected" class="p-6 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Delivery Rejected</h3>
                        <p class="mb-4">You rejected this delivery. Here are the details:</p>
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$deliveryDetails->user->name" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="studid" :value="__('Student ID')" />
                            <x-text-input id="studid" class="block mt-1 w-full" type="text" name="studid" :value="$deliveryDetails->user->studid" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="phonenum" :value="__('Phone Number')" />
                            <x-text-input id="phonenum" class="block mt-1 w-full" type="text" name="phonenum" :value="$deliveryDetails->user->phonenum" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="item" :value="__('Item')" />
                            <x-text-input id="item" class="block mt-1 w-full" type="text" name="item" :value="$deliveryDetails->item" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="addinstruct" :value="__('Additional Instruction')" />
                            <textarea id="addinstruct" class="block mt-1 w-full border-gray-300 py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="addinstruct" rows="5" readonly>{{ $deliveryDetails->addinstruct }}</textarea>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="$deliveryDetails->price" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="shoplocation" :value="__('Shop Location')" />
                            <x-text-input id="shoplocation" class="block mt-1 w-full" type="text" name="shoplocation" :value="$deliveryDetails->shoplocation" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="deliverylocation" :value="__('Delivery Location')" />
                            <x-text-input id="deliverylocation" class="block mt-1 w-full" type="text" name="deliverylocation" :value="$deliveryDetails->deliverylocation" readonly />
                        </div>
                        <div class="mt-4 flex justify-center">
                            <button id="openReportModal" type="button" class="px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300">
                                Report Customer
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Card Before Accept -->
                    <div id="card-before-accept" class="p-6 text-gray-900">
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$deliveryDetails->user->name" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="studid" :value="__('Student ID')" />
                            <x-text-input id="studid" class="block mt-1 w-full" type="text" name="studid" :value="$deliveryDetails->user->studid" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="phonenum" :value="__('Phone Number')" />
                            <x-text-input id="phonenum" class="block mt-1 w-full" type="text" name="phonenum" :value="$deliveryDetails->user->phonenum" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="item" :value="__('Item')" />
                            <x-text-input id="item" class="block mt-1 w-full" type="text" name="item" :value="$deliveryDetails->item" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="addinstruct" :value="__('Additional Instruction')" />
                            <textarea id="addinstruct" class="block mt-1 w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="addinstruct" rows="5" readonly>{{ $deliveryDetails->addinstruct }}</textarea>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="$deliveryDetails->price" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="shoplocation" :value="__('Shop Location')" />
                            <x-text-input id="shoplocation" class="block mt-1 w-full" type="text" name="shoplocation" :value="$deliveryDetails->shoplocation" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="deliverylocation" :value="__('Delivery Location')" />
                            <x-text-input id="deliverylocation" class="block mt-1 w-full" type="text" name="deliverylocation" :value="$deliveryDetails->deliverylocation" readonly />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="travel-time" :value="__('Travel Time')" />
                            <x-text-input id="travel-time" class="block mt-1 w-full" type="text" name="travel-time" readonly />
                        </div>
                        <div id="map" style="height: 500px; width: 100%;" class="mb-4"></div>
                        <form action="{{ route('deliverystatusupdate', $deliveryDetails->id) }}" method="POST" class="mt-6">
                            @csrf
                            <div class="flex justify-center">
                                <x-primary-button name="status" value="1" class="bg-green-500 hover:bg-green-700">
                                    {{ __('Accept') }}
                                </x-primary-button>
                                <x-danger-button name="status" value="0" class="bg-red-500 hover:bg-red-700 ms-4">
                                    {{ __('Reject') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <!-- Modal -->
        <div id="reportModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
                    <div class="flex justify-between items-center border-b pb-2 mb-4">
                        <h3 class="text-lg font-medium text-gray-800">Report Customer</h3>
                        <button id="closeReportModal" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                <!-- Report Modal Form -->
                <form action="{{ route('reportstorecustomer') }}" method="post">
                    @csrf
                    <input type="hidden" name="userid" value="{{ auth()->user()->id }}"> <!-- Runner's User ID -->
                    <input type="hidden" name="deliveryid" value="{{ $deliveryDetails->id }}"> <!-- Delivery ID -->
                    <input type="hidden" name="runnerid" value="{{ $deliveryDetails->runner->id }}"> <!-- Runner's ID from Runner database -->
                    <input type="hidden" name="reporterid" value="{{ $deliveryDetails->runner->id }}"> <!-- Runner's ID from Runner database -->
                    <input type="hidden" name="reportedid" value="{{ $deliveryDetails->user->id }}"> <!-- Customer's User ID -->
                    <div class="mb-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                        <textarea id="reason" name="reason" rows="4" class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300">
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/runner.js"></script>
    <script>
        const deliveryDetails = {
            shoplat: <?php echo json_encode($deliveryDetails->shoplat); ?>,
            shoplng: <?php echo json_encode($deliveryDetails->shoplng); ?>,
            deliverylat: <?php echo json_encode($deliveryDetails->deliverylat); ?>,
            deliverylng: <?php echo json_encode($deliveryDetails->deliverylng); ?>
        };

        console.log('deliveryDetails:', deliveryDetails);
    </script>
    <script>
        document.getElementById('openReportModal').addEventListener('click', function () {
            document.getElementById('reportModal').classList.remove('hidden');
        });

        document.getElementById('closeReportModal').addEventListener('click', function () {
            document.getElementById('reportModal').classList.add('hidden');
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwIBxZagluW6TDJ6Y0bgNgmsN240X7gHM&libraries=places&loading=async&callback=initMap" async defer></script>
</x-app-layout>
