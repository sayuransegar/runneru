<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\runner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

class DeliveryController extends Controller
{
    public function store(Request $request)
    {
        $data = [
            'userid' => Auth::id(),
            'runnerid' => $request->runnerid,
            'item' => $request->item,
            'addinstruct' => $request->addinstruct,
            'price' => $request->price,
            'shoplocation' => $request->shoplocation,
            'shoplat' => $request->shoplat,
            'shoplng' => $request->shoplng,
            'deliverylocation' => $request->deliverylocation,
            'deliverylat' => $request->deliverylat,
            'deliverylng' => $request->deliverylng,
            'status' => $request->status,
        ];

        $delivery = Delivery::create($data); // Create the delivery record

        return redirect()->route('requested', ['id' => $delivery->id]); // Redirect with the ID of the new delivery
    }

    public function hasDeliveryRequest()
    {
        // Get the current user's ID
        $userId = Auth::id();
        
        // Query the delivery table to check if a delivery request exists for the user
        $deliveryRequestExists = Delivery::where('userid', $userId)->exists();
        
        return $deliveryRequestExists;
    }

    public function showLocation()
    {
        // Get the current user's ID
        $userId = Auth::id();
        
        // Query the delivery table to get the latitude and longitude values
        $delivery = Delivery::where('userid', $userId)->first();
        
        // Pass the latitude and longitude values to the view
        if ($delivery) {
            return Response::json([
                'shopLat' => $delivery->shoplat,
                'shopLng' => $delivery->shoplng,
                'deliveryLat' => $delivery->deliverylat,
                'deliveryLng' => $delivery->deliverylng,
            ]);
        } else {
            return Response::json(['error' => 'No coordinates found for the current user'], 404);
        }
    }

    // Method to cancel the delivery
    public function cancelDelivery()
    {
        // Get the current user's delivery record
        $delivery = Delivery::where('userid', Auth::id())->first();

        if ($delivery) {
            // Delete the delivery record
            $delivery->delete();
            
            return Redirect::route('dashboard')->with('success', 'Delivery canceled successfully');
        } else {
            return Redirect::route('dashboard')->with('error', 'No delivery found to cancel');
        }
    }

    public function status(){
        // Get the current user's ID
        $userId = Auth::id();

        // Query the delivery table to get the latitude and longitude values
        $delivery = Delivery::where('userid', $userId)->first();
        if ($delivery) {
            $deliveryStatus = $delivery->status;
            return $deliveryStatus;
        } else {
            return 'No delivery found';
        }
    }

    
    public function showOnlineRunner()
    {
        $runners = Runner::where('approval', '1')->where('status', 'online')->with('user')->get();

        return view('RequestDelivery.requestdelivery', compact('runners'));
    }
    
    public function listDeliveries()
    {
        $user = Auth::user();


        $runner = $user->runner;
        $listdeliveries = Delivery::where('runnerid', $runner->_id)->get();

        return view('RequestDelivery.runnerdelivery', compact('listdeliveries'));
    }

    public function acceptDelivery($id){
        $deliveryDetails = Delivery::with('user')->find($id);
    
        if (!$deliveryDetails) {
            return redirect()->route('acceptdelivery')->with('error', 'Runner registration not found.');
        }
    
        $status = $deliveryDetails->status; // Get the status of the delivery
    
        return view('RequestDelivery.acceptdelivery', compact('deliveryDetails', 'status'));
    }
    

    public function updateStatus(Request $request, $id)
    {
        $deliveryStatus = Delivery::findOrFail($id);
        $deliveryStatus->status = $request->status;
        $deliveryStatus->save();
    
        if ($request->status == '1') {
            // If accepted, redirect to the same view but with the card-after-accept visible
            return redirect()->route('acceptdelivery', ['id' => $id])->with('accepted', true);
        } elseif ($request->status == '3') {
            // If accepted, redirect to the same view but with the card-after-accept visible
            return redirect()->route('acceptdelivery', ['id' => $id])->with('accepted', true);
        } else {
            // If rejected, redirect to the dashboard
            return redirect()->route('runnerdashboard')->with('status', 'Approval status updated successfully!');
        }
    }

    public function deliverylist()
    {
        $user = Auth::user();

        $listdeliveries = Delivery::where('userid', $user->_id)->get();

        return view('RequestDelivery.deliverylist', compact('listdeliveries'));
    }
    
    public function requested($id){
        $deliveryDetails = Delivery::with('user')->find($id);
    
        if (!$deliveryDetails) {
            return redirect()->route('requested')->with('error', 'Runner registration not found.');
        }
    
        $status = $deliveryDetails->status; // Get the status of the delivery
    
        return view('RequestDelivery.requested', compact('deliveryDetails', 'status'));
    }
}
