<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Toggle Buttons for Sections -->
                    <div class="mb-4">
                        <button onclick="toggleSection('reported-customer')" class="mr-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Reported Customers
                        </button>
                        <button onclick="toggleSection('reported-runner')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Reported Runners
                        </button>
                    </div>

                    <!-- Section for Reported Customers -->
                    <div id="reported-customer" style="display: none;">
                        <h3 class="text-lg font-bold mb-2">Reported Customers</h3>
                        <!-- Search Form -->
                        <form id="searchCustomerForm">
                            <div class="flex items-center mb-4">
                                <input type="text" name="searchcustomer" placeholder="Search by Student ID" class="form-input rounded-md shadow-sm mt-1 block w-full">
                                <x-primary-button type="submit" class="ml-3">
                                    {{ __('Search') }}
                                </x-primary-button>
                            </div>
                        </form>
                        <table class="table table-bordered dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="border-bottom: 2px solid #e2e8f0; margin-bottom: 10px;">
                                <tr>
                                    <th>Name</th>
                                    <th>Student ID</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody id="reportedCustomersTableBody" style="margin-top: 10px;">
                                @foreach($reportedCustomers as $customer)
                                <tr>
                                    <td>{{ optional($customer->reportedUser)->name }}</td>
                                    <td>{{ optional($customer->reportedUser)->studid }}</td>
                                    <td>{{ optional($customer->reportedUser)->email }}</td>
                                    <td>{{ optional($customer->reportedUser)->phonenum }}</td>
                                    <td>{{ $customer->reason }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Section for Reported Runners -->
                    <div id="reported-runner" style="display: none;">
                        <h3 class="text-lg font-bold mb-2">Reported Runners</h3>
                        <!-- Search Form -->
                        <form id="searchRunnerForm">
                            <div class="flex items-center mb-4">
                                <input type="text" name="searchrunner" placeholder="Search by Student ID" class="form-input rounded-md shadow-sm mt-1 block w-full">
                                <x-primary-button type="submit" class="ml-3">
                                    {{ __('Search') }}
                                </x-primary-button>
                            </div>
                        </form>
                        <table class="table table-bordered dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="border-bottom: 2px solid #e2e8f0; margin-bottom: 10px;">
                                <tr>
                                    <th>Name</th>
                                    <th>Student ID</th>
                                    <th>Hostel</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody id="reportedRunnersTableBody" style="margin-top: 10px;">
                                @foreach($reportedRunners as $reportedRunner)
                                <tr>
                                    <td>{{ optional($reportedRunner->reportedRunner->user)->name }}</td>
                                    <td>{{ optional($reportedRunner->reportedRunner->user)->studid }}</td>
                                    <td>{{ optional($reportedRunner->reportedRunner)->hostel }}</td>
                                    <td>{{ $reportedRunner->reason }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleSection(sectionId) {
            // Hide all sections
            document.getElementById('reported-customer').style.display = 'none';
            document.getElementById('reported-runner').style.display = 'none';

            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
        }

        // Handle search form submissions with AJAX
        $('#searchCustomerForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting the traditional way
            var searchcustomer = $('input[name="searchcustomer"]').val();

            $.ajax({
                url: '<?php echo route('reported-users'); ?>',
                method: 'GET',
                data: { searchcustomer: searchcustomer },
                success: function(response) {
                    $('#reportedCustomersTableBody').html(response.customersHtml);
                    toggleSection('reported-customer'); // Ensure the correct section is displayed
                }
            });
        });

        $('#searchRunnerForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting the traditional way
            var searchrunner = $('input[name="searchrunner"]').val();

            $.ajax({
                url: '<?php echo route('reported-users'); ?>',
                method: 'GET',
                data: { searchrunner: searchrunner },
                success: function(response) {
                    $('#reportedRunnersTableBody').html(response.runnersHtml);
                    toggleSection('reported-runner'); // Ensure the correct section is displayed
                }
            });
        });
    </script>
</x-app-layout>
