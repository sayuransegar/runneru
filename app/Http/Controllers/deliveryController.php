<?php

namespace App\Http\Controllers;

use App\Events\RequestDelivery;
use App\Models\Delivery;
use App\Models\runner;
use App\Models\payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
        $deliveryid = $deliveryDetails->id;
        $paymentDetails = Payment::where('deliveryid', $deliveryid)->first();
    
        return view('RequestDelivery.acceptdelivery', compact('deliveryid', 'deliveryDetails', 'status', 'paymentDetails'));
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
    
    public function requested($id)
    {
        $deliveryDetails = Delivery::with('user')->find($id);
    
        if (!$deliveryDetails) {
            return redirect()->route('requested')->with('error', 'Runner registration not found.');
        }
    
        $status = $deliveryDetails->status; // Get the status of the delivery
        $deliveryid = $deliveryDetails->id;
    
        $runner = Runner::find($deliveryDetails->runnerid);
        $qrCodeUrl = $runner->qrcode;
    
        $paymentDetails = Payment::where('deliveryid', $id)->first();
        
        $receiptUploaded = $paymentDetails ? $paymentDetails->receipt : null;
    
        return view('RequestDelivery.requested', compact('receiptUploaded', 'deliveryid','deliveryDetails', 'status', 'qrCodeUrl', 'paymentDetails'));
    }
    
    public function uploadReceipt(Request $request){
        $fileName = '';

        if ($request->hasFile('receipt')) {
            //upload to cloudinary
            $path = 'runneru/receipt';
            $file = $request->file('receipt')->getClientOriginalName();

            $fileName = pathinfo($file, PATHINFO_FILENAME);

            $publicId = date('Y-m-d_His'). '_'. $fileName;
            $upload = Cloudinary::upload($request->file('receipt')->getRealPath(),
            [
            "public_id" => $publicId,
            "folder" => $path 
            ])->getSecurePath();
        }

        if ($upload) {
            $payment = Payment::where('deliveryid', $request->deliveryid)->first();
    
            if ($payment) {
                $payment->receipt = $upload;
                $payment->save();
            }
        }

        return redirect()->back()->with('success', 'Receipt uploaded successfully.');
    }

    public function statistics()
    {
        // Get the current authenticated user's ID
        $userId = auth()->id();

        // Query MongoDB to get delivery statistics by month
        $statistics = Delivery::where('runnerid', $userId)
            ->where('status', 3)
            ->raw(function ($collection) {
                return $collection->aggregate([
                    [
                        '$group' => [
                            '_id' => ['$month' => '$created_at'],
                            'count' => ['$sum' => 1]
                        ]
                    ],
                    [
                        '$sort' => ['_id' => 1]
                    ]
                ]);
            });
            

        // Format data for the chart
        $data = [];
        foreach ($statistics as $statistic) {
            $data[date('M', mktime(0, 0, 0, $statistic->_id, 1))] = $statistic->count;
        }

        return response()->json($data);
    }

}
