<?php

namespace App\Http\Controllers;

use App\Models\runner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class RunnerController extends Controller
{
    public function storerunner(Request $request){

        $fileName = '';

        if ($request->hasFile('qrcode')) {
            //upload to cloudinary
            $path = 'runneru/qrcode';
            $file = $request->file('qrcode')->getClientOriginalName();

            $fileName = pathinfo($file, PATHINFO_FILENAME);

            $publicId = date('Y-m-d_His'). '_'. $fileName;
            $upload = Cloudinary::upload($request->file('qrcode')->getRealPath(),
            [
            "public_id" => $publicId,
            "folder" => $path 
            ])->getSecurePath();
        }


        $data = [
            'userid' => Auth::id(),
            'hostel' => $request->hostel,
            'reason' => $request->reason,
            'qrcode' => $upload,
            'approval' => $request->approval,
            'status' => $request->status,
        ];

        Runner::create($data);

        return redirect()->route('runnerregistered');
    }

    public function hasRunnerRegistration()
    {
        // Get the current user's ID
        $userId = Auth::id();
        
        // Query the delivery table to check if a delivery request exists for the user
        $runnerRegistrationExists = Runner::where('userid', $userId)->exists();
        
        return $runnerRegistrationExists;
    }

    public function approval(){
        // Get the current user's ID
        $userId = Auth::id();

        // Query the delivery table to get the latitude and longitude values
        $approvals = Runner::where('userid', $userId)->first();
        if ($approvals) {
            $approval = $approvals->approval;
            return $approval;
        } else {
            return 'No registration found';
        }
    }


    public function listrunnerregistration(){
        $runnerregisters = Runner::with('user')->where('approval', NULL)->get();

        return view('auth.listrunnerregistration', compact('runnerregisters'));
    }

    public function cancelregistration()
    {
        // Get the current user's delivery record
        $registration = Runner::where('userid', Auth::id())->first();

        if ($registration) {
            // Delete the delivery record
            $registration->delete();
            
            return Redirect::route('dashboard')->with('success', 'Delivery canceled successfully');
        } else {
            return Redirect::route('dashboard')->with('error', 'No delivery found to cancel');
        }
    }

    public function showRunnerRegistration($id)
    {
        $runnerRegistration = Runner::with('user')->find($id);

        if (!$runnerRegistration) {
            return redirect()->route('listrunnerregistration')->with('error', 'Runner registration not found.');
        }

        return view('auth.runnerapproval', compact('runnerRegistration'));
    }

    public function updateApproval(Request $request, $id)
    {
        $runner = Runner::findOrFail($id);
        $runner->approval = $request->approval;
        $runner->save();

        return redirect()->back()->with('status', 'Approval status updated successfully!');
    }

    public function listrunner(){
        $listrunners = Runner::with('user')->where('approval', '1')->get();

        return view('auth.listrunner', compact('listrunners'));
    }

    public function showApprovedRunner($id)
    {
        $approvedrunner = Runner::with('user')->where('approval', '1')->find($id);
    
        if (!$approvedrunner) {
            return redirect()->route('approvedrunner')->with('error', 'Runner registration not found.');
        }
    
        return view('auth.approvedrunner', compact('approvedrunner'));
    }
    
    public function updateStatus(Request $request)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|string|in:online,offline',
        ]);

        // Get the current user
        $user = Auth::user();

        // Find the runner associated with the current user
        $runner = Runner::where('userid', $user->id)->first();

        if ($runner) {
            // Update the runner status
            $runner->status = $request->status;
            $runner->save();

            return response()->json(['success' => true, 'status' => $runner->status]);
        } else {
            return response()->json(['success' => false, 'message' => 'Runner not found.'], 404);
        }
    }

    public function showDashboard()
    {
        $user = Auth::user();
        $runner = Runner::where('userid', $user->id)->first();

        if (!$runner) {
            return redirect()->route('runnerdashboard')->with('error', 'You are not a registered runner.');
        }

        return view('runnerdashboard', compact('runner'));
    }

}
