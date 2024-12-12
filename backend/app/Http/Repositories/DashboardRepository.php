<?php

namespace App\Http\Repositories;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Orders;

class DashboardRepository
{

    public function total_users()
    {
        $total = User::count();

        return $total;
    }


    public function total_orders()
    {
        $total = Orders::count();

        return $total;
    }


    public function latest_users()
    {
        $users = User::orderBy('id','desc')->take(4)->get();

        return $users;
    }

}

?>
