<?php

namespace App\Http\Controllers;

use App\Models\PartnerShipPlans;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $plans= PartnerShipPlans::where('Status',1)->get();
        return view('home')->with('plans',$plans);
    }
}
