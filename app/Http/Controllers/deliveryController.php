<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
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

        Delivery::create($data);

        return redirect()->route('requested');
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
    
}
