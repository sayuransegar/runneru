<?php

namespace App\Http\Controllers;

use App\Models\delivery;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class deliveryController extends Controller
{
    public function store(Request $request)
    {
        $data = ([
            'userid'=> $request->userid,
            'runnerid'=> $request->runnerid,
            'item'=> $request->item,
            'addinstruct'=> $request->addinstruct,
            'price'=> $request->price,
            'shoplocation'=> $request->shoplocation,
            'shoplat'=> $request->shoplat,
            'shoplng'=> $request->shoplng,
            'deliverylocation'=> $request->deliverylocation,
            'deliverylat'=> $request->deliverylat,
            'deliverylng'=> $request->deliverylng,
            'status'=> $request->request,
        ]);
        delivery::create($data);

        return redirect()->route('dashboard');

    }
    

}
