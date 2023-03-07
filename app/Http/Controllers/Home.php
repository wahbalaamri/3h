<?php

namespace App\Http\Controllers;

use App\Models\PartnerShipPlans;
use Illuminate\Http\Request;

class Home extends Controller
{
    //
    public function index()
    {
        $plans= PartnerShipPlans::where('Status',1)->get();
        return view('home.index')->with('plans',$plans);
    }
}
