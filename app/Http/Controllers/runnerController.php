<?php

namespace App\Http\Controllers;

use App\Models\runner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class runnerController extends Controller
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
        $runnerregisters = Runner::with('user')->get();

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


}
