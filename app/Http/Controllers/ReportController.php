<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Runner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function storeReportedRunner(Request $request){
        // Validate the request data
        $request->validate([
            'runnerid' => 'required|string',
            'userid' => 'required|string',
            'deliveryid' => 'required|string',
            'reporterid' => 'required|string',
            'reportedid' => 'required|string',
            'reason' => 'required|string|max:255',
        ]);

        // Create the report data array
        $reportData = [
            'runnerid' => $request->runnerid,
            'userid' => $request->userid,
            'deliveryid' => $request->deliveryid,
            'reporterid' => $request->reporterid,
            'reportedid' => $request->reportedid,
            'reason' => $request->reason,
        ];

        // Store the report data in the database
        Report::create($reportData);

        return redirect()->route('runner-reports')->with('success', 'Report submitted successfully.');
    }

    public function storeReportedCustomer(Request $request){
        // Validate the request data
        $request->validate([
            'runnerid' => 'required|string',
            'userid' => 'required|string',
            'deliveryid' => 'required|string',
            'reporterid' => 'required|string',
            'reportedid' => 'required|string',
            'reason' => 'required|string|max:255',
        ]);

        // Create the report data array
        $reportData = [
            'runnerid' => $request->runnerid,
            'userid' => $request->userid,
            'deliveryid' => $request->deliveryid,
            'reporterid' => $request->reporterid,
            'reportedid' => $request->reportedid,
            'reason' => $request->reason,
        ];

        // Store the report data in the database
        Report::create($reportData);

        return redirect()->route('customer-reports')->with('success', 'Report submitted successfully.');
    }

    public function showReportedRunner(Request $request)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Get the search term from the request
        $searchTerm = $request->input('search');

        // Fetch the reports for the logged-in user, optionally filtered by the search term
        $runnerReportLists = Report::with(['runner.user', 'user'])
            ->where('userid', $user->id)
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->whereHas('runner.user', function ($query) use ($searchTerm) {
                    $query->where('studid', 'like', '%' . $searchTerm . '%');
                });
            })
            ->get();

        // Pass the data to the view
        return view('Report.customerreport', compact('runnerReportLists'));
    }

    public function showReportedCustomer(Request $request)
    {
        $runnerId = Auth::user()->runner->id;
        
        // Get the search query
        $search = $request->input('search');
        
        // Query builder for runner's reports
        $query = Report::where('runnerid', $runnerId)->with('reportedUser');
        
        // If search query is provided, filter reports by user ID
        if ($search) {
            $query->whereHas('reportedUser', function ($query) use ($search) {
                $query->where('studid', 'like', '%' . $search . '%');
            });
        }
    
        // Filter out reports where the runner is also the reporter
        $query->where('reporterid', '=', $runnerId);
        
        // Fetch the reports
        $customerReportLists = $query->get();
        
        // Override the user data with the reported user data
        $customerReportLists->transform(function ($report) {
            $report->reportedid = $report->reportedUser;
            return $report;
        });
        
        return view('Report.runnerreport', compact('customerReportLists'));
    }

    public function showReportedUsers(Request $request)
    {
        // Get search queries
        $searchCustomer = $request->input('searchcustomer');
        $searchRunner = $request->input('searchrunner');
    
        // Query for reported customers
        $reportedCustomersQuery = Report::whereHas('reportedUser', function ($query) {
            $query->where('usertype', 'customer');
        })->with(['reportedUser']);
    
        // If search query for customers is provided
        if ($searchCustomer) {
            $reportedCustomersQuery->whereHas('reportedUser', function ($query) use ($searchCustomer) {
                $query->where('studid', 'like', '%' . $searchCustomer . '%');
            });
        }
    
        $reportedCustomers = $reportedCustomersQuery->get();
    
        // Query for reported runners
        $reportedRunnersQuery = Report::whereHas('reportedRunner')->with(['reportedRunner.user']);
    
        // If search query for runners is provided
        if ($searchRunner) {
            $reportedRunnersQuery->whereHas('reportedRunner.user', function ($query) use ($searchRunner) {
                $query->where('studid', 'like', '%' . $searchRunner . '%');
            });
        }
    
        $reportedRunners = $reportedRunnersQuery->get();

        // Build HTML for reported customers
        $customersHtml = '';
        foreach ($reportedCustomers as $customer) {
            $customersHtml .= '<tr>';
            $customersHtml .= '<td>' . optional($customer->reportedUser)->name . '</td>';
            $customersHtml .= '<td>' . optional($customer->reportedUser)->studid . '</td>';
            $customersHtml .= '<td>' . optional($customer->reportedUser)->email . '</td>';
            $customersHtml .= '<td>' . optional($customer->reportedUser)->phonenum . '</td>';
            $customersHtml .= '<td>' . $customer->reason . '</td>';
            $customersHtml .= '</tr>';
        }
    
        // Build HTML for reported runners
        $runnersHtml = '';
        foreach ($reportedRunners as $reportedRunner) {
            $runnersHtml .= '<tr>';
            $runnersHtml .= '<td>' . optional($reportedRunner->reportedRunner->user)->name . '</td>';
            $runnersHtml .= '<td>' . optional($reportedRunner->reportedRunner->user)->studid . '</td>';
            $runnersHtml .= '<td>' . optional($reportedRunner->reportedRunner)->hostel . '</td>';
            $runnersHtml .= '<td>' . $reportedRunner->reason . '</td>';
            $runnersHtml .= '</tr>';
        }
    
        // Check if the request is AJAX
        if ($request->ajax()) {
            return response()->json(['customersHtml' => $customersHtml, 'runnersHtml' => $runnersHtml]);
        }
    
        return view('Report.adminreport', compact('reportedCustomers', 'reportedRunners'));
    }
    
}
