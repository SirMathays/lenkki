<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\User;

use Auth;

class HomeController extends Controller
{
    /**
     * Returns a top list
     *
     * @param  string  $listType
     * @param  int     $limit     0
     * @return array
     */
    public function topList($listType, $limit = 0) {

        if($limit > 0)
            $data = User::select('users.id', 'users.name', 'users.avatar')->$listType()->limit($limit)->get();
        else
            $data = User::select('users.id', 'users.name', 'users.avatar')->$listType()->get();
        
        foreach($data as &$row) {
            $row->avatar = $row->avatar_url;
            $row->comparison = compare($row->score, $data[0]->score).'%';
        }

        return $data->toArray();
    }

    /**
     * Returns 10 most recent activities
     *
     * @return object
     */
    public function recentActivities() {
        
        $data = Activity::orderBy('performed_at', 'DESC')->orderBy('updated_at', 'DESC')->limit(10)->get();

        foreach($data as &$row) {
            $row->date = $row->performed_at->format('j.n.Y');
            $row->type = $row->activityType->name;
        }

        return $data;
    }

    /**
     * Returns activities related to the user
     *
     * @param  int $rowId
     * @return object
     */
    public function userActivities($rowId) {
        
        $data = Activity::where('user_id', $rowId)->orderBy('performed_at', 'DESC')->orderBy('updated_at', 'DESC')->get();

        foreach($data as &$row) {
            $row->date = $row->performed_at->format('j.n.Y');
            $row->type = $row->activityType->name;
        }

        return $data;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
