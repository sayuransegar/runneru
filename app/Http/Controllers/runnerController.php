<?php

namespace App\Http\Controllers;

use App\Models\runner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class runnerController extends Controller
{
    public function storerunner(Request $request){
        //dd($request->all());

        $filename = '';

        if ($request->hasFile('qrcode')) {
            $filename = $request->getSchemeAndHttpHost() . '/assets/img/' . time() . '.' . $request->qrcode->extension();
            $request->qrcode->move (public_path('/assets/img/'), $filename);
        }

        $data = [
            'userid' => Auth::id(),
            'hostel' => $request->hostel,
            'reason' => $request->reason,
            'qrcode' => $filename,
            'approval' => $request->approval,
        ];

        Runner::create($data);

        return redirect()->route('dashboard');
    }

    public function listrunnerregistration(){
        $runnerregisters = Runner::with('user')->get();

        return view('auth.listrunnerregistration', compact('runnerregisters'));
    }
}
