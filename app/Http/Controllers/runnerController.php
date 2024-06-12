<?php

namespace App\Http\Controllers;

use App\Models\Runner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Session;

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

        if ($request->hasFile('cardmatric')) {
            //upload to cloudinary
            $path = 'runneru/cardmatric';
            $file = $request->file('cardmatric')->getClientOriginalName();

            $fileName = pathinfo($file, PATHINFO_FILENAME);

            $publicId = date('Y-m-d_His'). '_'. $fileName;
            $cardmatric = Cloudinary::upload($request->file('cardmatric')->getRealPath(),
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
            'cardmatric' => $cardmatric,
            'approval' => $request->approval,
            'status' => $request->status,
        ];

        Runner::create($data);

        Session::flash('success', 'Runner registration successfully applied!');
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
            
            Session::flash('success', 'Delivery canceled successfully');
            return Redirect::route('dashboard');
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

        Session::flash('success', 'Approval status updated successfully!');
        return redirect()->back();
    }

    public function listrunner(Request $request)
    {
        $search = $request->input('search');
    
        $query = Runner::with('user')->where('approval', '1');
    
        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('studid', 'like', '%' . $search . '%');
            });
        }
    
        $listrunners = $query->get();
    
        return view('auth.listrunner', compact('listrunners', 'search'));
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

    public function blockRunner($id)
    {
        $user = User::findOrFail($id);
    
        // Update the 'blocked' status on the User model
        $user->update(['blocked' => true]);
    
        // Find the related runner and update the status to offline
        $runner = Runner::where('userid', $id)->first();
        if ($runner) {
            $runner->update(['status' => 'offline']);
        }
        
        Session::flash('success', 'Runner blocked and set to offline successfully');
        return redirect()->route('listrunner');
    }
    
    public function unblockRunner($id)
    {
        $user = User::findOrFail($id);
    
        // Update the 'blocked' status on the User model
        $user->update(['blocked' => false]);
    
        // Find the related runner and update the status to online
        $runner = Runner::where('userid', $id)->first();
        if ($runner) {
            $runner->update(['status' => 'online']);
        }
    
        Session::flash('success', 'Runner unblocked and set to online successfully');
        return redirect()->route('listrunner');
    }
    

}
