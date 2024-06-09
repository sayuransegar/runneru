<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function storepayment(Request $request)
    {

        // Create the payment data array with receipt set to null
        $paymentData = [
            'runnerid' => $request->runnerid,
            'userid' => $request->userid,
            'deliveryid' => $request->deliveryid,
            'itemprice' => $request->itemprice,
            'servicecharge' => $request->servicecharge,
            'receipt' => null, // Set receipt to null
        ];

        // Store the payment data in the database
        Payment::create($paymentData);

        // Update the delivery status
        $delivery = Delivery::find($request->deliveryid);
        if ($delivery) {
            $delivery->status = '2'; // Assuming 2 is the status for a completed payment
            $delivery->save();
        }

        Session::flash('success', 'Payment details submitted successfully and delivery status updated.');
        // Redirect to a specific route with the delivery ID
        return redirect()->route('acceptdelivery', ['id' => $request->deliveryid]);
    }
}

