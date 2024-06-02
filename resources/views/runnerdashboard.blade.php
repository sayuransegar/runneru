<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Runner Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold mb-4">Welcome Runner, {{ Auth::user()->name }}!</h3>
                        <p class="text-gray-600">Here you can manage your deliveries and view your performance statistics.</p>
                    </div>

                    <!-- Runner Status -->
                    <div class="flex items-center justify-end mb-6">
                        <span class="text-lg font-semibold me-2">Your Status:</span>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" id="status-toggle" {{ $runner->status == 'online' ? 'checked' : '' }}>
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:rtl:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-black" id="status-label">{{ $runner->status == 'online' ? 'Online' : 'Offline' }}</span>
                        </label>
                    </div>

                    <!-- Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        @php
                            // Count total deliveries made by the runner
                            $totalDeliveries = App\Models\Delivery::whereHas('runner', function ($query) {
                                $query->where('userid', Auth::id());
                            })->count();
                        @endphp
                        <div class="bg-blue-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Total Deliveries</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $totalDeliveries }}</p>
                        </div>
                        @php
                            // Count completed deliveries made by the runner
                            $completedDeliveries = App\Models\Delivery::where('status', '3')
                                ->whereHas('runner', function ($query) {
                                    $query->where('userid', Auth::id());
                                })->count();
                        @endphp
                        <div class="bg-green-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Completed Deliveries</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $completedDeliveries }}</p>
                        </div>
                        @php
                            // Count pending deliveries made by the runner
                            $pendingDeliveries = App\Models\Delivery::where('status', null)
                                ->whereHas('runner', function ($query) {
                                    $query->where('userid', Auth::id());
                                })->count();
                        @endphp
                        <div class="bg-yellow-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Pending Deliveries</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $pendingDeliveries }}</p>
                        </div>
                        @php
                            // Count rejected deliveries made by the runner
                            $rejectedDeliveries = App\Models\Delivery::where('status', '0')
                                ->whereHas('runner', function ($query) {
                                    $query->where('userid', Auth::id());
                                })->count();
                        @endphp
                        <div class="bg-red-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Rejected Deliveries</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $rejectedDeliveries }}</p>
                        </div>
                    </div>

                    <!-- Add more content as needed -->
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusToggle = document.getElementById('status-toggle');
            const statusLabel = document.getElementById('status-label');

            statusToggle.addEventListener('change', function () {
                const isChecked = statusToggle.checked;
                statusLabel.textContent = isChecked ? 'Online' : 'Offline';

                // Update the runner status in the backend (AJAX or form submission)
                fetch('{{ route("runner.updateStatus") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ status: isChecked ? 'online' : 'offline' }),
                }).then(response => response.json()).then(data => {
                    if (!data.success) {
                        alert('Failed to update status.');
                        statusToggle.checked = !isChecked;
                        statusLabel.textContent = !isChecked ? 'Online' : 'Offline';
                    }
                }).catch(error => {
                    alert('An error occurred.');
                    statusToggle.checked = !isChecked;
                    statusLabel.textContent = !isChecked ? 'Online' : 'Offline';
                });
            });
        });
    </script>
</x-app-layout>
