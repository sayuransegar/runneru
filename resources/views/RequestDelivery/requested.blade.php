<x-app-layout onload="initMap()">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Delivery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if ($status == null)
                    <div id="pending-card" class="p-6 text-center text-gray-900 bg-white shadow-lg rounded-lg">
                        <div role="status" class="text-center">
                            <svg aria-hidden="true" class="inline w-20 h-20 text-gray-200 animate-spin dark:text-white-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <div class="mt-4 text-xl">Pending...</div>
                        </div>
                        <div class="mt-4 form-control block w-full" id="travel-time"></div>
                        <div class="mt-4" id="map" style="height: 500px; width: 100%;"></div>
                        <form action="{{ route('canceldelivery') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="flex items-center justify-center mt-4">
                                <x-danger-button class="ms-4">
                                    {{ __('Cancel Delivery') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </div>
                @elseif ($status == '1')
                    <div id="accepted-card" class="p-6 text-center text-gray-900 bg-white shadow-lg rounded-lg">
                        <div class="flex flex-col items-center mb-4">
                            <div>
                                <h3 class="text-2xl font-bold">Delivery Accepted</h3>
                                <p class="text-gray-600 mt-4">Your Runner Has Accepted Your Delivery!</p>
                            </div>
                        </div>
                    </div>
                @elseif ($status == '2')
                    <div id="out-for-delivery-card" class="p-6 text-center text-gray-900 bg-white shadow-lg rounded-lg">
                        <div class="flex flex-col items-center mb-4">
                            <div>
                                <h3 class="text-2xl font-bold">Out For Delivery</h3>
                                <p class="text-gray-600 mt-4">Your Delivery is On The Way!</p>
                            </div>
                            <div class="mt-4">
                                <img id="qrCodeImage" src="{{ $qrCodeUrl }}" alt="QR Code" class="w-50 h-50">
                            </div>
                            <div class="mt-4">
                                <button id="downloadButton" type="button" class="px-5 py-2.5 text-sm font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                                    </svg>
                                    Download Image
                                </button>
                            </div>
                            <div class="mt-4 text-xl">
                                @if($paymentDetails)
                                    <p>Item Price: RM{{ number_format($paymentDetails->itemprice, 2) }}</p>
                                    <p>Charge Fee: RM{{ number_format($paymentDetails->servicecharge, 2) }}</p>
                                    <p class="font-bold">Total Price: RM{{ number_format($paymentDetails->itemprice + $paymentDetails->servicecharge, 2) }}</p>
                                @else
                                    <p>Item Price: RM0.00</p>
                                    <p>Charge Fee: RM0.00</p>
                                    <p class="font-bold">Total Price: RM0.00</p>
                                @endif
                            </div>
                            <div class="mt-4">
                                @if($receiptUploaded)
                                    <div class="text-green-600 font-bold">You have successfully uploaded the receipt!</div>
                                @else
                                    <form action="{{ route('uploadReceipt') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="deliveryid" value="{{ $deliveryid }}">
                                        <div class="mt-4">
                                            <x-input-label for="receipt" :value="__('Upload Receipt')" />
                                            <x-text-input type="file" name="receipt" id="receipt" class="block mt-1 w-full border border-gray-300" />
                                        </div>
                                        <div class="flex items-center justify-center mt-4">
                                            <x-primary-button class="ms-4">
                                                {{ __('Submit') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif ($status == '3')
                    <div id="delivered-card" class="p-6 text-center text-gray-900 bg-white shadow-lg rounded-lg">
                        <div class="flex flex-col items-center mb-4">
                            <div>
                                <h3 class="text-2xl font-bold">Delivered</h3>
                                <p class="text-gray-600 mt-4">Your Delivery Has Been Successfully Delivered!</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button id="openReportModal" type="button" class="px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300">
                                Report Runner
                            </button>
                        </div>
                    </div>
                @elseif ($status == '0')
                    <div id="rejected-card" class="p-6 bg-red-100 border border-red-400 text-red-700 rounded-lg text-center">
                        <div class="flex flex-col items-center mb-4">
                            <div>
                                <h3 class="text-2xl font-bold">Delivery Rejected</h3>
                                <p class="text-gray-600 mt-4">Your Delivery Has Been Rejected.</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button id="openReportModal" type="button" class="px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300">
                                Report Runner
                            </button>
                        </div>
                    </div>
                @else
                    <div id="no-delivery-card" class="p-6 text-center text-gray-900 bg-white shadow-lg rounded-lg">
                        <div class="flex flex-col items-center mb-4">
                            <div>
                                <h3 class="text-2xl font-bold">No Delivery Found</h3>
                                <p class="text-gray-600 mt-4">No Delivery Details Available.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="reportModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <h3 class="text-lg font-medium text-gray-800">Report Runner</h3>
                    <button id="closeReportModal" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            <!-- Report Modal Form -->
            <form action="{{ route('reportstorerunner') }}" method="post">
                @csrf
                <input type="hidden" name="userid" value="{{ auth()->user()->id }}">
                <input type="hidden" name="deliveryid" value="{{ $deliveryid }}">
                <input type="hidden" name="runnerid" value="{{ $deliveryDetails->runnerid }}">
                <input type="hidden" name="reporterid" value="{{ auth()->user()->id }}">
                <input type="hidden" name="reportedid" value="{{ $deliveryDetails->runnerid }}">
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
    <script>
        const deliveryDetails = {
            shoplat: <?php echo json_encode($deliveryDetails->shoplat); ?>,
            shoplng: <?php echo json_encode($deliveryDetails->shoplng); ?>,
            deliverylat: <?php echo json_encode($deliveryDetails->deliverylat); ?>,
            deliverylng: <?php echo json_encode($deliveryDetails->deliverylng); ?>
        };

        console.log('deliveryDetails:', deliveryDetails);

        function downloadImage(url) {
            fetch(url, { mode: 'cors' })
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'qr-code.png';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    window.URL.revokeObjectURL(url);
                })
                .catch(console.error);
        }

        document.getElementById('downloadButton').addEventListener('click', function (e) {
            e.preventDefault();
            downloadImage('{{ $qrCodeUrl }}');
        });
    </script>
    <script>
        document.getElementById('openReportModal').addEventListener('click', function () {
            document.getElementById('reportModal').classList.remove('hidden');
        });

        document.getElementById('closeReportModal').addEventListener('click', function () {
            document.getElementById('reportModal').classList.add('hidden');
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/direction.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwIBxZagluW6TDJ6Y0bgNgmsN240X7gHM&libraries=places&callback=initMap"></script>
</x-app-layout>
