<?php

namespace App\Http\Controllers;

use App\Models\Kit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


        $perday = DB::table('prt.PartsKitData')
            ->select("prt.users.name",DB::raw("count(prt.PartsKitData.KitID) as QtyCaptured"))
            ->leftJoin('prt.users', 'prt.PartsKitData.UserID', '=', 'prt.users.id')
            ->whereBetween('prt.PartsKitData.created_at', [Carbon::today(), Carbon::tomorrow()])
            ->groupBy("prt.users.name")
            ->get();

        $perweek = DB::table('prt.PartsKitData')
            ->select("prt.users.name",DB::raw("count(prt.PartsKitData.KitID) as QtyCaptured"))
            ->leftJoin('prt.users', 'prt.PartsKitData.UserID', '=', 'prt.users.id')
            ->whereBetween('prt.PartsKitData.created_at', [Carbon::today()->subDays(7), Carbon::tomorrow()])
            ->groupBy("prt.users.name")
            ->get();

        $permonth = DB::table('prt.PartsKitData')
            ->select("prt.users.name",DB::raw("count(prt.PartsKitData.KitID) as QtyCaptured"))
            ->leftJoin('prt.users', 'prt.PartsKitData.UserID', '=', 'prt.users.id')
            ->whereBetween('prt.PartsKitData.created_at', [Carbon::today()->subDays(30), Carbon::tomorrow()])
            ->groupBy("prt.users.name")
            ->get();

        $lifetime = DB::table('prt.PartsKitData')
            ->select("prt.users.name",DB::raw("count(prt.PartsKitData.KitID) as QtyCaptured"))
            ->leftJoin('prt.users', 'prt.PartsKitData.UserID', '=', 'prt.users.id')
            ->groupBy("prt.users.name")
            ->get();



        return view('home',compact('perday','perweek','permonth','lifetime'));
    }
}
