<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return redirect()->route('dashboard');
    }
}
