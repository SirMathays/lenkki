<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\User;

use Auth;

class HomeController extends Controller
{
    /**
     * Return a xp top list
     * @author Matti
     *
     * @param  int     $limit     0
     * @param  int     $year      NULL
     * @param  int     $month     NULL
     * @return array
     */
    public function xpTopList($limit = 0, $year = NULL, $month = NULL) {

        $data = User::select('users.id', 'users.name', 'users.avatar')->xpTopList($month, $year);

        if($limit)
            $data->limit($limit);

        $data = $data->get();
        
        foreach($data as &$row) {
            $row->comparison = compare($row->user_xp, $data[0]->user_xp).'%';
        }

        return $data->toArray();
    }

    /**
     * Return 10 most recent activities
     * @author Matti
     *
     * @return object
     */
    public function recentActivities() {
        
        $data = Activity::orderBy('performed_at', 'DESC')->orderBy('updated_at', 'DESC')->limit(10)->get();

        return $data;
    }

    /**
     * Return activities related to user
     * @author Matti
     *
     * @param  int  $rowId
     * @return object
     */
    public function userActivities($rowId) {
        
        $data = Activity::where('user_id', $rowId)->orderBy('performed_at', 'DESC')->orderBy('updated_at', 'DESC')->get();

        return $data;
    }

    /**
     * Show the application dashboard.
     * @author Matti
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
