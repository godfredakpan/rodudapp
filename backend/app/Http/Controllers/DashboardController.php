<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Repositories\DashboardRepository;
use App\Http\Repositories\UserRepository;

class DashboardController extends Controller
{
    /**
     * The Dashboard
     *
     * @var object
     */
    private $dashboard;
    private $user;

    public function __construct(DashboardRepository $dashboard, UserRepository $user)
    {
        $this->dashboard = $dashboard;

        $this->user = $user;
    }


    public function index()
    {

        $user = Auth::user();

        if($user->is_admin == false){
            Auth::logout();
            return redirect()->route('login');
        }

        $latest_users = $this->dashboard->latest_users();

        $total_users = $this->dashboard->total_users();

        $total_orders = $this->dashboard->total_orders();

        $completed_orders = $this->dashboard->completed_orders();

        $searching_orders = $this->dashboard->searching_orders();

        $transit_orders = $this->dashboard->transit_orders();

        return view('dashboard', compact('total_users', 'latest_users', 'total_orders', 'completed_orders', 'searching_orders', 'transit_orders'));
    
    }
}
